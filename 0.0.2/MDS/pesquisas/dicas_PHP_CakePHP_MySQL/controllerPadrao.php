<?php
App::uses('ConfigurationsAppController', 'Configurations.Controller');


class ModelsController extends ConfigurationsAppController {


	public function admin_index() 
	{	
		$options = array(
			'conditions' => array('Model.isdeleted' => 'N'),
			'order' => array('Model.id' => 'DESC'),
			'limit' => 20
		);
		$this->paginate = $options;
		$Models = $this->paginate('Model');
		$this->set('Models', $Models);
	}
	public function admin_ativaModel($id = null)
	{
			$this->Model->id = $id;
			if(!$this->Model->exists()) 
			{
				throw new NotFoundException(__($this->Mensagens->registroInvalido));
			}				
			$ModelParaAtivar['Model']['isactive']='Y';
			$ModelParaAtivar['Model']['id'] = $id;
			if($this->Model->saveAll($ModelParaAtivar))
			{
				$this->Session->setFlash(__('Model ativado com sucesso!!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index', 'admin'=>TRUE));
			}
			$this->Session->setFlash(__('O model não pode ser ativado. Por favor tente novamente'), 'default', array());
			$this->redirect(array('action' => 'index', 'admin'=>TRUE));
	}

	public function admin_desativaModel($id = null)
	{
			$this->Model->id = $id;
			if (!$this->Model->exists()) 
			{
				throw new NotFoundException(__($this->Mensagens->registroInvalido));
			}				
			$ModelParaDesativar['Model']['isactive']='N';
			$ModelParaDesativar['Model']['id'] = $id;
			if($this->Model->saveAll($ModelParaDesativar))
			{
				$this->Session->setFlash(__('Model desativado com sucesso!!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index', 'admin'=>TRUE));
			}
			$this->Session->setFlash(__('O model não pode ser desativado. Por favor tente novamente'), 'default', array());
			$this->redirect(array('action' => 'index', 'admin'=>TRUE));
	}

	public function admin_add() {
		if ($this->request->is('post')){
			$data = $this->request->data;
			$this->Model->create();
			if($this->Model->save($data)){			
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
			}
		}
	}
  
     public function admin_edit($id = null) 
	{
		if (!$this->Model->exists($id)) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['Model']['id'] = $id;
			if ($this->Model->save($data)) 
			{
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} 
			else 
			{
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Model.' . $this->Model->primaryKey => $id));
			$this->request->data = $this->Model->find('first', $options);
		}
	}

	public function admin_view($id = null) 
	{
		if(!$this->Model->exists($id)) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		$options = array('conditions' => array('Model.' . $this->Model->primaryKey => $id));
		$this->set('Model', $this->Model->find('first', $options));
	}

	public function admin_delete($id = null) 
	{
		$this->Model->id = $id;
		if (!$this->Model->exists()) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		$ModelParaDeletar['Model']['id']= $id;
		$ModelParaDeletar['Model']['isdeleted']='Y';
		$ModelParaDeletar['Model']['isactive']='N';
		if($this->Model->saveAll($ModelParaDeletar))
		{
			$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}else{
			$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}	
	}
}