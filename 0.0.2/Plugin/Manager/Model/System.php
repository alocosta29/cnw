<?php
App::uses('AppModel', 'Model');
App::uses('ManagerAppModel', 'Manager.Model');
/**
 * System Model
 *
 * @property NtNotification $NtNotification
 */
class System extends ManagerAppModel {

/**
 * Use database config
 *
 * @var string
 */
	#public $useDbConfig = 'plugin_db';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'NtNotification' => array(
			'className' => 'Notifications.Notification',
			'foreignKey' => 'system_acronym',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
