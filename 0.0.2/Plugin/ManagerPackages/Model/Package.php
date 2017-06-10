<?php
App::uses('AppModel', 'Model');
class Package extends AppModel {
	public $displayField = 'nome';
	public $name = 'Package';
	public $useTable = 'packages';
	public $tablePrefix = 'cwaccess_';

		public $validate = array
	(

			'nome' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'Informa um nome para o pacote.'
					)),
			
			    'alias' => array(	
			    				'notempty' => array(
			    					'rule' => array('notempty'),
			    					'message' => 'Informa um alias único para o pacote.'
								)),
			    		
			    'plugin'=>array(
			    		'notempty' => array(
			    				'rule' => array('notempty'),
			    				'message' => 'Informa o nome do plugin do pacote.'
			    		
								))		
			    				
	);
        
        
        
        
 public $hasMany = array(
        'AccessUser' => array(
            'className' => 'AccessUsers.AccessUser',
            'foreignKey' => 'package_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true
        )
    ); 
        
        
	
}
