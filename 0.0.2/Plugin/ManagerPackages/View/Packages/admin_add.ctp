<?php echo $this->Html->script('jquery.stringToSlug.js');  ?>
<script>
$(document).ready( function() {
		$("#nome").stringToSlug({
			setEvents: 'keyup keydown blur',
			getPut: '#alias',
			space: '-'
		});
	});
</script>
<div class="main">
<?php echo $this->Form->create('Package', array('class' => 'default2')); ?>
	<fieldset>
		<legend><?php echo __('Adicionar pacote'); ?></legend>
	<?php
		echo $this->Form->input('nome', array('id'=>'nome'));
		echo $this->Form->input('alias', array('id'=>'alias', 'readonly'=>'readonly'));
		echo $this->Form->input('plugin');
		echo $this->Form->input('descricao', array('label'=>'Descrição'));
		echo $this->Form->end(__('Salvar'));
	?>
	</fieldset>
</div>