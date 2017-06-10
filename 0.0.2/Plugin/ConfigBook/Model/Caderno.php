<?php
App::uses('ConfigBookAppModel', 'ConfigBook.Model');
class Caderno extends ConfigBookAppModel
{
        public $name = 'Caderno';
	public $useTable = 'cadernos';
        public $tablePrefix = 'cw_';


}