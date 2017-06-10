<?php
/**
 * CepEnderecoFixture
 *
 */
class CepEnderecoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'uf' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cidade_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'nomeslog' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 300, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nomeclog' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 300, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'bairro_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'logradouro' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 300, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cep' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 300, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'uf_cod' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255),
		'logracompl' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 300, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'uf' => '',
			'cidade_id' => 1,
			'nomeslog' => 'Lorem ipsum dolor sit amet',
			'nomeclog' => 'Lorem ipsum dolor sit amet',
			'bairro_id' => 1,
			'logradouro' => 'Lorem ipsum dolor sit amet',
			'cep' => 'Lorem ipsum dolor sit amet',
			'uf_cod' => 1,
			'logracompl' => 'Lorem ipsum dolor sit amet'
		),
	);

}
