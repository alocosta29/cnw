<?php echo $this->Html->script('jquery.stringToSlug.js'); ?>
<script>
$(document).ready( function() {
		$("#nome").stringToSlug({
			setEvents: 'keyup keydown blur',
			getPut: '#slug',
			space: '-'
		});
	});
</script>
<div class="assist">
<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>

<div class="main">
    <h2>Cadastro de subcategorias de caderno</h2>
<?php echo $this->Form->create('Categoria', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Criar categoria'); ?></legend>
	<?php echo $this->Form->input('nome', array('id'=>'nome')); ?>
    <?php echo $this->Form->input('alias', array('id'=>'slug', 'readonly'=>'readonly')); ?>
   
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>