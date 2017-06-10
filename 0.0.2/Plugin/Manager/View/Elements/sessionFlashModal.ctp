<?php 
if($this->Session->read('Message.flash.message') and $this->Session->read('Message.flash.element') == 'default'):
echo $this->Html->css(array('Manager.jquery-ui-1.8.18.custom'));?>
<?php echo $this->Html->script(array('jquery-1.8.3', 'Manager.ui/jquery-ui', 'Manager.ui/modal2'));?>
<?php
$msgFlashClass = $this->Session->read('Message.flash.params.class');
$msgFlash = $this->Session->read('Message.flash.message');
$msgFlashAuth = strip_tags($this->Session->flash('auth'),'<br>,<b>');
$flashExec = trim($msgFlashAuth.$this->Session->flash()); #Executa o comando para poder zerar o mesmo automaticamente.

if(strlen($flashExec)>0)
	{
	 switch ($msgFlashClass) {
	     case 'success':
	     case 'message':
				echo $this->Html->css(array('Manager.success_modal'));
	         break;
	     case 'cake-error':
	     case 'error':
	     case 'error-message':
				echo $this->Html->css(array('Manager.error_modal'));
	         break;
	     case 'notice':
				echo $this->Html->css(array('Manager.alert_modal'));
	         break;
	     default:
				echo $this->Html->css(array('Manager.error_modal'));
	         break;
	 }
	 ;?>
	<?php echo $this->Html->script(array('jquery-1.8.3', 'Manager.ui/jquery-ui', 'Manager.ui/modal'));?>
	<div id="dialog-form" title="AVISO IMPORTANTE!" height="auto">
	  <div id="centralizado"><br>
	<?php
	if(mb_detect_encoding($msgFlashAuth.$msgFlash, 'UTF-8', true)):
		echo $msgFlashAuth.$msgFlash;	
	else:
		echo utf8_encode($msgFlashAuth.$msgFlash);
	endif;	
	?></div>
	 <?php echo $this->Form->submit(__(' OK ',true), array('id'=>'btCloseFlashDivPopUp','style'=>'align:right;')); ?>
	</div>

<?php } 
	endif;
?>



