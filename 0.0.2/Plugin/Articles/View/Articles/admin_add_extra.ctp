
<div class="assist">
    <?php echo $this->element('Articles.linksEditArticle'); ?>
</div>  


<?php 
echo $this->Html->css('Layout.main');
echo $this->Html->script(array('Layout.jquery.maxlength', 'Layout.main')); ?>

<div class="main">
    <strong>Título: </strong><?php echo $this->request->data['Artigo']['titulo']; ?>  
    <br>
<?php echo $this->Form->create('Extra', array('class'=>'default2',  'type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Adicionar extra'); ?></legend>
	<?php 
        echo $this->Form->input('nome', array('label'=>'Nome')); 
        echo $this->Form->input('descricao', array('label'=>'Descrição do arquivo')); 
        
        echo $this->Form->input('arquivo', array('label'=>'Arquivo anexo(permitidos: pdf, imagens, word, excel e power point)', 'type'=>'file')); 
               
        
        ?>
	<br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>
