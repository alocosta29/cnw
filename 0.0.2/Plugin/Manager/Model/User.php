<?php
App::uses('AuthComponent', 'Controller/Component');
App::uses('SessionComponent', 'Controller/Component');
App::uses('ManagerAppModel', 'Manager.Model');

class User extends ManagerAppModel {
	public $name = 'User';
	public $displayField = 'username';
	 
	public $validate = array
	(
            'username' => array(
                                'notempty' => array(
                                                'rule' => array('notempty'),
                                                'message' => 'Informe o email do usuário.'
                                                ),
			    	'email' => array(
                                                'rule'    => array('email'),
                                                'message' => 'Por favor insira um email válido.'
                                                ),
			    	'isUnique' => array(
                                                    'rule'    => 'isUnique',
                                                    'message' => 'Este usuário já foi cadastrado.',
                                                    'on'=>'create'
                                                 )
                                ),
            'password' => array(
    				'notempty' => array(
                                                    'rule' => array('notempty'),
                                                    'message' => 'Informe a senha.',
                                                    'on'=>'create'
                                                    ),
    				'minLength' => array(
                                                    'rule' => array('minLength', '8'),
                                                    'message' => 'A senha deve possuir no mínimo 8 caracteres.',
                                                    'on'=>'create'
                                                    ),
				'criptografar' => array(
                                                    'rule' => array('criptografar'),
                                                    'message' => 'Senha incorreta...',
                                                    //'on'    => 'create'
                                                    )
                                ),
            'senhaAntiga' => array(
                                    'notempty' => array(
                                                        'rule' => array('notempty'),
                                                        'message' => 'Informe a senha antiga.',
                                                        'on'=>'update'
                                                        ),
                                    'checaSenhaAntiga' => array(
    	    							'rule' => array('checaSenhaAntiga'),
    	    							'message' => 'A senha digitada está incorreta!'
                                                                )
                                    ),
            'newPassword' => array(
                                    'notempty' => array(
                                                        'rule' => array('notempty'),
                                                        'message' => 'Informe a senha nova.',
                                                        'on'=>'update'
                                                        )
                                    ),
            'confirmPassword' => array(
                                        'notempty' => array(
                                                            'rule' => array('notempty'),
                                                            'message' => 'Repita a senha criada.'
                                                            //'on'=>'update'
                                                            ),
                                        'checaSenhaNova' => array(
                                                                  'rule' => array('checaSenhaNova'),
                                                                  'message' => 'A senha digitada não confere!'
                                                                    //'on'         => 'update'
                                                                   )
                                       ),

	//confirmação de senha no create
		   		'confirm_password' => array(

		    			    							    'notempty' => array(
		    			            									'rule' => array('notempty'),
		    			            									'message' => 'Repita a senha criada.',
    																	'on'=>'create'
	),
	 
		    			    								'repeteSenha' => array(
				    			    	    							'rule' => array('repeteSenha'),
				    			    	    							'message' => 'A senha digitada não confere!'
	)
	),
	 

	);


	public $hasAndBelongsToMany = array(
			'Role' => array(
				'className' => 'Role',
				'joinTable' => 'roles_users',
				'foreignKey' => 'user_id',
				'associationForeignKey' => 'role_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => '',
				'with' => 'RolesUser'
                            ),    
	);
    
     public $hasMany = array(
        'AccessUser' => array(
            'className' => 'AccessUsers.AccessUser',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true
        )
    );
    
    
	public $belongsTo = array(
		'Person' => array(
			'className' => 'Manager.Person',
			'foreignKey' => 'person_id',
			//'plugin'=>'manager',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'with' => 'Person'
		),
     
        'Individual' => array(
            'className' => 'Manager.Individual',
            //'joinTable' => 'roles_users',
            'foreignKey' => false,
           // 'associationForeignKey' => 'person_id',
            //'dependent' => true,
            'conditions' => array('User.person_id = Individual.person_id'),
            //'conditions' => array(' `User`.`person_id` = `Individual`.`person_id`'),
            'fields' => array('nome'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),

        'Addresse' => array(
            'className' => 'Manager.Addresse',
            //'joinTable' => 'roles_users',
            'foreignKey' => false,
           // 'associationForeignKey' => 'person_id',
            //'dependent' => true,
            'conditions' => array('User.person_id = Addresse.person_id'),
            //'conditions' => array(' `User`.`person_id` = `Individual`.`person_id`'),
          //  'fields' => array('nome'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
            ),
            
        'Colunista' => array(
            'className' => 'ManagerBook.Colunista',
            //'joinTable' => 'roles_users',
            'foreignKey' => false,
           // 'associationForeignKey' => 'person_id',
            //'dependent' => true,
            'conditions' => array('User.person_id = Colunista.person_id'),
            //'conditions' => array(' `User`.`person_id` = `Individual`.`person_id`'),
            'fields' => array('apelido', 'bio', 'resumo'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ), 
           'Avatar' => array(
            'className' => 'Avatar.Avatar',
            //'joinTable' => 'roles_users',
            'foreignKey' => false,
           // 'associationForeignKey' => 'person_id',
            //'dependent' => true,
            'conditions' => array('User.person_id = Avatar.person_id', 'Avatar.isdeleted' => 'N'),
            //'conditions' => array(' `User`.`person_id` = `Individual`.`person_id`'),
            'fields' => array('id', 'person_id', 'avatar'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),    
        
    );

	public function criptografar()
	{
		if(isset($this->data['User']['password']))
		{
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}

	public function checaSenhaAntiga()
	{
		$form = $this->data;
		//faço o hash com a senha antiga informada
		$senhaAntiga = $this->read('password');
		$senhaAntigaBd = $senhaAntiga['User']['password'];
		$senhaNovaForm = AuthComponent::password($form['User']['senhaAntiga']);;
		//Comparo
		if($senhaAntigaBd == $senhaNovaForm){
			$this->data = $form;
			return true;
		}else{
			//$this->data = $form;
			return false;
		}
	}


	public function checaSenhaNova()
	{
            $data = $this->data;
            $return = false;
            if(!empty($data['User']['password'])){
                $pass = $data['User']['password'];
            }
            if(!empty($data['User']['newPassword'])){
                $pass = AuthComponent::password($data['User']['newPassword']);
            }
            $compare = AuthComponent::password($data['User']['confirmPassword']);
            if($pass == $compare){
                $data['User']['password'] = $pass;
                $return = true;
            }
            $this->data = $data;
            return $return;
	}
	public function repeteSenha()
	{
		if(isset($this->data['User']['password']) and isset($this->data['User']['confirm_password']))
		{
			if($this->data['User']['password'] == AuthComponent::password($this->data['User']['confirm_password']))
			{
				return true;
			}
			else{
				return false;
			}
		}else{
			return true;
		}
	}
}
