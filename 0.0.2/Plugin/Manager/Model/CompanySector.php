<?php
App::uses('ManagerAppModel', 'Manager.Model');

class CompanySector extends ManagerAppModel {
	public $name = 'CompanySector';
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
