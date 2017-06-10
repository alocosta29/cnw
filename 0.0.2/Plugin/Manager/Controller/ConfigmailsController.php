<?php
App::uses('AppController', 'Controller');
/**
 * Configmails Controller
 *
 * Cadastrar e editar as configurações do remetente dos e-mails enviados pelo sistema.
 * @property André Luís
 */
class ConfigmailsController extends ManagerAppController {


	public function admin_index() {
		$this->Configmail->recursive = 0;
		$this->set('configmails', $this->paginate());
	}


	public function admin_view($id = null) {
		$this->Configmail->id = $id;
		if (!$this->Configmail->exists()) {
			throw new NotFoundException(__('Configuração de remetente inválida'));
		}
		$this->set('configmail', $this->Configmail->read(null, $id));
	}


	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Configmail->create();
			
			if($this->request->data['Configmail']['attachments'] == ''):
			unset($this->request->data['Configmail']['attachments']);
			endif;	
			if($this->request->data['Configmail']['template'] == ''):
			unset($this->request->data['Configmail']['template']);
			endif;	
			
			if ($this->Configmail->save($this->request->data)) {
				$this->Session->setFlash(__('Configuração salva com sucesso'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A configuração não pode ser salva. Por favor, tente novamente!'));
			}
		}
	}


	public function admin_edit($id = null) {
		$this->Configmail->id = $id;
		if (!$this->Configmail->exists()) {
			throw new NotFoundException(__('Configuração inválida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
				if($this->request->data['Configmail']['attachments'] == ''):
			unset($this->request->data['Configmail']['attachments']);
			endif;	
			if($this->request->data['Configmail']['template'] == ''):
			unset($this->request->data['Configmail']['template']);
			endif;	
			
			
			if ($this->Configmail->save($this->request->data)) {
				$this->Session->setFlash(__('Configuração salva com sucesso.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A configuração não pode ser salva. Por favor, tente novamente!'));
			}
		} else {
			$this->request->data = $this->Configmail->read(null, $id);
		}
	}

		
		public function _enableDisable($id, $isdeleted)
		{
				$this->Configmail->read(null, $id);
				$this->Configmail->set('isdeleted', $isdeleted);
				if($this->Configmail->save())
				{
					return true;
				}else{
					return false;
				}
		}
		
		public function disableConfigmail($id = null)
		{
			$this->Configmail->id = $id;
			if (!$this->Configmail->exists()) 
			{
				$this->Session->setFlash(__('Configuração inválida'));
				$this->redirect(array(
									'plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'index',
									'admin'=>true));
			}
			else
			{
				$isdeleted = 'Y';
				if($this->_enableDisable($id, $isdeleted) == true)
				{
						$this->Session->setFlash(__('Configuração efetuada com sucesso'));
						$this->redirect(array(
									'plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'index',
									'admin'=>true));
					
				}else{
					$this->Session->setFlash(__('A Configuração não foi efetuada com sucesso. Por favor, tente novamente'));
						$this->redirect(array(
									'plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'index',
									'admin'=>true));
				}	
			}
		
		}
		
		
		
		
		
		public function enableConfigmail($id = null)
		{
			$this->Configmail->id = $id;
			if (!$this->Configmail->exists()) 
			{
				$this->Session->setFlash(__('Configuração inválida'));
				$this->redirect(array(
									'plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'index',
									'admin'=>true));
			}	
			else
			{
				$isdeleted = 'N';
				if($this->_enableDisable($id, $isdeleted) == true)
				{
						$this->Session->setFlash(__('Configuração efetuada com sucesso'));
						$this->redirect(array(
									'plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'index',
									'admin'=>true));
					
				}else{
					$this->Session->setFlash(__('A Configuração não foi efetuada com sucesso. Por favor, tente novamente'));
						$this->redirect(array(
									'plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'index',
									'admin'=>true));
				}	
			}
		}




	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Configmail->id = $id;
		if (!$this->Configmail->exists()) {
			throw new NotFoundException(__('Invalid configmail'));
		}
		if ($this->Configmail->delete()) {
			$this->Session->setFlash(__('Configmail deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Configmail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}