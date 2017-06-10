<?php
App::uses('ManagerAppModel', 'Manager.Model');

class AcoAdmin extends ManagerAppModel{
	public $name = 'AcoAdmin';
	public $useTable = 'acos';
	
	
	
	 public $validate = array(   
    	'menugroup_id' => array(	
			'notempty' => array(
				'rule' => array('notempty'),
    			'message' => 'É necessário definir um grupo para o item de menu!'
    		)),
 			
    	'ordem_menu' => array(	
			'notempty' => array(
				'rule' => array('notempty'),
    			'message' => 'É necessário definir a posição do item no menu!'
    		)),
    	'aliasMenu' => array(	
			'notempty' => array(
				'rule' => array('notempty'),
    			'message' => 'O nome da funcionalidade está vazio'
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


