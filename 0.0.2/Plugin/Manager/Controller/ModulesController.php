<?php
App::uses('ManagerAppController', 'Manager.Controller');


class ModulesController extends ManagerAppController {


	public function admin_index() 
	{	
		$options = array(
			'conditions' => array('Module.isdeleted' => 'N'),
			'order' => array('Module.id' => 'DESC'),
			'limit' => 20
		);

		$this->paginate = $options;
		$Modules = $this->paginate('Module');
		$this->set('Modules', $Modules);
	}


	public function admin_add() {
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$this->Module->create();
			if ($this->Module->save($data)) {			
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
			}
		}
	}



	public function admin_edit($id = null) 
	{
		if (!$this->Module->exists($id)) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['Module']['id'] = $id;
			if ($this->Module->save($data)) 
			{
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} 
			else 
			{
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Module.' . $this->Module->primaryKey => $id));
			$this->request->data = $this->Module->find('first', $options);
		}
	}



	public function admin_delete($id = null) 
	{
		$this->Module->id = $id;
		if (!$this->Module->exists()) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
				$ModuleParaDeletar['Module']['id']= $id;
				$ModuleParaDeletar['Module']['isdeleted']='Y';
				$ModuleParaDeletar['Module']['isactive']='N';
				if($this->Module->saveAll($ModuleParaDeletar))
				{
					$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
					$this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
					$this->redirect(array('action' => 'index'));
				}
		
	}
















}