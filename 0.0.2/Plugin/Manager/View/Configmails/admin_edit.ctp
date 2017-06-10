<div class="main">
<?php echo $this->Form->create('Configmail', array('class'=>'default2'));?>
	<fieldset>
		<legend><?php echo __('Editar configuração de remetente'); ?></legend>
	<?php
	echo $this->Form->input('id');
	echo $this->Form->input('from', array('label'=>'Remetente'));
	if($this->Session->read('Auth.User.role_id') == 1):
		
		echo $this->Form->input('transport');
		
		echo $this->Form->input('host');
		echo $this->Form->input('port');
		echo $this->Form->input('timeout');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('client');
		echo $this->Form->input('emailFormat', array('value'=>'both'));
		echo $this->Form->input('log');
		echo $this->Form->input('charset');
		echo $this->Form->input('headerCharset');
		echo $this->Form->input('attachments');
		echo $this->Form->input('tls');
		echo $this->Form->input('template');
	endif;
	?>
	
<?php echo $this->Form->end(__('Atualizar'));?>
</fieldset>
</div>

