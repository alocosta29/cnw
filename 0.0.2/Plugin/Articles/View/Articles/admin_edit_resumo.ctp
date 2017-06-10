<div class="assist">
    <?php echo $this->element('Articles.linksEditArticle'); ?>
</div>  


<?php 
echo $this->Html->css('main');
echo $this->Html->script(array('jquery.maxlength', 'main')); ?>

<div class="main">
    <strong>Título: </strong><?php echo $this->request->data['Artigo']['titulo']; ?>  
    <br>
<?php echo $this->Form->create('Artigo', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Edição do resumo'); ?></legend>
	<?php echo $this->Form->input('resumo', array('type'=>'textarea', 'required'=>true, 'maxlength'=>160, 'id'=>'max')); ?>
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>
