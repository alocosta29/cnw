<?php $this->layout = 'administrador'; ?> 
<div class="assist">
	<?php 
		echo '<br><ul>'.$this->element('Manager.dynamicmenu').'</ul><br>'; 
	 ?>
</div>
<div class="main">
<?php echo $this->Form->create('Model', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('titulo'); ?></legend>
	<?php echo $this->Form->input('campo'); ?>
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>