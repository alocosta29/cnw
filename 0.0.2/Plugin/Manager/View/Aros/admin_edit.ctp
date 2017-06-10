

<div class="main">
<?php echo $this->Form->create('Role', array('class' => 'default2')); ?>
<fieldset>
	<legend>Edição de papel/grupo</legend>
<?php  echo $this->Form->input('alias', array('label'=>'Pseudônimo')); ?>

<?php  echo $this->Form->input('role', array('label'=>'Nome do papel/grupo')); ?>
<?php echo $this->Form->end(__('Atualizar')); ?>

</fieldset>
</div>