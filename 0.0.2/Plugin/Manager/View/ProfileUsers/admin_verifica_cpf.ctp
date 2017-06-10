<div class="main">

	<?php 
		echo $this->Html->script(array('Manager.mask2'));
		echo $this->Form->create('Person', array('class' => 'default2')); ?>
		<fieldset>
		<legend>Por favor, informe o CPF do usuário que será cadastrado</legend>
		
		
		<?php echo $this->Form->input('cpf', array('label' => 'CPF:', 'id'=>'cpf'));?>

    	<?php echo $this->Form->end(__('Avançar'));	?>
    	</fieldset>
 
	<script>
		jQuery(function($){
		     $("#cpf").mask("999.999.999-99");
	
			});
	</script>
<br>
<br>
</div>	