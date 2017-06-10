<div class="assist">
    <?php echo $this->element('Articles.linksEditArticle'); ?>
</div>  
<div class="main">
    <strong>Título: </strong><?php echo $this->request->data['Artigo']['titulo']; ?>  
    <br>
<?php echo $this->Form->create('Artigo', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Palavras-chave'); ?></legend>
	<?php echo $this->Form->input('keywords', array('type'=>'textarea', 'required'=>true, 'label'=>'Insira aqui as palavras chave de seu artigo separando com vírgula ou ponto-e-vírgula')); ?>
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>
