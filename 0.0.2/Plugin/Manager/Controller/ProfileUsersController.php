<?php

App::uses('ManagerAppController', 'Manager.Controller');
class ProfileUsersController extends ManagerAppController {
	public $uses = array('Manager.Person', 'Manager.Contactstype');
	//public $helpers = array('CakePtbr.Formatacao');
	public $components = array('Manager.Persona', 'Manager.ProfileValidation', 'Manager.CheckProfileData');
	
/*	public function beforeFilter()
	{
		parent::beforeFilter();
		if($this->params['action'] == 'cadastraUsuario')
		{
			$this->Session->setFlash(__('Por favor, antes de continuar, informe o CPF do usuário para verificarmos se 
			ja existe algum registro em nosso sistema!'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'verificaCpf', 'admin'=>true));
		}	
	} 	*/	
	
	//public function cadastraUsuario(){} 		
 		
 	/**
	 * Método que Verifica se a pessoa possui cadastro no sistema
	 * @name cadastra usuário
	 */	
	public function admin_verificaCpf(){
	if ($this->request->is('post'))
			{	
				$cpf = $this->request->data['Person']['cpf'];
				$verificaCpf = $this->Persona-> _consultaCpf($cpf);
				
				if(!isset($verificaCpf['resposta']))
				{
					$this->Session->setFlash(__($verificaCpf['msg']), 'default', array());	
				}
				elseif($verificaCpf['resposta'] == false)
				{
					//Não contém registro	
					$this->Session->write('cpf', $cpf);
					$this->Session->setFlash(__('Cadastre do dados do perfil'), 'default', array('class' => 'success'));
					$this->redirect(array('action'=>'cadastraPerfil'));
				}else{
					//Contém registro
					$this->Session->setFlash(__('O CPF pesquisado já se encontra em nossa base de dados.'), 'default', array('class' => 'success'));
					$this->redirect(array('plugin'=>'manager', 'controller'=>'persons', 'action'=>'view', $verificaCpf['person_id']));
				}
			}
      $this->set('title_for_layout', 'Cadastrar novo usuário');      
	}

	/**
	 * Cadastrar perfil de usuário
	 * @name cadastra perfil
	 */
	public function admin_cadastraPerfil()
	{
		if($this->request->is('post') || $this->request->is('post'))
		{
			if($this->CheckProfileData->startCheck($this->request->data))
			{
			    $data = $this->CheckProfileData->getData();
                $data['Person']['tipo_pessoa'] = 'F';
                $data['Addresse'][0]['pais'] = 'Brasil';
                $data['Individual'][0]['data_nascimento'] = null;
				$datasource = $this->Person->getDataSource();
				try{
				    $datasource->begin();
				    if(!$this->Person->saveAll($data, array('validate'=>'first')))
				        throw new Exception();
				    $datasource->commit();
					
					$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
					$this->redirect(array('plugin'=>'manager', 'controller'=>'persons', 'action'=>'view', 'admin'=>true, $this->Person->id));
					
				} catch(Exception $e) {
				    $datasource->rollback();
                    $this->request->data = $data;
					$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array());
				}
			}else{
				$this->Session->setFlash(__($this->CheckProfileData->getErrors()), 'default', array());
                $this->request->data = $data;
			}
		}
		$tipocontacttypes = $this->Contactstype->find('all', array('conditions'=>array('Contactstype.tipo'=>array('email', 'telefone', 'celular'))));
		$this->set('tipocontacttypes', $tipocontacttypes);
         $this->set('title_for_layout', 'Cadastro de usuário'); 
          if($this->Session->read('cpf')){
            $this->request->data['Individual'][0]['cpf'] = $this->Session->read('cpf');
            $this->Session->delete('cpf');
        }   
	}

	/**
	 * Método que consulta usuários do sistema
	 */
	 public function admin_consultaUsuarios()
	 {
		if($this->request->is('post'))
		{
			$dadosForm = $this->ProfileValidation->_userSearch($this->request->data);
			$this->Session->write('dadosForm', $dadosForm);
			$this->request->params['named']['page'] = 1;
		}elseif(isset($this->request->params['named']['page']))
		{
			$dadosForm = $this->Session->read('dadosForm');
		}
		if(isset($dadosForm)):	
    		$this->paginate = $dadosForm;
    		$this->Person->recursive = -1;
    		$teste = $this->paginate('Person');
    		$this->set('users', $this->paginate('Person'));
		endif;
	 }

}	