<?php echo $this->Html->script(array('Manager.mask2', 'Manager.jquery.validate')); ?>
<?php echo $this->Form->create('Person', array('class' => 'default')); ?>
	<table border = '0' width="800px" style="background-color: #d5d5d5" cellpadding="5px">
    <tr>
    	<td><?php echo $this->Form->input('cpf', array('label' => 'CPF:', 'id'=>'cpf')); ?></td>
    	<td><?php echo $this->Form->input('nome', array('label' => 'Nome:', 'id'=>'nome')); ?></td>
    	<td><?php echo $this->Form->input('username', array('label' => 'Login', 'id'=>'login')); ?></td>
    	<td><?php
				$status = array(
				'S' => 'Selecione',
				0  => 'Inativo',
				1  => 'Ativo'
				);
				echo $this->Form->input('status', array('label' => 'Status:', 'id'=>'status', 'options'=>$status, 'default'=>'S'));
    	 	?>
    	</td>
    	<td><?php echo $this->Form->end(__('Filtrar')); ?> </td>
    	
	</tr>
</table>

	<script>
		jQuery(function($){
			 $("#dataj").mask("99/99/9999");
		     $("#dataij").mask("99/99/9999");
		     $("#data").mask("99/99/9999");
		     $("#datai").mask("99/99/9999");
		     $("#cnpj").mask("99.999.999/9999-99");
		     $("#tel").mask("(99)9999-9999");
		     $("#cpf").mask("999.999.999-99");
			});
	</script>
<br>