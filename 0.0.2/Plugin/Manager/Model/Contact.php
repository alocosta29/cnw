<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Contact extends ManagerAppModel {

    
    
    
    
    public $validate = array
    (
        'delSpaceContact' =>array(
    
            'delSpace' => array(
                            'rule'    => 'delSpaceContact',
                           // 'message' => 'CPF inválido',
                           // 'on' => 'create'
            ),
            ),      
    
    
    
    );
    

        public function delSpaceContact(){
            
            pr($this->data);
            exit(0);
            
            
            
        }




	public $belongsTo = array(
		'Person' => array(
			'className' => 'Manager.Person',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contactstype' => array(
			'className' => 'Manager.Contactstype',
			'foreignKey' => 'contactstype_id',
			//'dependent' => TRUE,
			'conditions' => '',
			'fields' => array('id', 'tipo','label','ordem'),
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		));
	
	
}


