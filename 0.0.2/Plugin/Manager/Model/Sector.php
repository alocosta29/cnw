<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Sector extends ManagerAppModel {
	public $name = 'Sector';
	public $useTable = 'sectors';
	public $displayField = 'setor';
	public $tablePrefix = 'gp_';
    
		public $validate = array
		(
		'setor' =>array(
						'notEmpty' => array(
											'rule'=>'notEmpty',
											'message' => "Por favor digite o nome do setor!",
											)
					)
											
											
											
				);									
}
