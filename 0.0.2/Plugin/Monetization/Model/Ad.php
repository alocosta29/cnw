<?php
App::uses('MonetizationAppModel', 'Monetization.Model');
class Ad extends MonetizationAppModel{
	//public $displayField = 'nome';
	public $name = 'Ad';
	public $useTable = 'ads';
	public $tablePrefix = 'ads_';

        
        
         public $validate = array
	(
                'link' => array(
                                'notempty' => array(
                                                'rule' => array('notempty'),
                                                'message' => 'Campo obrigatório'
                                )),
                                
             
             
             
             
         );    

        
    
  public $belongsTo = array(
                                'AdType' => array(
                                                    'className' => 'Monetization.AdType',
                                                    'foreignKey' => 'type_id',
                                                    'conditions' => '',
                                                    'fields' => '',
                                                    'order' => ''
                                                  ),
        
                                'Caderno' => array(
                                                    'className' => 'ConfigBook.Caderno',
                                                    'foreignKey' => 'caderno_id',
                                                    'conditions' => '',
                                                    'fields' => '',
                                                    'order' => ''
                                                  ),
                                'User' => array(
                                                    'className' => 'Manager.User',
                                                    'foreignKey' => 'user_id',
                                                    'conditions' => '',
                                                    'fields' => '',
                                                    'order' => ''
                                                  ),
                            );
    

    
    
    
    
}