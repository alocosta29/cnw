<?php
App::uses('ManagerAppModel', 'Manager.Model');

class RolesUser extends ManagerAppModel {
	public $name = 'RolesUser';
	public $useTable = 'roles_users';

	public $validate = array
	(
	
	'user_id' => array('isUnique' => array(
			    			        'rule'    => 'isUnique',
			    			        'message' => 'Este usuário já possui permissão.',
			    			        'on'=>'create'
			    					))
	);
    
	public $belongsTo = array
	(
		'User' => array(
			'className' => 'Manager.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Role' => array(
			'className' => 'Manager.Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}


