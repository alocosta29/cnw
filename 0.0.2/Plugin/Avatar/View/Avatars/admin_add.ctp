<div class="assist">
	 <?php echo '<br>'.$this->element('Articles.linksEditPerfil'); ?>    
</div>
<div class="main">
    <h2>Enviar/alterar avatar</h2>
		
<?php echo $this->Form->create('Avatar', array('class'=>'default2', 'type'=>'file'));?>
	<fieldset>
		<legend><?php echo __('Selecione um arquivo de imagem em seu computador e pressione Enviar(altura: entre 400 e 900px; largura: entre 400 e 900px;)'); ?></legend>
	<?php
		echo $this->Form->input('avatar', array('type'=>'file', 'label'=>false));
	?>
	
	<?php //echo $this->Html->image('imagem.jpg', array('id'=>'jcrop')); ?>
<?php echo $this->Form->end(__('Enviar'));?>
</fieldset>
<?php
	$voltar = $this->Html->image('voltar2.png', array('title'=>'Voltar'));
	?>

</div>
