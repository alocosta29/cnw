<?php
App::uses('Individual', 'Model');

/**
 * Individual Test Case
 *
 */
class IndividualTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.individual',
		'app.person',
		'app.company',
		'app.companies_individual'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Individual = ClassRegistry::init('Individual');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Individual);

		parent::tearDown();
	}

}
