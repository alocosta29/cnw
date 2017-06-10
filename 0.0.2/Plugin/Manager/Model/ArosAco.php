<?php
App::uses('ManagerAppModel', 'Manager.Model');

/**
 * CompaniesIndividual Model
 *
 * @property IndividualsPerson $IndividualsPerson
 * @property CompaniesPerson $CompaniesPerson
 */
class ArosAco extends ManagerAppModel{
	public $name = 'ArosAco';
	
	//public $useDbConfig = '$default';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $useTable = 'aros_acos';
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Aro' => array(
			'className' => 'Acl.Aro',
			'foreignKey' => 'aro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Aco' => array(
			'className' => 'Acl.Aco',
			'foreignKey' => 'aco_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}


