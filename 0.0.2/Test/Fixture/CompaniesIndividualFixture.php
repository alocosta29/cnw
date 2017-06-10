<?php
/**
 * CompaniesIndividualFixture
 *
 */
class CompaniesIndividualFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'individuals_person_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'companies_person_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'individuals_person_id', 'companies_person_id'), 'unique' => 1),
			'fk_companies_individuals_individuals1' => array('column' => 'individuals_person_id', 'unique' => 0),
			'fk_companies_individuals_companies1' => array('column' => 'companies_person_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'individuals_person_id' => 1,
			'companies_person_id' => 1
		),
	);

}
