<?php
App::uses('ManagerAppModel', 'Model');
/**
 * Menugroup Model
 *
 * @property Menuiten $Menuiten
 */
class Menugroup extends ManagerAppModel {
	
	public $belongsTo = array(
		'ParentMenugroup' => array(
			'className' => 'Manager.Menugroup',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);


	public $hasMany = array(
		'ChildMenugroup' => array(
			'className' => 'Manager.Menugroup',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Aco' => array(
			'className' => 'Aco',
			'foreignKey' => 'menugroup_id',
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
