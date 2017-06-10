<?php
App::uses('AppModel', 'Model');
App::uses('ManagerAppModel', 'Manager.Model');
/**
 * System Model
 *
 * @property NtNotification $NtNotification
 */
class Sysparams extends ManagerAppModel {
	public $name = 'Sysparams';
	public $useTable = 'sysparams';
	public $useDbConfig = 'default';

}
