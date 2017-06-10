<?php
class PermissionsController extends ManagerAppController 
{
	
	public $components = array('RequestHandler', 'Manager.AclManager', 'Manager.AclReflector', 'Manager.PermissionProcessing');
	public $uses = array('Manager.ArosAco', 'Manager.Role', 'Manager.Aco', 'Manager.Menuiten', 'Manager.MenuitensRole');
	
	private $aroId = false;
	private $aroName = false;
	private $AroAcoId = false;
	private $roleId = false;
	
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        if($this->Session->read('Auth.User.role_id') == 1){
            $this->Auth->allow(array('admin_changePermission'));
        }
        
    }
    
    
	public function admin_index($id = null, $numberAba = 0)
	{
		if ( (1==$id) || (2==$id) || (3==$id) ) { # Nao deixa prosseguir se for perfil: (1)Superuser, (2)Administrador ou (3)Publico.
			$this->redirect(array('plugin'=>'manager', 'controller'=>'aros', 'action'=>'index'));
		}	
	
		$this->setAro($id);
		if($this->aroId <> false)
		{
		
			$this->PermissionProcessing->loadPermissions($this->aroId, $this->Session->read('Auth.User.role_id'));		
			$aclPermissions = $this->PermissionProcessing->getAcoPermission();
			$aclNotPermissions = $this->PermissionProcessing->getAcoNotPermission();
			
			$modulos = $this->PermissionProcessing->getModules();
			$this->set('modulos', $modulos);
			$this->set('aclPermissions', $aclPermissions);
			$this->set('aclNotPermissions', $aclNotPermissions);
			$this->set('aroName', $this->aroName);
			$this->set('aroId', $this->aroId);
		}else{
			$this->Session->setFlash(__('Grupo não encontrado!'), 'default', array());
			$this->redirect(array('plugin'=>'manager', 'controller'=>'aros', 'action'=>'index'));
		}
        $this->set('numberAba', $numberAba);
	}
	
	
	public function admin_changePermission()
	{

		if($this->request->is('post'))
		{
			$data = $this->request->data['Permission'];

            
			$this->setRole($data['aro_id']);
			if($data['permission'] == 'Y')
			{
				if($this->allow($data['aco_id'], $data['aro_id']) == true){
					$this->Session->setFlash(__('Permissão adicionada com sucesso!'), 'default', array('class'=>'success'));
					$this->redirect(array('action'=>'index', $this->roleId, $data['moduleNumber']));
				}else{
					$this->Session->setFlash(__('Erro: Não foi possível alterar a permissão'), 'default', array('class'=>'error'));
					$this->redirect(array('action'=>'index', $this->roleId, $data['moduleNumber']));
				}	
			}else{
				if($this->deny($data['aco_id'], $data['aro_id']) == true){
					$this->Session->setFlash(__('Permissão excluída com sucesso!'), 'default', array('class'=>'success'));
					$this->redirect(array('action'=>'index', $this->roleId, $data['moduleNumber']));
				}else{
					$this->Session->setFlash(__('Erro: Não foi possível alterar a permissão'), 'default', array('class'=>'error'));
					$this->redirect(array('action'=>'index', $this->roleId, $data['moduleNumber']));
				}		
			}
		}
	}
	
	/**
	 * Método que tira permissão aos acos
	 */
	 private function deny($aco_id, $aro_id)
	 {
	 	$data['ArosAco']['_create'] = 0;
		$data['ArosAco']['_read'] = 0;
		$data['ArosAco']['_update'] = 0;
		$data['ArosAco']['_delete'] = 0;

		$datasource = $this->ArosAco->getDataSource();
		try{
		    $datasource->begin();
		    if($this->setAroAco($aco_id, $aro_id) == true)
		    {
		    	$data['ArosAco']['id'] = $this->AroAcoId;
				 if(!$this->ArosAco->save($data))
		        	throw new Exception();
		    		$datasource->commit();
					return true;
			}else{
		    	return true;
		    }
		}catch(Exception $e){
		    $datasource->rollback();
			return false;
		}
	 }
		
		
		
		
		/**
		 * Método que da permissão dos acos
		 */
		 private function allow($aco_id, $aro_id)
		 {
			$data['ArosAco']['_create'] = 1;
			$data['ArosAco']['_read'] = 1;
			$data['ArosAco']['_update'] = 1;
			$data['ArosAco']['_delete'] = 1;
					
			$datasource = $this->ArosAco->getDataSource();
			try{
			    $datasource->begin();
			    if($this->setAroAco($aco_id, $aro_id) == true)
			    {
			    	$data['ArosAco']['id'] = $this->AroAcoId;
					 if(!$this->ArosAco->save($data))
			        	throw new Exception();
			    }else{
			    	$data['ArosAco']['aco_id'] = $aco_id;
					$data['ArosAco']['aro_id'] = $aro_id;
					$this->ArosAco->create();
					 if(!$this->ArosAco->save($data))
			        	throw new Exception();
			    }
			    $datasource->commit();
				return true;
			} catch(Exception $e) {
			    $datasource->rollback();
				return false;
			}
		 }
		
		
		/**
		 * Método que seta permissão
		 */
		 private function setAroAco($aco_id, $aro_id)
		 {
		 	$pesquisaAroAco = $this->ArosAco->find('first', array('conditions'=>array(
			'ArosAco.aco_id'=>$aco_id,
			'ArosAco.aro_id'=>$aro_id)));
			if(!empty($pesquisaAroAco)){
				$this->AroAcoId = $pesquisaAroAco['ArosAco']['id'];
				return true;
			}else{
				return false;
			}
		 }
	

	
	private function setRole($aro_id)
	{
		$this->Acl->Aro->recursive = -1;
		$aro = $this->Acl->Aro->find('first', 
		array('conditions'=>array(
		'Aro.id'=>$aro_id),
		'fields'=>array('Aro.foreign_key')));

		if(!empty($aro))
		{
			$this->roleId = $aro['Aro']['foreign_key'];
			return true;
		}
		else
		{ return false; }
	}
	
	private function setAro($id)
	{
		$this->Acl->Aro->recursive = -1;
		$aro = $this->Acl->Aro->find('first', 
		array('conditions'=>array(
		'Aro.foreign_key'=>$id),
		'fields'=>'Aro.id'));

		if(!empty($aro))
		{
			$this->aroId = $aro['Aro']['id'];
			$this->Role->recursive = -1;
			$roleName = $this->Role->findById($id);
			if(!empty($roleName)){
				$this->aroName = $roleName['Role']['role'];
				return true;
			}
		}
		else
		{ return false; }
	}


	
}	