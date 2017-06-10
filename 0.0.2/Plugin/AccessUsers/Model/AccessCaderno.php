<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * table cwaccess_users
 */
App::uses('AccessUserAppModel', 'AccessUsers.Model');
class AccessCaderno extends AccessUserAppModel {
    
       public $name = 'AccessCaderno';
       public $useTable = 'access_cadernos';
       public $tablePrefix = 'cwaccess_';   
   


    public $belongsTo = array(
		'User' => array(
			'className' => 'Manager.User',
			'foreignKey' => 'user_id',
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
		)
	);
    

    
    
    
    
    
    
}
