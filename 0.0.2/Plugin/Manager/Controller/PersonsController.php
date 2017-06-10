<?php
App::uses('ManagerAppController', 'Manager.Controller');

class PersonsController extends ManagerAppController {
	public $uses = array('Manager.Person', 'Manager.Contact', 'Manager.Contactstype', 'RolesUser');
	public $helpers = array('CakePtbr.Formatacao');
    public $components = array('Manager.GetDataPerson');
	/*
	 * Método de consulta para pessoa física e juríduca
	 */
 			
	
	public function admin_view($id = null) 
	{
        if($this->GetDataPerson->start($id))
        {
            $personData = $this->GetDataPerson->returnData;
            $this->set('person', $personData);                
        }else{
            $this->Session->setFlash(__($this->GetDataPerson->errors), 'default', array('class' => 'error'));
            $this->redirect(array('controller'=>'users', 'action' => 'consultaCadastro'));
        }
        $this->set('title_for_layout', 'Visualizar perfil de usuário');
	}
	

	public function admin_edit($id = null) 
	{
			if (!$this->Person->exists($id)) {
				throw new NotFoundException(__('Invalid person'));
			}
			if ($this->request->is('post') || $this->request->is('put')) 
			{
					$person = $this->request->data;
					foreach ($person['Contact'] as $key => $value) {
					if( (!isset($person['Contact'][$key]['id'])) &&(strlen(trim($person['Contact'][$key]['contato']))<=0) && (strlen(trim($person['Contact'][$key]['pessoa_paracontato']))<=0) ){
						unset($person['Contact'][$key]);
					} elseif ( (isset($person['Contact'][$key]['id'])) &&(strlen(trim($person['Contact'][$key]['contato']))<=0) && (strlen(trim($person['Contact'][$key]['pessoa_paracontato']))<=0) ){
						$this->Contact->delete($person['Contact'][$key]['id']);
						unset($person['Contact'][$key]);
					}
					}
					if ($this->Person->saveAll($person)) {
					    $this->Session->setFlash(__('Cadastro atualizado com sucesso'), 'default', array('class' => 'success'));
						$this->redirect(array('controller'=>'persons', 'action' => 'view', $this->Person->id));
					} else {
						$this->Session->setFlash(__('The person could not be saved. Please, try again.'));
					}
			} 
			else 
			{
				$options = array('conditions' => array('Person.' . $this->Person->primaryKey => $id));
				$this->request->data = $this->Person->find('first', $options);
				$this->Person->id = $id;
				$this->set('tipo_pessoa', $this->data['Person']['tipo_pessoa']);
				$contactstypes = $this->Contact->Contactstype->find('list', array('fields' => array('Contactstype.id', 'Contactstype.label'),'conditions' => array(
												'Contactstype.isactive'=>'Y', 'Contactstype.isdeleted'=>'N'
				)));
				$this->set('contactstypes',$contactstypes);
			}
            $this->set('title_for_layout', 'Editar dados de perfil de usuário');
		}



}
