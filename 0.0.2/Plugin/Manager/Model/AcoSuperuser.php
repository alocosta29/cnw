<?php
App::uses('ManagerAppModel', 'Manager.Model');

class AcoSuperuser extends ManagerAppModel{
	public $name = 'AcoSuperuser';
	public $useTable = 'acos';
	
	
	
	
	 public $validate = array(   
    	'aliasMetodo' => array(	
			'notempty' => array(
				'rule' => array('notempty'),
    			'message' => 'Apelido do método nao pode ficar vazio!'
    		)),
 			
    	'descricao' => array(	
			'notempty' => array(
				'rule' => array('notempty'),
    			'message' => 'Descrição do método nao pode ficar vazia!'
    		)),
    	'module_id' => array(	
			'notempty' => array(
				'rule' => array('notempty'),
    			'message' => 'É necessário informar o modulo ao qual a action pertence!'
    		))
	);

		public $belongsTo = array(
		'Module' => array(
			'className' => 'Manager.Module',
			'foreignKey' => 'module_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	
	
}


