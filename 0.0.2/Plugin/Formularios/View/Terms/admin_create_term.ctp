<?php echo $this->Cms->getCms('texto'); ?>

<div class="telatoda" style = "width: 95%; margin-left: 1%;  ">
    <h2>Criação/edição de termos de adesão</h2>
<?php echo $this->Form->create('Term', array('class'=>'default2', 'style'=>"width: 100%;  ")); ?>
	<fieldset>
		<legend><?php echo __('Editar texto'); ?></legend>
	<?php echo $this->Form->input('texto', array('id'=>'texto','class'=>'ckeditor')); ?>
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>
