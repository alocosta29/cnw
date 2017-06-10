<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('MonetizationAppController', 'Monetization.Controller');
class AdTypesController extends MonetizationAppController{
    public $uses = array('Monetization.AdType');
    
	public function admin_list() 
	{	
		$options = array(
			'conditions' => array('AdType.isdeleted' => 'N'),
			'order' => array('AdType.id' => 'DESC'),
		);
                $AdTypes = $this->AdType->find('all', $options);
		$this->set('AdTypes', $AdTypes);
	}
	
	public function admin_add() {
		if ($this->request->is('post')){
			$data = $this->request->data;
              
			$this->AdType->create();
			if($this->AdType->save($data)){			
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'list'));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
			}
		}
	}
        
  
     public function admin_edit($id = null) 
	{
		if(!$this->AdType->exists($id)) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['AdType']['id'] = $id;
			if($this->AdType->save($data)) 
			{
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'list'));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
			}
		}else{
			$options = array('conditions' => array('AdType.' . $this->AdType->primaryKey => $id));
			$this->request->data = $this->AdType->find('first', $options);
		}
	}


	public function admin_delete($id = null) 
	{
		$this->AdType->id = $id;
		if (!$this->AdType->exists()) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		$AdTypeParaDeletar['AdType']['id']= $id;
		$AdTypeParaDeletar['AdType']['isdeleted']='Y';
		$AdTypeParaDeletar['AdType']['isactive']='N';
		if($this->AdType->saveAll($AdTypeParaDeletar))
		{
			$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'list'));
		}else{
			$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'list'));
		}	
	}
	
	
    
    
    
}