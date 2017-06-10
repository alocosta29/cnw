<?php
App::uses('AppModel', 'Model');
App::uses('NotificationsAppModel', 'Notifications.Model');
/**
 * NtNotification Model
 *
 * @property System $System
 * @property FromUser $FromUser
 * @property ToUser $ToUser
 */
class Notification extends NotificationsAppModel {

/**
 * Use database config
 *
 * @var string
 */
	//public $useDbConfig = 'plugin_db';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'nt_notifications';
    
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'System' => array(
			'className' => 'Manager.System',
			'foreignKey' => false,
            'conditions' => array('System.acronym = Notification.system_acronym'),
			'fields' => '',
			'order' => ''
		),
		'FromUser' => array(
			'className' => 'Manager.User',
			'foreignKey' => 'from_user_id',
			'conditions' => '',
			'fields' => array('id','username','status','person_id','created','createdby','modified','modifiedby','isactive','isdeleted'),
			'order' => ''
		),
		'ToUser' => array(
			'className' => 'Manager.User',
			'foreignKey' => 'to_user_id',
			'conditions' => '',
			'fields' => array('id','username','status','person_id','created','createdby','modified','modifiedby','isactive','isdeleted'),
			'order' => ''
		),
		'UserCreated' => array(
			'className' => 'Manager.User',
			'foreignKey' => 'createdby',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('id','username','status','person_id','created','createdby','modified','modifiedby','isactive','isdeleted'),
			'order' => ''
		),
		'UserModified' => array(
			'className' => 'Manager.User',
			'foreignKey' => 'modifiedby',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('id','username','status','person_id','created','createdby','modified','modifiedby','isactive','isdeleted'),
			'order' => ''
		)		
		
	);
}
