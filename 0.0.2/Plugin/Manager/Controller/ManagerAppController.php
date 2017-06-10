<?php
//set_time_limit(150);
//error_reporting(0);
//ini_set("display_errors", 0);
ini_set("memory_limit","512M");
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class ManagerAppController extends Controller 
{
    public $components = array
    (
        'Acl',
        'Mensagens',
        'Session',
        'Manager.Remetente',
        'RequestHandler', 
        'Manager.AclManager', 
        'Manager.AclReflector',
        'Manager.MenuSuperior',
        'Manager.Constants',
        'Notifications.Notify',
        'AccessUsers.CheckPermission',
        'CheckData',
        'Layout',
        'Auth' => array(
                        'loginAction' => array('controller' => 'users', 'action' => 'login', 'plugin'=>'manager', 'admin'=>true),
                        'loginRedirect' => array('controller' => 'users', 'action' => 'index', 'plugin'=>'manager', 'admin'=>true),
                        'logoutRedirect' => array('controller' => 'users', 'action' => 'login', 'plugin'=>'manager', 'admin'=>true),
                        'authError' => 'Você não possui autorização para executar esta ação.',
                        'authenticate' => array(
                                                'Form' => array(
                                                                'scope' => array('User.status' => 1)
                                                               )
                                               ), 
                        'authorize' => array('Controller')
                        )
    );	
	
    public $helpers = array('Html', 'Form', 'Session', 'Time', 'Manager.AclLink', 'Manager.FormatManager', 'Manager.MenuAssistent', 'Manager.SubmenuAssistentTela', 'Manager.SubmenuAssistent', 'ReturnData', 'Notifications.Notifications', 'Cms.Cms', 'Avatar.Avatar');
	
    public function beforeFilter() 
	{
		     //Busca pelo id da tabela Roles, que indica o nível de permissão do usuario
	         if($this->Auth->user())
	         {
                     $roleId = $this->Auth->user('role_id'); 
	         }else{
                     $roleId = 3;                        
                        if ( $this->params->url !=='notifications/notifications/regs' # NAO considera a checagem de notificacao como uma URL externa.
                            && (!(stripos($this->params['action'],'edit') !==false)) # NAO considera action que contem a string citada
                            && (!(stripos($this->params['action'],'updat')!==false)) # NAO considera action que contem a string citada
                            && (!(stripos($this->params['action'],'conf') !==false)) # NAO considera action que contem a string citada
                            && (!(stripos($this->params['action'],'del')  !==false)) # NAO considera action que contem a string citada
                            && (!(stripos($this->params['action'],'cad')  !==false)) # NAO considera action que contem a string citada
                            && (!(stripos($this->params['action'],'add')  !==false)) # NAO considera action que contem a string citada
                            && (!(stripos($this->params['action'],'proc') !==false)) # NAO considera action que contem a string citada
                            && (!(stripos($this->params['action'],'searc')!==false)) # NAO considera action que contem a string citada
                        ){ # somente aceita URL externa caso nao estejam nas regras acima.
                        $exploReferer = explode('/',$this->params->url);
                        if (count($exploReferer)>1){
                            $this->Session->write('urlexternal', $this->params->url);
                        }
                    }
	         }
			     //Busca pelo id vinculado em aro, da tabela de grupos(Roles)
		          $aro = $this->Acl->Aro->find('first', array(
		               'conditions' => array(
		                   'Aro.model' => 'Role',
		                   'Aro.foreign_key' => $roleId)));
		       		           
		           $aroId = $aro['Aro']['id'];
                    //Busca de classes na tabela aco
                    if(!empty($this->plugin))
                    {
                         //Se existir plugin	 
                         $thisControllerNode = $this->Acl->Aco->node('controllers/'.$this->plugin);
                    }else
                    {
                         //Se NAO existir plugin
                         $thisControllerNode = $this->Acl->Aco->node('controllers/'.$this->name);
                    }    
			    //SE A VARÍAVEL $thisControllerNode NÃO ESTIVER VAZIA
	           if($thisControllerNode)
	           {
					if(empty($this->plugin))
					{
		           		$thisControllerActions = $this->Acl->Aco->find('list', 
		           		array(
		                	'conditions' => array(
		                    'Aco.parent_id' => $thisControllerNode['0']['Aco']['id']), 
		                    'fields' => array('Aco.id', 'Aco.alias'),
		                	'recursive' => '-1'));
					}else{		
                            
                            ### ROTINA ESPECIAL PARA BUSCA DO CONTROLLER DO PLUGIN ### 	
                            //Busco a chave do controller do plugin cadastrada em aco
							$keycontroller = $this->Acl->Aco->find('list', 
								array(
									   	'conditions' => array(
										'Aco.parent_id' => $thisControllerNode['0']['Aco']['id'],
										'Aco.alias' => $this->name),
										'fields' => array('Aco.id', 'Aco.alias'),
										'recursive' => '-1'));
							$key = key($keycontroller);
							### FIM DA ROTINA ESPECIAL PARA BUSCA DO CONTROLLER DO PLUGIN ###

							 //Busco o cointroller
							$thisControllerActions = $this->Acl->Aco->find('list', 
							array(
							'conditions' => array('Aco.parent_id' => $key),
							'fields' => array('Aco.id', 'Aco.alias'),
							'recursive' => '-1'));
					}
					//Formação de um array com as chaves dos metodos localizados na classe selecionada	
	               	$thisControllerActionsIds = array_keys($thisControllerActions);
              
				 	if($roleId == 1)
				 	{
					 	//se o nivel for 1, libera tudo
						$allowedActionsIds = $thisControllerActionsIds; 											
				 	}else
				 	{
                         $roleId = 3;
						 //Consulta dentre as chaves de metodos selecionados, todos os que são permitidos pelo usuario logado
				         $allowedActions = $this->Acl->Aco->Permission->find('list', 
				         array(
				          		'conditions' => array(
				                			  	'Permission.aro_id' => $aroId,
				                    			'Permission.aco_id' => $thisControllerActionsIds,
				                    			'Permission._create' => 1,
				                    			'Permission._read' => 1,
				                    			'Permission._update' => 1,
				                    			'Permission._delete' => 1,
				                				),
				                 'fields' => array('id', 'aco_id'),
				                 'recursive' => '-1')
								 ); 
				         $allowedActionsIds = array_values($allowedActions); 							 
					}
					$menuSuperior = $this->MenuSuperior->retornaMenu();
                	$this->params['menuSuperior'] = $menuSuperior;
	           }
			   $allow = array();			   
			   if(isset($allowedActionsIds) && is_array($allowedActionsIds) && count($allowedActionsIds))
			   {
				    foreach($allowedActionsIds as $i => $aId)
				    {
					   $allow[] = $thisControllerActions[$aId];
				    }                   
			   }
			   $this->Auth->allowedActions = $allow;          
               if($this->CheckPermission->checkUserControl($this->plugin, $this->params['pass']))
               {
                    if($this->CheckPermission->pluginAllow)
                    {
                        $actionAllow[] = $this->action;
                        $this->Auth->allowedActions = array_merge($this->Auth->allowedActions, $actionAllow);
                    }else{
                        $this->Auth->allowedActions = array();
                    }
               } 
               if($this->Session->read('Auth.User.id'))
               {
                    $controller = $this->request->controller;
                                        
                    if($this->Session->read('Auth.User.recent_register') == 'Y' and !in_array($controller, array('users', 'admin'))){
                      $this->Session->setFlash(__('Você está usando uma senha temporária! Para utilizar o sistema, por favor faça a alteração de senha!'), 'default', array('class' => 'notice'));
                      $this->redirect(array('plugin'=>'manager', 'controller'=>'users', 'action' => 'trocarsenha', 'admin'=>true));
                    }
                    
                    
                    
                    $this->Cookie = $this->Components->load('Cookie');
                    if(!$this->Cookie->read('user_id') or md5($this->Session->read('Auth.User.id')) <> $this->Cookie->read('user_id'))
                    {
                      $this->Cookie->write('user_id', md5($this->Session->read('Auth.User.id')), false, '1 hour');   
                    }    
                
                    
                    
              }
		   }
           
           public function beforeRender(){
                $this->layout = $this->Layout->getLayout($this->request->params['plugin'], $this->request->params['controller'], $this->request->params['action']);
               //pr($this->layout); exit();
           }
}