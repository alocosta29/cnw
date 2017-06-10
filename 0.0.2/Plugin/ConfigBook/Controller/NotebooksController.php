<?php
App::uses('ConfigBookAppController', 'ConfigBook.Controller');
class NotebooksController extends ConfigBookAppController {
    public $uses = array('ConfigBook.Caderno');
    

	public function admin_index() 
	{	
		$options = array(
			'conditions' => array('Caderno.isdeleted' => 'N'),
			'order' => array('Caderno.id' => 'DESC'),
			'limit' => 20
		);
		$this->paginate = $options;
		$Cadernos = $this->paginate('Caderno');
                //pr($this->request); exit(0);
		$this->set('variavels', $Cadernos);
	}
	public function admin_ativaModel($id = null)
	{
			$this->Caderno->id = $id;
			if(!$this->Caderno->exists()) 
			{
				throw new NotFoundException(__($this->Mensagens->registroInvalido));
			}				
			$CadernoParaAtivar['Caderno']['isactive']='Y';
			$CadernoParaAtivar['Caderno']['id'] = $id;
			if($this->Caderno->saveAll($CadernoParaAtivar))
			{
				$this->Session->setFlash(__('Caderno ativado com sucesso!!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index', 'admin'=>TRUE));
			}
			$this->Session->setFlash(__('O model não pode ser ativado. Por favor tente novamente'), 'default', array());
			$this->redirect(array('action' => 'index', 'admin'=>TRUE));
	}

	public function admin_desativaModel($id = null)
	{
			$this->Caderno->id = $id;
			if (!$this->Caderno->exists()) 
			{
				throw new NotFoundException(__($this->Mensagens->registroInvalido));
			}				
			$CadernoParaDesativar['Caderno']['isactive']='N';
			$CadernoParaDesativar['Caderno']['id'] = $id;
			if($this->Caderno->saveAll($CadernoParaDesativar))
			{
				$this->Session->setFlash(__('Caderno desativado com sucesso!!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index', 'admin'=>TRUE));
			}
			$this->Session->setFlash(__('O model não pode ser desativado. Por favor tente novamente'), 'default', array());
			$this->redirect(array('action' => 'index', 'admin'=>TRUE));
	}

	public function admin_add() {
		if ($this->request->is('post')){
			$data = $this->request->data;
                      //  pr($data); exit(0);
                        
			$this->Caderno->create();
			if($this->Caderno->save($data)){			
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
			}
		}
	}
  
     public function admin_edit($id = null) 
	{
		if (!$this->Caderno->exists($id)) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['Caderno']['id'] = $id;
			if ($this->Caderno->save($data)) 
			{
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} 
			else 
			{
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Caderno.' . $this->Caderno->primaryKey => $id));
			$this->request->data = $this->Caderno->find('first', $options);
		}
	}


	public function admin_delete($id = null) 
	{
		$this->Caderno->id = $id;
		if (!$this->Caderno->exists()) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		$CadernoParaDeletar['Caderno']['id']= $id;
		$CadernoParaDeletar['Caderno']['isdeleted']='Y';
		$CadernoParaDeletar['Caderno']['isactive']='N';
		if($this->Caderno->saveAll($CadernoParaDeletar))
		{
			$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}else{
			$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}	
	}
}