<?php
App::uses('Manager.ManagerAppController', 'Controller');

class HolidaysController extends ManagerAppController 
{

	public function admin_index() 
	{
		$options = array(
		'conditions'=>array('Holiday.isdeleted'=>'N'),
		'order' => array('Holiday.id' => 'DESC'),
		'limit' => 20
		);
		$this->paginate = $options;
		$holidays = $this->paginate('Holiday');
		$this->set('holidays', $holidays);
	}

	public function admin_add() 
	{
		if ($this->request->is('post')) {
			$this->Holiday->create();
			if ($this->Holiday->save($this->request->data)) {
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array());
			}
		}
	}

	public function admin_edit($id = null) 
	{
		if (!$this->Holiday->exists($id)) {
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Holiday->save($this->request->data)) {
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array());
			}
		} else {
			$options = array('conditions' => array('Holiday.' . $this->Holiday->primaryKey => $id));
			$registro = $this->Holiday->find('first', $options);
			$data = explode('-', $registro['Holiday']['data']);
			$registro['Holiday']['data'] =$data[2].'/'.$data[1].'/'.$data[0];
			$this->request->data = $registro;
		}
	}


	public function admin_delete($id = null) 
	{
		$this->Holiday->id = $id;
		if (!$this->Holiday->exists()) {
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
			
			$HolidayParaDeletar = $this->Holiday->read(null, $id);
			$HolidayParaDeletar['Holiday']['isactive']='N';
			$HolidayParaDeletar['Holiday']['isdeleted']='Y';
			//pr($LevelParaDeletar);
			//exit(0);
			
		if($this->Holiday->save($HolidayParaDeletar))
		{
			$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array());
		$this->redirect(array('action' => 'index'));
	}
}
