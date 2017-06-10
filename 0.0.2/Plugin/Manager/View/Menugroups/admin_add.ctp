<div class="main">
<?php echo $this->Form->create('Menugroup', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Criar grupo de opções'); ?></legend>
	<?php
		echo $this->Form->input('parent_id', array('label'=>'Grupo pai', 'options'=>$parent_id, 'default'=>0));
		echo $this->Form->input('grupo', array('label'=>'Nome do grupo'));
		$options = array(
		'N'=>'Não',
		'Y'=>'Sim'
		); 
		echo $this->Form->input('main_menu', array('label'=>'Aparecer no menu principal?', 'options'=>$options));
		echo $this->Form->input('ordem');
	?>
	
<?php echo $this->Form->end(__('Submit')); ?>
</fieldset>
</div>

