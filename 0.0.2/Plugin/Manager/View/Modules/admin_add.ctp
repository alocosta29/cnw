<div class="main">
	<h2>Módulos do sistema</h2>
		
<?php echo $this->Form->create('Module', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Cadastro de módulos do sistema'); ?></legend>
	<?php
		echo $this->Form->input('nome');
		echo $this->Form->input('alias');
	?>
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>
