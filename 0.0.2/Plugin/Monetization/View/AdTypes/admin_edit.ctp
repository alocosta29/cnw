<?php echo $this->Html->script('jquery.stringToSlug.js'); ?>
<script>
$(document).ready( function() {
		$("#tipo").stringToSlug({
			setEvents: 'keyup keydown blur',
			getPut: '#alias',
			space: '-'
		});
	});
</script>
<div class="main">
    <h2>Especificação de tipos de anúncios</h2>
<?php echo $this->Form->create('AdType', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Editar especificação de anúncio'); ?></legend>
	<?php 
        echo $this->Form->input('tipo', array('label'=>'Tipo', 'id'=>'tipo'));
        echo $this->Form->input('alias', array('label'=>'Alias', 'id'=>'alias'));
        echo $this->Form->input('max_width', array('label'=>'Largura máxima(px)')); 
        echo $this->Form->input('min_width', array('label'=>'Largura mínima(px)')); 
        echo $this->Form->input('max_height', array('label'=>'Altura máxima(px)')); 
        echo $this->Form->input('min_height', array('label'=>'Altura mínima(px)')); 
        echo $this->Form->input('descricao', array('label'=>'Descrição'));
        ?>
	<br>
<?php echo $this->Form->end(__('Atualizar')); ?>
</fieldset>
</div>

