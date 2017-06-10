<?php
App::uses('AppController', 'Controller');
/**
 * Notifications Controller
 *
 * @property Notification $Notification
 */
class NotificationsController extends AppController {
	public $uses = array('Notifications.Notification','Manager.User');
	
	public function regs(){
		//echo "<meta HTTP-EQUIV='refresh' CONTENT='30'>"; #Atualiza o iframe a cada 30seg
	}

}
