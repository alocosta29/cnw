<?php
App::uses('CepBairro', 'Model');

/**
 * CepBairro Test Case
 *
 */
class CepBairroTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cep_bairro'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CepBairro = ClassRegistry::init('CepBairro');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CepBairro);

		parent::tearDown();
	}

}
