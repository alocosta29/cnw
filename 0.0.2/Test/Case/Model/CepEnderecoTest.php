<?php
App::uses('CepEndereco', 'Model');

/**
 * CepEndereco Test Case
 *
 */
class CepEnderecoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cep_endereco',
		'app.cidade',
		'app.bairro'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CepEndereco = ClassRegistry::init('CepEndereco');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CepEndereco);

		parent::tearDown();
	}

}
