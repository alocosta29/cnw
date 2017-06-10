<?php
App::uses('CepEstado', 'Model');

/**
 * CepEstado Test Case
 *
 */
class CepEstadoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cep_estado'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CepEstado = ClassRegistry::init('CepEstado');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CepEstado);

		parent::tearDown();
	}

}
