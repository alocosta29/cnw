<?php
App::uses('ManagerAppModel', 'Manager.Model');

/**
 * CompaniesIndividual Model
 *
 * @property IndividualsPerson $IndividualsPerson
 * @property CompaniesPerson $CompaniesPerson
 */
class CompaniesIndividual extends ManagerAppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Individual' => array(
			'className' => 'Individual',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Companie' => array(
			'className' => 'Companie',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}


