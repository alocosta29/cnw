<?php if($this->Session->read('Message.flash.message')): ?>
		<div style="width: 100%; float: left; height: auto; margin-left: 0px; clear:both;">
			<?php
			if($this->Session->read('Message.flash.params.class') == 'success'){
				$classCss = 'messageFixSuccess';
			}elseif($this->Session->read('Message.flash.params.class') == 'notice'){
			    $classCss = 'messageFixNotification';
			}else{
				$classCss = 'messageFixError';
			}
			$message = '<div class='.$classCss.'>'.$this->Session->read('Message.flash.message').'</div>';
			UNSET($_SESSION['Message']['flash']['message']);
			echo $message; ?>
		</div>
<?php endif; ?>