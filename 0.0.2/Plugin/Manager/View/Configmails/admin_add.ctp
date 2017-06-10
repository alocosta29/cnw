<div class="main">
<?php echo $this->Form->create('Configmail', array('class'=>'default2'));?>
	<fieldset>
		<legend><?php echo __('Adicionar configuração de remetente'); ?></legend>
	<?php
		echo $this->Form->input('transport');
		echo $this->Form->input('from');
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
	?>
	
<?php echo $this->Form->end(__('Adicionar'));?>
</fieldset>
</div>

