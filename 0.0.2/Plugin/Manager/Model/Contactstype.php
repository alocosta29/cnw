<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Contactstype extends ManagerAppModel {


	public $hasMany = array(
		'Contact' => array(
			'className' => 'Manager.Contact',
			'foreignKey' => 'contactstype_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
		
	);
	
	
}
