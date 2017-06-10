<?php 
if($this->Session->read('Message.flash.message') and $this->Session->read('Message.flash.element') == 'sessionFlashMessageFix'):
	$message = '<div class='.$this->Session->read('Message.flash.params.class').'>'.$this->Session->read('Message.flash.message').'</div>';
	UNSET($_SESSION['Message']['flash']['message']);
	echo $message;
	
	
endif; ?>	