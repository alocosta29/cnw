<?php echo $this->Html->script(array('Manager.jquery.slug')); ?>

<div class="main">
<script type="text/javascript"> 
$(document).ready(function(){ 
$("#pseud").slug(); 
}); 
</script>	
	<?php echo $this->Form->create('Role', array('class' => 'default2')); ?>
<fieldset>
	<legend>Criar novo papel/grupo no sistema</legend>

<?php echo $this->Form->input('alias', array('label'=>'Pseudônimo', 'id'=>'pseud')); ?>
<?php echo $this->Form->hidden('role', array('class'=>'slug')); ?>
<?php echo $this->Form->end(__('Cadastrar')); ?>
</fieldset>
</div>