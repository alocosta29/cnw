<?php
App::uses('CepCidade', 'Model');

/**
 * CepCidade Test Case
 *
 */
class CepCidadeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cep_cidade'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CepCidade = ClassRegistry::init('CepCidade');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CepCidade);

		parent::tearDown();
	}

}
