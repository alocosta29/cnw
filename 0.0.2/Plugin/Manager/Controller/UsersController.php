<?php
App::uses('ManagerAppController', 'Manager.Controller');
class UsersController extends ManagerAppController {
	public $uses = array('Manager.User', 'Manager.RolesUser', 'Manager.Person', 'Manager.Individual', 'Manager.Companie', 'Manager.Contact');
	public $components = array('Manager.Cryptx', 'Manager.MenuTester', 'ManagerBook.SendMailUsers');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('admin_logout');
		if($this->Session->read('Auth.User.role_id')):
			$this->Auth->allow(array('admin_index', 'admin_logout', 'admin_trocarsenha'));
		endif;	
	}

	public function admin_index(){
     //  $this(->Notify->send(1, 'Uma mensagem ');
         //   pr($this->Session->read('Auth.User')); exit(0); 
            
            
		$this->set('title_for_layout', '');
	}

    public function admin_disableuser($id = null) 
	{
		if ( ($this->Auth->user('role_id') !== 1) || ($this->Auth->user('role_id') != 2) )  {
			if($id == $this->Auth->user('id')) {
				$this->Session->setFlash(__('Você não pode desativar a sua própria conta! Solicite esta tarefa a um administrador...'), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->Session->setFlash(__('Seu perfil não lhe permite desativar usuários.'));
			$this->redirect(array('action' => 'index'));
		}
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Usuario invalido!'));
		}
		$this->User->read(null, $id);
		$this->User->set('isactive', 'N');
		$this->User->set('status', '0');
		if(isset($this->User->data['User']['password'])) unset($this->User->data['User']['password']);
		
		if ($this->User->save()) {
			if($id == $this->Auth->user('id')) {
				$this->Session->setFlash(__('Desativação concluida. Você não está mais logado...'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'logout'));
			}
		$this->Session->setFlash(__('Usuário desativado...'), 'default', array('class' => 'success'));
		#$this->redirect(array('action' => 'index'));
		$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('O usuário não foi desativado.'));
		$this->redirect(array('action' => 'index'));
	}

	public function admin_disablelist()	
	{
		if(($this->Auth->user('role_id') !== 1) || ($this->Auth->user('role_id') != 2) )  {
			$this->User->recursive = 3;
			$this->set('users', $this->paginate('User', array('User.status' => '0','User.isactive' => 'N','User.isdeleted' => 'N')));
		}else{
			$this->Session->setFlash(__('Somente administradores podem acessar esta lista.'));
			$this->redirect(array('action' => 'index'));
		}
	}

	public function admin_reactivate($id = null) {
		if($id == $this->Auth->user('id')) {
			$this->Session->setFlash(__('Você não pode ativar a sua própria conta! Solicite esta tarefa a um administrador...'));
			$this->redirect(array('action' => 'index'));
		} elseif($id == $this->Auth->user('id')) {
			$this->Session->setFlash(__('Você não pode ativar a sua própria conta! Solicite esta tarefa a outro administrador...'));
			$this->redirect(array('action' => 'index'));
		}
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
			
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Usuário inválido!'));
		}

		$this->User->read(null, $id);
		$this->User->set('isactive', 'Y');
		$this->User->set('status', '1');
		
		if(isset($this->User->data['User']['password'])) unset($this->User->data['User']['password']);
		
		if ($this->User->save()) {
			if($id == $this->Auth->user('id')) {
				$this->Session->setFlash(__('Ativação concluida. Você não esta mais logado...'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'logout'));
			}
			$this->Session->setFlash(__('Usuário ativado...'), 'default', array('class' => 'success'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('O usuário não foi ativado.'));
		$this->redirect($this->referer());
	}
	
	
	public function admin_add($id = null) 
	{
		if(isset($id) and !empty($id)) {
			$pesquisaUser = $this->User->find('all', array('conditions'=>array('User.person_id'=>$id)));
			if(isset($pesquisaUser) and !empty($pesquisaUser)) {
				$this->Session->setFlash('O usuário selecionado já possui login e senha cadastrado');
				$this->redirect(array('controller'=>'persons', 'action'=>'view', 'admin'=>true, $id));
			} else {
				$person = $this->Person->find('all', array('conditions'=>array('Person.id'=>$id)));
				$this->set('person', $person);
				if(!empty($this->request->data)):
				$this->User->create();
				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__('Cadastro efetivado com sucesso'), 'default', array('class' => 'success'));
					$this->redirect(array('action' => 'login'));
				} else {
					$this->Session->setFlash(__('Erro no cadastro. Tente de novo.'), 'default', array('class' => 'error'));
				}
				endif;
			}
		} else {
			$this->Session->setFlash('Selecione um registro para criação de login e senha');
			$this->redirect(array('controller'=>'users', 'action'=>'consultaCadastro', 'admin'=>true));
		}
	}
	 
	public function admin_logout()
	{
		$this->Session->setFlash(__('Deslogado com sucesso.'), 'default', array('class' => 'success'));
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}

	public function _checkPermission()
	{
		$permission = $this->User->RolesUser->find('all', array(
			   	'conditions'=>array(
			   	'RolesUser.user_id'=>$this->Session->read('Auth.User.id')),
			   	'fields'=> array('RolesUser.role_id')));
		if(isset($permission[0]['RolesUser']['role_id']) AND !empty($permission[0]['RolesUser']['role_id']))
		{
			$permission  = $permission[0]['RolesUser']['role_id'];
			$this->Session->write('Auth.User.role_id', $permission);
			return true;
		}else{
			return false;
		}
	}

	public function admin_login()
	{ 

        $this->SendMailUsers->start(array('A', 'B'));
        if(!$this->Session->read('Auth.User.username'))
        {
                    if($this->Session->read('Auth.User.Person')){
                    $this->Session->delete('Auth.User.Person');
                    }
                    $ola = $this->User->find('all');
                    $this->set('ola' ,$ola);
                    $usuarioNivel = $this->Session->read('Auth.User.role_id');
            
                    if ($this->request->is('post')) 
                    {
                                
                        if ($this->Auth->login()) {
                            if ($this->_checkPermission() == true) 
                            {
                               # $this->ExecuteActions->start();
                                $this->redirect(array('controller' => 'users', 
                                                        'action' => 'index',
                                                        'plugin'=>'manager',
                                                        'admin'=>true));
                            } 
                            else 
                            {
                                $dadosUser = $this->User->read(null, $this->Auth->user('id'));
                                if (count($dadosUser['Role']) <= 0)
                                {
                                    $this->Session->setFlash(__('Você não tem permissão para logar neste sistema!'), 'default', array());
                                } 
                                else 
                                {
                                    $this->Session->setFlash(__('Não foi possível logar neste sistema!'), 'default', array());
                                }
                                $this->Session->delete('Auth');
                                $this->redirect($this->Auth->logout());
                            }
                        }else{
                            $this->Session->setFlash(__('Certifique-se da correta digitação do login ou senha!'), 'default', array());
                        }
                    }
        }else{
            $this->redirect(array('controller' => 'users', 'action' => 'index', 'plugin'=>'manager', 'admin'=>true));
        }
	}

	public function admin_view($id = null) 
	{
		$this->User->recursive = 3;
		if ($this->Auth->user('role_id') != 1 and $this->Auth->user('role_id') != 2) {
			if ($id != $this->Auth->user('id')) 
			{
				$this->Session->setFlash(__('Seu perfil não lhe permite visualizar outros usuários.'));
			}
			$id = $this->Auth->user('id');
		}
		$this->User->id = $id;
		$data = $this->User->read(null, $id);
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Usuário inválido!'));
		}
		elseif($data['User']['isactive'] == 'N')
		{
			$this->Session->setFlash(__('Usuários suspensos não são visualizados nesta lista.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function admin_edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Usuário Inválido'));
		}

		$this->User->recursive = 3;
		if ($this->request->is('post') || $this->request->is('put')) {
			if( (trim($this->request->data['User']['newPassword'])==='') && (trim($this->request->data['User']['confirmPassword'])==='') ){
				unset($this->request->data['User']['newPassword']);
				unset($this->request->data['User']['confirmPassword']);
			}
			if(isset($this->request->data['User']['password'])) unset($this->request->data['User']['password']);
			//pr($this->request->data['Person']['Contact']);exit(0);
			$person = $this->request->data['Person'];
			foreach ($person['Contact'] as $key => $value) {
				if( (!isset($person['Contact'][$key]['id'])) &&(strlen(trim($person['Contact'][$key]['contato']))<=0) && (strlen(trim($person['Contact'][$key]['pessoa_paracontato']))<=0) ){
					unset($person['Contact'][$key]);
				} elseif((isset($person['Contact'][$key]['id'])) &&(strlen(trim($person['Contact'][$key]['contato']))<=0) && (strlen(trim($person['Contact'][$key]['pessoa_paracontato']))<=0) ){
					$this->Contact->delete($person['Contact'][$key]['id']);
					unset($person['Contact'][$key]);
				}
			}
			
			if(!$this->Person->saveAll($person)){
				$this->Session->setFlash(__('O usuário não pode ser salvo. Por favor, tente novamente.'));
				$this->redirect(array('action' => 'index'));
			}
	
			/**
			 * Tratamento especial para edicao de roles/grupos/perfils
			 */
			if ( isset($this->request->data['Role']) ){
				$auxGrAntigo = $this->Cryptx->encrypt($this->request->data['Role'][0], false);
				$auxIdGrupoAntigo = explode('del_', $auxGrAntigo);
				if ( isset($this->request->data['Role'][0]) && (strlen(trim($this->request->data['Role'][0]))>0) && (isset($auxIdGrupoAntigo[1])) && is_array($auxIdGrupoAntigo) ){
					$idGrAntigo = $auxIdGrupoAntigo[1];
					$this->RolesUser->recursive = -1;
					$rolesUsersAntigo = $this->RolesUser->find('first', array('conditions' => array(
						'RolesUser.role_id'=>$idGrAntigo, 'RolesUser.user_id'=>$id 
					)));
					if(isset($rolesUsersAntigo['RolesUser']['id'])){
						$this->RolesUser->delete($rolesUsersAntigo['RolesUser']['id']);
					}
					if( isset($this->request->data['Role']) ) unset($this->request->data['Role']);
				} else {
					$idGrAntigo = substr($this->Cryptx->encrypt($this->request->data['User']['roleAtual'], false),strlen($this->Cryptx->getPrefixo()) );
					
					$idGrNovo = isset($this->request->data['Role']) ? $this->request->data['Role'][0]+0 : 0;
					if ( ($idGrNovo>1) && ($idGrNovo!=='3') ){
						$this->RolesUser->recursive = -1;
						$this->RolesUser->data = $this->RolesUser->find('first', array('conditions' => array(
							'RolesUser.role_id'=>$idGrAntigo, 'RolesUser.user_id'=>$id 
						)));
						$this->RolesUser->set('user_id', $id);
						$this->RolesUser->set('role_id', $idGrNovo);
						$this->RolesUser->save();
					} 
					if( isset($this->request->data['Role']) ) unset($this->request->data['Role']);
				}
			}
			
			if ($this->User->saveAll($this->request->data)) {
				$this->Session->setFlash(__('Dados do usuário atualizados com sucesso!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'edit/'.$id));
			} else {
				$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
				$this->request->data = $this->User->find('first', $options);
				$this->Session->setFlash(__('O usuario não pode ser salvo. Por favor, tente novamente.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
			//pr($this->request->data); exit(0);
                        $roleIdX = $this->Auth->user('role_id');
			$userIdX = $this->Auth->user('id');
			/**
			 * Editcao do perfil somente e permitida se:
			 * Se usuarioAutenticado for do grupo SuperUser(1) 
			 * OU
			 * Se usuarioAutenticado for do grupo Admin e nao estiver editando seu proprio perfil ou do superuser
			 */
			if ( isset($this->request->data['Role']['0']['id']) ){
				if (!( ( $roleIdX ==='1' ) || ( ($roleIdX ==='2') && ( ($this->request->data['Role']['0']['id'] !== '1') ) && ( ($roleIdX ==='2') && ($this->request->data['User']['id'] !== $userIdX) ) ) )){
					$this->Session->setFlash(__('Não é possível editar os dados de login deste usuário!'), 'default', array('class' => 'notice'));
					$this->redirect($this->referer());
				}
			} else {
				if (!( ($roleIdX ==='1') || ($roleIdX ==='2') )){
					$this->Session->setFlash(__('Não é possível editar os dados de login deste usuário!'), 'default', array('class' => 'notice'));
					$this->redirect($this->referer());
				}
			}

		}
                $roleSelect = $this->Session->read('Auth.User.role_id');
                if($roleSelect == 1){
                    $groups = array(3);
                    
                }else{
                    $groups = array(1, 2, 3);
                }
                
                
                
               # pr($roleSelect); exit(0);  

                
                
                $condRole = array(
                    'fields' => array('Role.id', 'Role.alias'),
                    'order'=>array('Role.id'=>'asc'),
                    'conditions' => array(
                                        'Role.isactive'=>'Y', 'Role.isdeleted'=>'N',
                                        'NOT'=>array('Role.id'=>$groups)));
		$rolesX = $this->User->Role->find('list', $condRole);
		
		
                
                if(isset($roles)) unset($roles); $roles = array();
		
                
                if( !isset($this->request->data['Role']['0']['id']) ) $this->request->data['Role']['0']['id'] = 0;
		$roles[$this->Cryptx->encrypt('del_'.$this->request->data['Role']['0']['id'])] = 'SEM GRUPO';
		foreach ($rolesX as $key => $value) { $roles[$key] = $value; }
		
                
           
                $this->set('roles', $roles);
		$this->set('rolesAntigo', $this->Cryptx->encrypt($this->request->data['Role']['0']['id']) );
		
		$contactstypes = $this->Contact->Contactstype->find('list', array('fields' => array('Contactstype.id', 'Contactstype.label'),'conditions' => array(
												'Contactstype.isactive'=>'Y', 'Contactstype.isdeleted'=>'N'
		)));
		$this->set('contactstypes',$contactstypes);
	}


	public function admin_delete($id = null) {
		$this->User->id = $id;
		if(!$this->User->exists()) {
			throw new NotFoundException(__('Usuario invalido!'));
		}
		$this->User->set('isdeleted', 'Y');
		$this->User->set('isactive', 'N');
		$this->User->set('status', '0');
		if(isset($this->User->data['User']['password'])) unset($this->User->data['User']['password']);
		if(isset($this->request->data['User']['password'])) unset($this->request->data['User']['password']);
		
		if ( $this->User->save($this->request->data) ){
			$this->Session->setFlash(__('Usuario excluído com sucesso!'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'disablelist'));
		}else{
			$this->Session->setFlash(__('Não foi possível excluir usuario.'), 'default', array('class' => 'notice'));
		}
		$this->redirect(array('action' => 'disablelist'));
	}

	public function admin_trocarsenha() {
		$this->set('title_for_layout', 'Alteração de senha de acesso');
		$exploReferer = explode('/',$this->referer());
		$tstUrl = array_pop($exploReferer);
		if ( $tstUrl !== 'trocarsenha' ){
			$this->Session->write('trocarsenhaUrlAnterior', $this->referer());
		}
		if ( ($this->request->is('post') || $this->request->is('put') ) && ($this->request->data['User']) ) {
			if (isset($this->request->data['User']['username'])) {
				unset($this->request->data['User']['username']);
			}
            $data = $this->request->data;
            $data['User']['recent_register'] = 'N';
            $data['User']['pass_register'] = null;
           
			if ( $this->User->save($data) ){
                if($this->Session->read('Auth.User.recent_register') == 'Y'){
                    $this->Session->setFlash(__('Sua senha foi alterada com sucesso! Por favor, faça o login novamente utilizando a nova senha! '), 'default', array('class' => 'success'));
                    $this->redirect($this->Auth->logout());
                }else{
                    $this->Session->setFlash(__('Sua senha foi alterada com sucesso!'), 'default', array('class' => 'success'));
                    $urlAnterior = $this->Session->read('trocarsenhaUrlAnterior');
                    $this->Session->delete('trocarsenhaUrlAnterior');
                    $this->redirect($urlAnterior); //Redireciona para a pagina anterior, a pagina que chamou o trocarsenha
                }
				
			}else{
				$this->Session->setFlash(__('Dados inválidos! Senha inalterada.'), 'default', array('class' => 'notice'));
			}

			$this->set("id", $this->request->data["User"]["id"]);
			$this->set("nome", $this->request->data["User"]["namex"]);
		} else {
			$iD = AuthComponent::user('id');
			if ((!empty($iD))) {
				$userPass = $this->User->query("SELECT * FROM users as User WHERE id = ".$iD."");
				$this->set("id", $iD);
				$this->set("nome", $userPass[0]['User']['username']);
			}
		}
	}

	public function admin_list()
	{
		$this->User->recursive = 3;
		$rs = $this->paginate('User', array('User.status' => '1','User.isactive' => 'Y','User.isdeleted' => 'N'));
		$roleId = $this->Auth->user('role_id');
		
		/**
		 * Se usuario nao for superUser(grupo1):
		 */
		if ($roleId !== '1') {
			/**
			 * Se usuario nao for admim(grupo2)
			 */
			if ($roleId !== '2'){
				foreach($rs as $key => $value) {
					if(isset($rs[$key]['Role']['0']['id'])) {
						if($rs[$key]['Role']['0']['id'] !== "$roleId"){
							unset($rs[$key]);
						}
					}
					if(isset($rs[$key]['Role'])) {
						if ( count($rs[$key]['Role'])<=0 ) {
							unset($rs[$key]);
						}
					}
				}
			}else{ #se for admim:
				foreach($rs as $key => $value) {
					if(isset($rs[$key]['Role']['0']['id'])) {
						if($rs[$key]['Role']['0']['id'] === '1'){
							unset($rs[$key]);
						}
					}
				}
			}
		}
		//pr($rs);exit(0);
		#qdo nao tem grupo, o count(role) = 0,Neste caso mostrar somente para o usuario adm e o usuario superuser
		$this->set('users', $rs);
	}
}