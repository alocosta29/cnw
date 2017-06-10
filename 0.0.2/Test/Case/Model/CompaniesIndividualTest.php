<?php
App::uses('CompaniesIndividual', 'Model');

/**
 * CompaniesIndividual Test Case
 *
 */
class CompaniesIndividualTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.companies_individual',
		'app.individuals_person',
		'app.companies_person'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CompaniesIndividual = ClassRegistry::init('CompaniesIndividual');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CompaniesIndividual);

		parent::tearDown();
	}

}
