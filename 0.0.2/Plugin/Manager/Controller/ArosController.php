<?php
App::uses('ManagerAppController', 'Manager.Controller');
class ArosController extends ManagerAppController {
	
	public $components = array('RequestHandler', 'Manager.AclManager', 'Manager.AclReflector');
	public $uses = array('Manager.Role');
	
	public function admin_add()
	{
		 if($this->request->is('post')) 
		 {
		  	$this->Role->create();
		 	if ($this->Role->save($this->request->data))
		 	{
		 		$role_id = $this->Role->id;
		 		$saveAro = $this->add_aro($role_id);
			 		if($saveAro == true)
			 		{
						$this->Session->setFlash(__('O grupo foi salvo com sucesso!'), 'default', array('class' => 'success'));
			 			$this->redirect(array('action'=>'index'));
			 		}else{
			 			$this->Session->setFlash('O grupo não foi salvo');
			 		}	
		 	}else{
		 		$this->Session->setFlash('O grupo não foi salvo');
		 	}
		 }	
	 }
	public function admin_edit($id = null)
	{
		$this->Role->id = $id;
		try {
			if (!$this->Role->exists()) {
				throw new NotFoundException(__('Grupo inválido'));
			}

			if(count( $this->Role->find("all", array("conditions" => array(
						'id'=>$id, 
						'isactive'=>'Y', 'isdeleted'=>'N',
						'NOT'=>array('Role.id'=>array(1, 2, 3))
						)))
			)<1){
				$this->Session->setFlash(__('Grupo inválido!'));
				$this->redirect(array('action' => 'index'));
			}

		}catch(Exception $e){
			$this->Session->setFlash(__('Grupo não encontrado!'));
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->request->is('post') || $this->request->is('put')) 
		{
			$data = $this->request->data;
			$data['Role']['id'] = $id;
	
			if ($this->Role->save($data)) {
				$this->Session->setFlash(__('O grupo foi atualizado!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O grupo não pode ser atualizado. Por favor, tente de novo.'));
			}
		} 
		else 
		{
			$this->request->data = $this->Role->read(null, $id);
		}			
	}
	
	public function add_aro($role_id)
	{
		if(isset($role_id) and !empty($role_id)) {
			if($this->Acl->Aro->save(array(
				'foreign_key'=>$role_id,
				'parent_id'=>1,
				'model'=> 'Role',
				'createdby'=> $this->Session->read('Auth.User.id'),
				'modifiedby'=> $this->Session->read('Auth.User.id'),
				'updatedby'=> $this->Session->read('Auth.User.id')
			)))	{
				return true;
			} else {
		 		return false;
			}
		}	
	}
	 
		public function admin_index()
		{
			if($this->Session->read('Auth.User.role_id') == 1)
			{
				$aros = $this->Role->find("all", array(
				"conditions" => array(
				'isactive'=>'Y', 
				'isdeleted'=>'N',
				'NOT'=>array('Role.id'=>array(1)))));
				
			}else{
				$aros = $this->Role->find("all", array(
				"conditions" => array(
				'isactive'=>'Y', 'isdeleted'=>'N',
				'NOT'=>array('Role.id'=>array(1, 2, 3)))));	
			}	
			$this->set('aros', $aros);
		}
	 
	/**
	 * Método que deleta o grupo
	 */
	public function admin_delete($id = null)
	{
		$this->Role->id = $id;
		if ($this->Role->exists())
		{
			if($id != 1 and $id != 2 and $id != 3)
			{
				$idRole = $id;
				$this->Role->recursive = -1;
				if(isset($roleParaDeletar)) unset($roleParaDeletar); $roleParaDeletar = array();
				$roleParaDeletar = $this->Role->read(null, $id);
				$roleParaDeletar['Role']['isdeleted']='Y';
				if($this->Role->saveAll($roleParaDeletar))
				{
					$this->Session->setFlash(__('O grupo foi deletado!'), 'default', array('class' => 'success'));
					$this->redirect(array('controller'=>'aros', 'action'=>'index'));
				}else{
					$this->Session->setFlash(__('O grupo não foi deletado. por favor, tente novamente!'), 'default', array('class' => 'error'));
					$this->redirect(array('controller'=>'aros', 'action'=>'index'));
				}
			}else{
				$this->Session->setFlash(__('Esse grupo não pode ser deletado'), 'default', array('class' => 'error'));
				$this->redirect(array('controller'=>'aros', 'action'=>'index'));
			}
		}else{
			throw new NotFoundException(__('Grupo inválido'));
		}	
	}
}