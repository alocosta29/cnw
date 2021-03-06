<?php
App::uses('File', 'Utility');
/**
 *
 * @property AclManagerComponent $AclManager
 */
class AclManagerComponent extends Component {
    public $components = array(
        'Auth',
        'Acl',
        'Acl.AclReflector',
        'Session'
    );
    private $Controller = null;
    private $controllerHashFile;
    private $Aco;
    /**
     * Initialize the ACL Manager Component
     *
     * @param Controller $controller
     */
    public function initialize(Controller $controller) {
        $this->Controller = $controller;
        $this->controllerHashFile = CACHE . 'persistent' . DS . 'controller_hash.txt';
    }
    /**
     * Check if the file containing the stored controllers hashes can be
     * created, and create it if it does not exist
     *
     * @return boolean true if the file exists or could be created
     */
    private function checkControllerHashFile() {
        if (!empty($this->controllerHashFile)){
            if (is_writable(dirname($this->controllerHashFile))) {
                $File = new File($this->controllerHashFile, true);
                return $File->exists();
            } else {
                $this->Session->setFlash(
                    sprintf(__d('acl', 'The %s directory is not writable'),
                        dirname($this->controllerHashFile)), 'flash_error', null,
                    'plugin_acl');
            }
        } else {
        $this->Session->setFlash(
            __d('acl', 'The controller hash file does not exist'),
                'flash_error', null,
            'plugin_acl');
        }
        return false;
    }
    /**
     * Checks to see if the given model is set to act as an ACL requester or set to act as
     * both a requested and controlled object
     *
     * @param unknown $modelClassName
     * @return boolean
     */
    public function checkAclRequester($modelClassName) {
        $model = $this->getModelInstance($modelClassName);
        $behaviors = $model->actsAs;
        if (! empty($behaviors) && array_key_exists('Acl', $behaviors)) {
            $aclBehavior = $behaviors['Acl'];
            if ($aclBehavior == 'requester' || $aclBehavior == 'both') {
                return true;
            } elseif (
                is_array($aclBehavior) &&
                isset($aclBehavior['type']) &&
                ($aclBehavior['type'] == 'requester' || $aclBehavior['type'] == 'both')
            ) {
                return true;
            }
        }
        return false;
    }
    /**
     * Check if a given fieldExpression is an existing fieldname for the given
     * model If it doesn't exist, a virtual field called
     * 'proacl_display_name' is created with the given expression
     *
     * @param string $modelClassName
     * @param string $fieldExpression
     * @return string The name of the field to use as display name
     */
    public function setDisplayName($modelClassName, $fieldExpression) {
        $modelInstance = $this->getModelInstance($modelClassName);
        $schema = $modelInstance->schema();
        if (
            array_key_exists($fieldExpression, $schema) ||
            array_key_exists(str_replace($modelClassName . '.', '', $fieldExpression), $schema) ||
            array_key_exists($fieldExpression, $modelInstance->virtualFields)
            ) {
            /* The field does not need to be created as it already exists in the
             * model as a datatable field, or a virtual field configured in the
             * model
             */
            /*
             * Remove the model name
             */
            if (strpos($fieldExpression, $modelClassName . '.') === 0) {
                $fieldExpression = str_replace($modelClassName . '.', '',$fieldExpression);
            }
            return $fieldExpression;
        } else {
            /* The field does not exist in the model -> create a virtual field
             * with the given expression */
            $this->Controller->{$modelClassName}->virtualFields['proacl_display_name'] = $fieldExpression;
            return 'proacl_display_name';
        }
    }
    /**
     * Return an instance of the given model name
     *
     * @param string $modelClassName
     * @return Model
     */
    private function getModelInstance($modelClassName) {
        if (! isset($this->Controller->{$modelClassName})) {
            /* Do not use $this->Controller->loadModel, as calling it from a
             * plugin may prevent correct loading of behaviors */
            $modelInstance = ClassRegistry::init($modelClassName);
        } else {
            $modelInstance = $this->Controller->{$modelClassName};
        }
        return $modelInstance;
    }
    /**
     * return the stored array of controllers hashes
     *
     * @return array
     */
    public function getStoredControllerHash() {
        if ($this->checkControllerHashFile()) {
            $File = new File($this->controllerHashFile);
            $content = $File->read();
            if (! empty($content)) {
                $controllerHash = unserialize($content);
            } else {
                $controllerHash = array();
            }
            return $controllerHash;
        }
    }
    /**
     * return an array of all controllers hashes
     *
     * @return array
     */
    public function getCurrentControllerHash() {
        $controllers = $this->AclReflector->getAllControllers();
        $currentControllerHash = array();
        foreach ($controllers as $controller) {
            $File = new File($controller['file']);
            $currentControllerHash[$controller['name']] = $File->md5();
        }
        return $currentControllerHash;
    }
    /**
     * Return ACOs paths that should exist in the ACO datatable but do not exist
     */
    public function getMissingAcos() {
        $actions = $this->AclReflector->getAllActions();
        $controllers = $this->AclReflector->getAllControllers();
        $actionsAcoPaths = array();
        $actionsAcoPaths[] = 'controllers';
        foreach ($actions as $action) {
            $actionPath = explode('/', $action);
            $controller = $actionPath[count($actionPath) - 2];
            if ($controller != 'App') {
                $actionsAcoPaths[] = 'controllers/' . $action;
            }
        }
        foreach ($controllers as $controller) {
            if ($controller['name'] != 'App') {
                $actionsAcoPaths[] = 'controllers/' . $controller['name'];
            }
        }
        //$actionsAcoPaths[] = 'controllers';
        $this->Aco =& $this->Acl->Aco;
        $acos = $this->Aco->find('all',
            array(
                'recursive' => - 1
            ));
        $existingAcoPaths = array();
        foreach ($acos as $acoNode) {
            $pathNodes = $this->Aco->getPath($acoNode['Aco']['id']);
            $path = '';
            foreach ($pathNodes as $pathNode) {
                $path .= '/' . $pathNode['Aco']['alias'];
            }
            $path = substr($path, 1);
            $existingAcoPaths[] = $path;
        }
        $missingAcos = array_diff($actionsAcoPaths, $existingAcoPaths);
        return $missingAcos;
    }
    /**
     * Store missing ACOs for all actions in the datasource If necessary, it
     * creates actions parent nodes (plugin and controller) as well
     */
    public function createAcos() {
        $this->Aco =& $this->Acl->Aco;
        $log = array();
        $controllers = $this->AclReflector->getAllControllers();
        //$this->log('Controllers' . $controllers);
         // Create root 'controllers' node if it does not exist
        $root = $this->Aco->node('controllers');
        if (empty($root)) {
            $root = $this->addRootNode();
            if(!empty($root)) {
                $log[] = __d('acl', 'Created Aco node for controllers');
            }
        } else {
            $root = $root[0];
        }
        //Loop through each Controller to see if we have ACO nodes for the objects
        foreach ($controllers as $controller) {
            $controllerName = $controller['name'];
            if ($controllerName !== 'App') {
                $pluginName = $this->AclReflector->getPluginName($controllerName);
                $pluginNode = null;
                if (! empty($pluginName)) {
                    // If this is a Plugin Controller get the Controller name
                    //$this->log('Plugin Name: ' . $pluginName);
                    $controllerName = $this->AclReflector->getPluginControllerName($controllerName);
                     //Check for a Plugin Node
                    $pluginNode = $this->Aco->node('controllers/' . $pluginName);
                    if (empty($pluginNode)) {
                        // plugin node does not exist -> create it
                        $pluginNode = $this->addPluginNode($root['Aco']['id'], $pluginName);
                        if (!empty($pluginNode)) {
                            $log[] = sprintf(
                            __d('acl', 'Created Aco node for %s plugin'),
                            $pluginName);
                        }
                    }
                }
                // Check to see if we have a Controller Node
                $controllerNode = $this->Aco->node(
                    'controllers/' . (! empty($pluginName) ? $pluginName . '/' : '') . $controllerName);
                if (empty($controllerNode)) {
                    // controller node does not exist -> create it
                    $controllerNode = $this->addControllerNode($controllerName, $root['Aco']['id'], $pluginNode);
                    if (!empty($controllerNode)) {
                        $loggedController = $controllerName;
                        if(!empty($pluginName)) {
                            $loggedController = $pluginName . '/' . $controllerName;
                        }
                        $log[] = sprintf(__d('acl', 'Created Aco node for %s'),
                            $loggedController);
                    }
                } else {
                    $controllerNode = $controllerNode[0];
                }
        // Check to see if we have a node for each action.
        $actions = $this->AclReflector->getControllerActions($controllerName);
        //$this->log($controllerName . ' Actions: ' . print_r($actions,true));
        foreach ($actions as $action) {
                    $actionNode = $this->Aco->node(
                        'controllers/' . (! empty($pluginName) ? $pluginName . '/' : '') . $controllerName . '/' . $action);
                    if (empty($actionNode)) {
                        // action node does not exist -> create it
                        $methodNode = $this->addActionNode($controllerNode, $action);
                        if (!empty($methodNode)) {
                            $log[] = sprintf(__d('acl', 'Created Aco node for %s'),
                                (! empty($pluginName) ? $pluginName . '/' : '') . $controllerName . '/' . $action);
                        }
                    }
                }
            }
        }
        return $log;
    }
    /**
     * Add the root controllers node.
     * @param unknown $acoId
     * @return unknown
     */
    private function addRootNode() {
        $this->Aco =& $this->Acl->Aco;
        // root node does not exist -> create it
        $this->Aco->create(
            array(
                'parent_id' => null,
                'model' => null,
                'alias' => 'controllers'
            ));
        $root = $this->Aco->save();
        return $root;
    }
    /**
     * Add a node for a Plugin
     * @param unknown $rootAcoId
     * @param unknown $pluginName
     * @return array
     */
    private function addPluginNode($rootAcoId,$pluginName) {
        $this->Aco =& $this->Acl->Aco;
        $this->Aco->create(
            array(
                'parent_id' => $rootAcoId,
                'model' => null,
                'alias' => $pluginName
            ));
        $pluginNode = $this->Aco->save();
        return $pluginNode;
    }
    /**
     * Add a Controller Node
     *
     * @param unknown $controllerName
     * @param unknown $rootAcoId
     * @param unknown $acoId
     * @param string $pluginNode
     * @return unknown
     */
    private function addControllerNode($controllerName, $rootAcoId, $pluginNode = null) {
        $this->Aco =& $this->Acl->Aco;
        if (isset($pluginNode)) {
            // The controller belongs to a plugin
            if (isset($pluginNode[0])) {
                $parentId = $pluginNode[0]['Aco']['id'];
            } else {
                $parentId = $pluginNode['Aco']['id'];
            }
        } else {
            $parentId = $rootAcoId;
        }
            $this->Aco->create(
                array(
                    'parent_id' => $parentId,
                    'model' => null,
                    'alias' => $controllerName
                ));
            $controllerNode = $this->Aco->save();
        return $controllerNode;
    }
    /**
     * Add an Action Node
     *
     * @param unknown $controllerNodeId
     * @param unknown $action
     * @return unknown
     */
    private function addActionNode($controllerNode = null,$action = null) {
        $this->Aco =& $this->Acl->Aco;
        $this->Aco->create(
            array(
                'parent_id' => $controllerNode['Aco']['id'],
                'model' => null,
                'alias' => $action
            ));
        $methodNode = $this->Aco->save();
        return $methodNode;
    }
    /**
     * Update the Controller Hash File
     */
    public function updateControllerHashFile() {
        $currentControllerHash = $this->getCurrentControllerHash();
        $File = new File($this->controllerHashFile);
        return $File->write(serialize($currentControllerHash));
    }
    /**
     * Check to see if the Controller Hash File is out of sync.
     * @return boolean
     */
    public function isControllerHashFileOutOfSync() {
        if ($this->checkControllerHashFile()) {
            $storedControllerHash = $this->getStoredControllerHash();
            $currentControllerHash = $this->getCurrentControllerHash();
            /* Check what controllers have changed */
            $updatedControllers = array_keys(Hash::diff($currentControllerHash,$storedControllerHash));
            if (!empty($updatedControllers)) {
                return true;
            }
        }
        return false;
    }
    /**
     * Get the array of Acos to prune.
     * @return multitype:
     */
    public function getAcosToPrune() {
        $actions = $this->AclReflector->getAllActions();
        $controllers = $this->AclReflector->getAllControllers();
        $plugins = $this->AclReflector->getAllPluginNames();
        $actionsAcoPaths = array();
        foreach ($actions as $action) {
            $actionsAcoPaths[] = 'controllers/' . $action;
        }
        foreach ($controllers as $controller) {
            $actionsAcoPaths[] = 'controllers/' . $controller['name'];
        }
        foreach ($plugins as $plugin) {
            $actionsAcoPaths[] = 'controllers/' . $plugin;
        }
        $actionsAcoPaths[] = 'controllers';
        $this->Aco =& $this->Acl->Aco;
        $acos = $this->Aco->find('all',
            array(
                'recursive' => - 1
            ));
        $existingAcoPaths = array();
        foreach ($acos as $acoNode) {
            $pathNodes = $this->Aco->getPath($acoNode['Aco']['id']);
            if (count($pathNodes) > 1 && $pathNodes[0]['Aco']['alias'] == 'controllers') {
                $path = '';
                foreach ($pathNodes as $pathNode) {
                    $path .= '/' . $pathNode['Aco']['alias'];
                }
                $path = substr($path, 1);
                $existingAcoPaths[] = $path;
            }
        }
        return array_diff($existingAcoPaths, $actionsAcoPaths);
    }
    /**
     * Remove all ACOs that don't have any corresponding controllers or actions.
     *
     * @return array log of removed ACO nodes
     */
    public function pruneAcos() {
        $this->Aco =& $this->Acl->Aco;
        $log = array();
        $pathsToPrune = $this->getAcosToPrune();
        foreach ($pathsToPrune as $pathToPrune) {
            $node = $this->Aco->node($pathToPrune);
            if (! empty($node)) {
                // First element is the last part in path -> we delete it
                if ($this->Aco->delete($node[0]['Aco']['id'])) {
                    $log[] = sprintf(
                        __d('acl', "Aco node '%s' has been deleted"),
                        $pathToPrune);
                } else {
                    $log[] = '<span class="error">' . sprintf(
                        __d('acl', "Aco node '%s' could not be deleted"),
                        $pathToPrune) . '</span>';
                }
            }
        }
        return $log;
    }
    /**
     *
     * @param AclNode $aroNodes The Aro model hierarchy
     * @param string $acoPath The Aco path to check for
     * @param string $permission_type 'deny' or 'allow', 'grant', depending on
     * what permission (grant or deny) is being set
     */
    public function savePermissions($aroNodes, $acoPath, $permissionType) {
if (isset($aroNodes[0])) {
            $acoPath = 'controllers/' . $acoPath;
            $pkName = 'id';
            if ($aroNodes[0]['Aro']['model'] == Configure::read('acl.aro.role.model')) {
                $pkName = $this->Controller->getRolePrimaryKeyName();
            } elseif ($aroNodes[0]['Aro']['model'] == Configure::read(
                'acl.aro.user.model')) {
                $pkName = $this->Controller->getUserPrimaryKeyName();
            }
            $aroModelData = array(
                $aroNodes[0]['Aro']['model'] => array(
                    $pkName => $aroNodes[0]['Aro']['foreign_key']
                )
            );
            $aroId = $aroNodes[0]['Aro']['id'];
            $specificPermissionRight = $this->getSpecificPermissionRight($aroNodes[0], $acoPath);
            $inheritedPermissionRight = $this->getFirstParentPermissionRight($aroNodes[0], $acoPath);
            if (empty($inheritedPermissionRight) && count($aroNodes) > 1) {
                // Get the permission inherited by the parent ARO
                $specificParentAroPermissionRight = $this->getSpecificPermissionRight($aroNodes[1], $acoPath);
                if (isset($specificParentAroPermissionRight)) {
                    /* If there is a specific permission for the parent ARO on
                     * the ACO, the child ARO inheritates this permission
                     */
                    $inheritedPermissionRight = $specificParentAroPermissionRight;
                } else {
                    $inheritedPermissionRight = $this->getFirstParentPermissionRight($aroNodes[1], $acoPath);
                }
            }
            /* Check if the specific permission is necessary to get the correct
             * permission
             */
            if (empty($inheritedPermissionRight)) {
                $specificPermissionNeeded = true;
            } else {
                if ($permissionType == 'allow' || $permissionType == 'grant') {
                    $specificPermissionNeeded = ($inheritedPermissionRight != 1);
                } else {
                    $specificPermissionNeeded = ($inheritedPermissionRight == 1);
                }
            }
            if ($specificPermissionNeeded) {
                if ($permissionType == 'allow' || $permissionType == 'grant') {
                    if ($this->Acl->allow($aroModelData, $acoPath)) {
                        return true;
                    } else {
                        $this->log(__d('acl','An error occured while saving the specific permission'),E_USER_NOTICE);
                        return false;
                    }
                } else {
                    if ($this->Acl->deny($aroModelData, $acoPath)) {
                        return true;
                    } else {
                        $this->log(__d('acl','An error occured while saving the specific permission'),E_USER_NOTICE);
                        return false;
                    }
                }
            } elseif (isset($specificPermissionRight)) {
                $acoNode = $this->Acl->Aco->node($acoPath);
                if (! empty($acoNode)) {
                    $acoId = $acoNode[0]['Aco']['id'];
                    $specificPermission = $this->Acl->Aro->Permission->find(
                        'first',
                        array(
                            'conditions' => array(
                                'aro_id' => $aroId,
                                'aco_id' => $acoId
                            )
                        ));
                    if (!empty($specificPermission)) {
                        if ($this->Acl->Aro->Permission->delete(array('Permission.id' => $specificPermission['Permission']['id']))) {
                            return true;
                        } else {
                            $this->log(__d('acl','An error occured while deleting the specific permission'),E_USER_NOTICE);
                            return false;
                        }
                    } else {
                        /* As $specific_permission_right has a value, we should
                         * never fall here, but who knows... ;-)
                         */
                        $this->log(__d('acl','The specific permission id could not be retrieved'),E_USER_NOTICE);
                        return false;
                    }
                } else {
                    /* As $specific_permission_right has a value, we should
                     * never fall here, but who knows... ;-)
                     */
                    $this->log(__d('acl', 'The child ACO id could not be retrieved'),E_USER_NOTICE);
                    return false;
                }
            }
        } else {
            $this->log(__d('acl', 'Invalid ARO'), E_USER_NOTICE);
            return false;
        }
    }
    /**
     * Get the Permissions for a given node and aco path.
     * @param unknown $aroNode
     * @param unknown $acoPath
     * @return number|NULL
     */
    private function getSpecificPermissionRight($aroNode, $acoPath) {
        $pkName = 'id';
        if ($aroNode['Aro']['model'] == Configure::read('acl.aro.role.model')) {
            $pkName = $this->Controller->getRolePrimaryKeyName();
        } elseif ($aroNode['Aro']['model'] == Configure::read(
            'acl.aro.user.model')) {
            $pkName = $this->Controller->getUserPrimaryKeyName();
        }
        $aroModelData = array(
            $aroNode['Aro']['model'] => array(
                $pkName => $aroNode['Aro']['foreign_key']
            )
        );
        $aroId = $aroNode['Aro']['id'];
        /* Check if a specific permission of the ARO's on the ACO already exists
         * in the datasource =>
         * 1) the ACO node must exist in the ACO table
         * 2) a record with the aro_id and aco_id must exist in the aros_acos
         * table
         */
        $acoId = null;
        $specificPermission = null;
        $specificPermissionRight = null;
        $acoNode = $this->Acl->Aco->node($acoPath);
        if (! empty($acoNode)) {
            $acoId = $acoNode[0]['Aco']['id'];
            $specificPermission = $this->Acl->Aro->Permission->find('first',
                array(
                    'conditions' => array(
                        'aro_id' => $aroId,
                        'aco_id' => $acoId
                    )
                ));
            if ($specificPermission !== false) {
                /* Check the right (grant => true / deny => false) of this
                 * specific permission
                 */
                $specificPermissionRight = $this->Acl->check($aroModelData,
                    $acoPath);
                if (isset($specificPermissioRight)) {
                    // allowed
                    return 1;
                } else {
                    // denied
                    return - 1;
                }
            }
        }
        // no specific permission found
        return null;
    }
    /**
     * get the First Parent Permission for a given Aro Node and Path
     * @param unknown $aroNode
     * @param unknown $acoPath
     * @return number|NULL
     */
    private function getFirstParentPermissionRight($aroNode, $acoPath) {
        $pkName = 'id';
        if ($aroNode['Aro']['model'] == Configure::read('acl.aro.role.model')) {
            $pkName = $this->Controller->getRolePrimaryKeyName();
        } elseif ($aroNode['Aro']['model'] == Configure::read('acl.aro.user.model')) {
            $pkName = $this->Controller->getUserPrimaryKeyName();
        }
        $aroModelData = array(
            $aroNode['Aro']['model'] => array(
                $pkName => $aroNode['Aro']['foreign_key']
            )
        );
        $aroId = $aroNode['Aro']['id'];
        while (strpos($acoPath, '/') !== false && ! isset($parentPermissionright)) {
            $acoPath = substr($acoPath, 0, strrpos($acoPath, '/'));
            $parentAcoNode = $this->Acl->Aco->node($acoPath);
            if (! empty($parentAcoNode)) {
                $parentAcoId = $parentAcoNode[0]['Aco']['id'];
                $parentPermission = $this->Acl->Aro->Permission->find('first',
                    array(
                        'conditions' => array(
                            'aro_id' => $aroId,
                            'aco_id' => $parentAcoId
                        )
                    ));
                if (!empty($parentPermission)) {
                    /* Check the right (grant => true / deny => false) of this
                     * first parent permission
                     */
                    $parentPermissionRight = $this->Acl->check(
                        $aroModelData, $acoPath);
                    if (!empty($parentPermissionRight)) {
                        // allowed
                        return 1;
                    } else {
                        // denied
                        return - 1;
                    }
                }
            }
        }
        // no parent permission found
        return null;
    }
    /**
     * Set the permissions of the authenticated user in Session The session
     * permissions are then used for instance by the AclHtmlHelper->link()
     * function
     */
    public function setSessionPermissions() {
        if (! $this->Session->check('ProAcl.permissions')) {
            $actions = $this->AclReflector->getAllActions();
            $user = $this->Auth->user();
            if (! empty($user)) {
                $user = array(Configure::read('acl.aro.user.model') => $user);
                $permissions = array();
                $permissions = Cache::read('_permissions_' . $user['User']['id'], 'acl');
                if (empty($permissions)) {
                    $permissions = $this->get_user_permissions($user);
                    Cache::write('_permissions_' . $user['User']['id'], $permissions, 'acl');
                }
                
                $this->Session->write('ProAcl.permissions', $permissions);
            }
        }
    }
    
    /**
     * Check for cached permissions. If they do not exist, the get the permissions and write them to the cache.
     * @param string $userId
     * @return multitype:
     */
    public function geUserPermissions($user = null) {
        if(!empty($user))
        {
    
            if (!isset($user['User'])) {
                $user = array('User' => $user);
            }
            if (empty($permissions)) {
                $actions = $this->AclReflector->get_all_actions();
    
                foreach($actions as $action)
                {
                    $aco_path = 'controllers/' . $action;
                    $permissions[$aco_path] = $this->Acl->check($user, $aco_path);
                }
    
                return $permissions;
            }
        }
    
    }
    
}