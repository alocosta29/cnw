<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Person extends ManagerAppModel {
	public $useTable = 'persons';
	public $name = 'Person';


	public $hasMany = array(
		'Addresse' => array(
			'className' => 'Manager.Addresse',
			'foreignKey' => 'person_id',
			//'dependent' => TRUE,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Companie' => array(
			'className' => 'Manager.Companie',
			'foreignKey' => 'person_id',
			//'dependent' => TRUE,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		
		'Contact' => array(
			'className' => 'Manager.Contact',
			'foreignKey' => 'person_id',
			//'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Individual' => array(
			'className' => 'Manager.Individual',
			'foreignKey' => 'person_id',
			//'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		
		'AccessUser' => array(
			'className' => 'Manager.AccessUser',
			'foreignKey' => 'person_id',
			//'dependent' => false,
			'conditions' => array('isactive'=>"Y"),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
 


	'User' => array(
				'className' => 'Manager.User',
				'foreignKey' => 'person_id',
				//'dependent' => false,
				'conditions' => '',
				'fields' =>'',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
	),
    'Colunista' => array(
				'className' => 'ManagerBook.Colunista',
				'foreignKey' => 'person_id',
				//'dependent' => false,
				'conditions' => '',
				'fields' =>'',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
	),
	);
    
    
      /*public $hasOne = array(
        'Companie' => array(
            'className' => 'Manager.Companie',
            'foreignKey' => 'person_id',
            //'dependent' => TRUE,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );  */

}
	

