<div class="main">
<?php echo $this->Form->create('Caderno', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Editar caderno'); ?></legend>
	<?php echo $this->Form->input('nome'); ?>
        <?php echo $this->Form->input('alias'); ?>
        <?php echo $this->Form->input('descricao', array('label'=>'Descrição')); ?>
        <?php echo $this->Form->input('cor', array('type'=>'color')); ?>
        <?php echo $this->Form->input('url_form', array('label'=>'Url do formulário')); ?>
        <?php echo $this->Form->input('url_post_form', array('label'=>'Url de envio dos dados do formulário')); ?>
	<br>
<?php echo $this->Form->end(__('Atualizar')); ?>
</fieldset>
</div>