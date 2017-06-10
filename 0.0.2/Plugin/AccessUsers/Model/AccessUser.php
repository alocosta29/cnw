<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * table cwaccess_users
 */
App::uses('AccessUserAppModel', 'AccessUsers.Model');

class AccessUser extends AccessUserAppModel {
    
   public $name = 'AccessUser';
   public $useTable = 'access_users';
   public $tablePrefix = 'cwaccess_';   

    public $belongsTo = array(
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

