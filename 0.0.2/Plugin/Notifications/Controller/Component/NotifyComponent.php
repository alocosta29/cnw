<?php

App::uses('Notification', 'Notifications.Model');

class NotifyComponent extends Component {
  	private $erros = null;
  
	public function send($toUserid, $msg=null, $urltarget=null){
		$Notification = new Notification();
		$Notification->create();
        if (!defined('SYS')) {
          define('SYS', 'SYS');
        }        
		$Notification->set('system_acronym', SYS);
		$Notification->set('to_user_id', $toUserid);
		$Notification->set('msg_text',$msg);
		$Notification->set('urltarget',$urltarget);
		$Notification->save();
	}
	
	public function url($url = null, $full = true) {
		return Router::url($url, $full);
	}
}