<?php
App::uses('ManagerAppController', 'Manager.Controller');
class AcosController extends ManagerAppController{
	public $uses = array('Manager.Aco', 'Manager.ArosAco', 'Role', 'Manager.Menuiten');
	public $components = array('Manager.AcoData', 'Manager.Permission');
		
	public function beforeFilter()
	{
		parent::beforeFilter();
		if($this->params['action'] == 'admin_configAco' and $this->Session->read('Auth.User.role_id') <> 1)
		{
			$this->Auth->deny('admin_configMenu');
		}
		
		if($this->Session->read('Auth.User.role_id') == 1){
			$this->Auth->allow(array('admin_novoAco', 'admin_synchronize'));
			
		}
		
	}
	
	public function admin_add()
	{
	 if ($this->request->is('post')) {
				$this->Acl->Aco->create();
				$this->request->data['Aco']['createdby'] = $this->Session->read('Auth.User.id');
				$this->request->data['Aco']['modifiedby'] = $this->Session->read('Auth.User.id');
				$this->request->data['Aco']['updatedby'] = $this->Session->read('Auth.User.id');
				if ($this->Acl->Aco->save($this->request->data)) {
					$this->Session->setFlash(__('O metodo foi salvo!'), 'default', array('class' => 'success'));
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash('O metodo não foi salvo');
					$this->redirect(array('controllers'=>'users', 'action'=>'index'));
				}
			}
			$parent_id = $this->Acl->Aco->find('list', array('fields'=>array('Aco.id', 'Aco.alias')));
			$this->set(compact('parent_id'));
		}

		
	public function admin_configurados()
	{
		$options['conditions']['NOT']['Aco.aliasMetodo'] = NULL;
		$options['conditions']['NOT']['Aco.parent_id'] = NULL;	
		if($this->Session->read('Auth.User.role_id') <> 1)
		{
			$options['conditions']['NOT']['Aco.restrito'] = 'Y';	
		}
		$options['order']['Aco.aliasMetodo'] = 'ASC';	
		$options['limit'] = 20;	

		$this->paginate = $options;
		$acos = $this->paginate('Aco');
			
		$this->set('acos', $acos);	
		$parent_id = $this->Aco->find('all', array('fields'=>array('AcoParent.alias','Aco.id', 'Aco.alias', 'Aco.parent_id'),'recursive' => 3,
			'joins' => array(array('table' => 'acos','alias' => 'AcoParent','type' => 'LEFT',
		            'conditions' => array('AcoParent.id = Aco.parent_id')
			))
		));
		$this->set('parent_id', $parent_id);
	}
		
	public function admin_naoConfigurados()
	{
		$options['conditions']['Aco.aliasMetodo'] = NULL;
		$options['conditions']['NOT']['Aco.parent_id'] = NULL;	
		$options['order']['Aco.id'] = 'DESC';	
		$options['limit'] = 20;	
		$this->paginate = $options;
		$acos = $this->paginate('Aco');	
		$this->set('acos', $acos);	
		
		$parent_id = $this->Aco->find('all', array('fields'=>array('AcoParent.alias','Aco.id', 'Aco.alias', 'Aco.parent_id'),'recursive' => 3,
			'joins' => array(array('table' => 'acos','alias' => 'AcoParent','type' => 'LEFT',
		            'conditions' => array('AcoParent.id = Aco.parent_id')
			))
		));
		$this->set('parent_id', $parent_id);
	}
		
	public function admin_synchronize($run = null)
    {
        if(isset($run))
        {
        	if($run == 'delete')
        	{
        		$prune_logs  = $this->AclManager->pruneAcos();
			 	$this->set('prune_logs',  $prune_logs);	
        	}else{	
				$create_logs = $this->AclManager->createAcos();
		 		$this->set('create_logs', $create_logs);	
        	}		
        }else{
            $nodes_to_prune    = $this->AclManager->getAcosToPrune();
            $missing_aco_nodes = $this->AclManager->getMissingAcos();
            $this->set('nodes_to_prune', $nodes_to_prune);
            $this->set('missing_aco_nodes',  $missing_aco_nodes);
            $this->set('run', false);
        }
    }
		
	public function admin_novoAco($run = null)
	{
	    if(isset($run))
	    {
    		$logs = $this->AclManager->createAcos();		
    		$this->set('logs', $logs);
    		$this->set('run', true);
	    }
	    else
	    {
	        $missing_aco_nodes = $this->AclManager->getMissingAcos();
	        $this->set('missing_aco_nodes',  $missing_aco_nodes);
	        $this->set('run', false);
	    }
	}
		
	public function admin_acosObsoletos($run = null)
    {
        if(isset($run))
        {
             $logs = $this->AclManager->pruneAcos();
             $this->set('logs', $logs);
             $this->set('run', true);
			 $this->redirect(array('action'=>'metodosObsoletos'));
        }else{
            $nodes_to_prune    = $this->AclManager->getAcosToPrune();
            $this->set('nodes_to_prune', $nodes_to_prune);
            $this->set('run', false);
        }
    }
		
	public function _modificarPermissao($params)
	{
		//este metodo cria ou retira permissão, caso não exista, ao nivel e ação selecionado
		$aco_id = $params['aco_id'];
		$aro_id = $params['aro_id'];
		$permission = $params['permission'];
	
			$consultaPermission = $this->ArosAco->find('all', 
			array('conditions'=>array(
			'ArosAco.aco_id'=>$aco_id,
			'ArosAco.aro_id'=>$aro_id
			),
			'fields'=>array('ArosAco.id')
			));	
				if(!empty($consultaPermission))
				{	
						$aroAco_id = $consultaPermission[0]['ArosAco']['id'];
						$this->ArosAco->read(null, $aroAco_id);
						$this->ArosAco->set('_create', $permission);
						$this->ArosAco->set('_read', $permission);
						$this->ArosAco->set('_update', $permission);
						$this->ArosAco->set('_delete', $permission);
						if($this->ArosAco->save()){
							return true;
						}else{
							return false;
						}
				}else{
						$data['ArosAco']['aro_id']= $aro_id;
						$data['ArosAco']['aco_id']= $aco_id;
						$data['ArosAco']['_create']= $permission;
						$data['ArosAco']['_read']= $permission;
						$data['ArosAco']['_update']= $permission;
						$data['ArosAco']['_delete']= $permission;
						if($this->ArosAco->save($data))
						{
							return true;
						}else{
							return false;
						}
				}	
	}

	public function _verificaItemMenu($aco_id)
	{
		$testeExistenciaItem = $this->Menuiten->find('all', array('conditions'=>array('Menuiten.aco_id'=>$aco_id)));
		if(!empty($testeExistenciaItem))
		{
			return false;
		}else{
			return true;
		}
	}
		
	/**
	 * Método que atualizará os dados da Aco.
	 */
	public function admin_configMenu($id = null)
	{
		$this->Acl->Aco->id = $id;
		if (!$this->Acl->Aco->exists()){
			throw new NotFoundException(__('Aco inválido'));
		}
		$verificaAco = $this->AcoData->_trataAcoData($id);
		if($verificaAco['resposta'] == true)
		{
				$this->loadModel('Manager.AcoAdmin');
				$acoData = $this->AcoData->_returnAcoData($id);
			
				$this->loadModel('Manager.Menugroup');
				$listmenu = $this->Menugroup->find('list', array(
				'fields'=>array('Menugroup.id', 'Menugroup.grupo'),
				'order'=>array('Menugroup.grupo'=>'asc')));
				if($this->request->is('post') || $this->request->is('put'))
				{
					$data = $this->request->data;
					$data['AcoAdmin']['id'] = $id;
					if($this->AcoAdmin->save($data)){
						$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
						$this->redirect(array('action'=>'configurados'));
					}else{
						$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array());
					}
				}
				$this->set('listmenu', $listmenu);
				$this->request->data['AcoAdmin'] = $acoData['Aco'];			
		}else{
			$this->Session->setFlash(__($verificaAco['msg']), 'default', array());
			$this->redirect(array('action'=>'index'));
		}
	}
	
	/**
	 * Método que atualizará os dados da Aco. Apenas para Superuser
	 */
	public function admin_configAco($id = null)
	{
		$this->Acl->Aco->id = $id;
		if (!$this->Acl->Aco->exists()){
			throw new NotFoundException(__('Aco inválido'));
		}
		$acoData = $this->AcoData->_returnAcoData($id);
		$this->loadModel('Manager.AcoSuperuser');
		$this->loadModel('Manager.Module');
		$listModule = $this->Module->find('list', array(
		'conditions'=>array('Module.isdeleted'=>'N'),
		'fields'=>array('Module.id', 'Module.nome'),
		'order'=>array('Module.nome'=>'asc')));
		$verificaPermission = $this->Permission->_verificaPermission(3, $id);
	
		if($this->request->is('post') || $this->request->is('put'))
		{
			$data = $this->AcoData->_trataAcoSuperuser($this->request->data, $id);
				$datasource = $this->AcoSuperuser->getDataSource();
				try{
				    $datasource->begin();
				    if(!$this->AcoSuperuser->save($data))
				        throw new Exception();
							
					if($data['AcoSuperuser']['restrito'] == 'Y')
					{
						if($verificaPermission<>false)
						{
							$permission['ArosAco'] = $this->AcoData->_retornaSavePermission('N');	
							$permission['ArosAco']['id'] = $verificaPermission;	
						    if(!$this->ArosAco->save($permission))
			        		throw new Exception();
						}
					}else{
							$permission['ArosAco'] = $this->AcoData->_retornaSavePermission('Y');
											
							if($verificaPermission<>false){	
								$permission['ArosAco']['id'] = $verificaPermission;	
							}else{
								$this->ArosAco->create();
								$permission['ArosAco']['aco_id'] = $id;
								$permission['ArosAco']['aro_id'] = 3;
							}
							if(!$this->ArosAco->save($permission))
				        		throw new Exception();
						}
				    $datasource->commit();
					$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
					$this->redirect(array('action' => 'naoConfigurados'));
				}catch(Exception $e){
				    $datasource->rollback();
					$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array());
				}	
		}
		$this->set('listModule', $listModule);	
		$this->request->data['AcoSuperuser'] = $acoData['Aco'];			
	}
	
	public function admin_list()
	{
		$lista = $this->Acl->Aco->find('list', array('fields'=>array('Aco.id', 'Aco.alias', 'Aco.apelido')));
		$this->set(compact('lista'));
	}	
}