
<div class="main">
    <h2>Enviar artigo para revisão do colunista</h2>
    <stong>Titulo do artigo:</strong>	 <?php echo $dataArticle['titulo']; ?><br>
      <?php
        echo '<strong>RESUMO</strong><br>'.$dataArticle['resumo'];
        
    ?>
<?php echo $this->Form->create('Artigo', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Enviar artigo para revisão'); ?></legend>
	<?php echo $this->Form->input('comments', array('label'=>'Observações', 'required'=>true, 'div'=>'required')); ?>
	<br>
<?php echo $this->Form->end(__('Reprovar')); ?>
</fieldset>
</div>
