<?php
App::uses('ManagerAppModel', 'Model');
/**
 * Module Model
 *
 * @property Menuiten $Menuiten
 */
class Module extends ManagerAppModel {
	

	public $hasMany = array(
		'Aco' => array(
			'className' => 'Aco',
			'foreignKey' => 'module_id',
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
