<?php
App::uses('FormulariosAppModel', 'Formularios.Model');

/**
 * Email Model
 *
 */
class Destinatario extends FormulariosAppModel {
/**
 * Display field
 *
 * @var string
 */

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(

		'mail' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	

	);
	
	
	
	

	
	
}
