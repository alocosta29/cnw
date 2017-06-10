<div class="assist2">
     <?php echo '<br>'.$this->Element('Articles.linksEditPerfil'); ?>  
</div>    

<div class="telatoda">
 
    <h2>Personalização do perfil de colunista</h2>
    <?php 
echo $this->Html->css('Layout.main');
echo $this->Html->script(array('Layout.jquery.maxlength', 'Layout.main')); ?>
<?php echo $this->Cms->getCms('bio'); ?>
<?php echo $this->Form->create('Colunista', array('class'=>'default2', 'style' => 'width: 1000px; ')); ?>
	<fieldset>
		<legend><?php echo __('Editar apresentação pessoal'); ?></legend>
	<?php echo $this->Form->input('apelido'); ?>
    <?php echo $this->Form->input('resumo', array('label'=>'Resumo', 'maxlength'=>250, 'id'=>'max')); ?>
    <?php echo $this->Form->input('bio', array('label' => 'Bio', 'id' => 'bio', 'class'=>'ckeditor', 'type' => 'textarea')); ?>
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>
