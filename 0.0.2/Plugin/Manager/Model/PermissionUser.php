<?php
App::uses('ManagerAppModel', 'Manager.Model');

class PermissionUser extends ManagerAppModel{
    
    
    
    
    
    
    
    	public $belongsTo = array(
                        		'Person' => array(
                        			'className' => 'Manager.Person',
                        			'foreignKey' => 'person_id',
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
            
                                      'Package' => array(
                        			'className' => 'ManagerPackages.Package',
                        			'foreignKey' => 'package_id',
                        			'conditions' => '',
                        			'fields' => '',
                        			'order' => ''
                        		      )
            
            
            
            
	                           );
    
    
    
    
    
    
    
    
    
    
    
    
}