<div class="assist">

</div>
<div class="main">
    <h2>Reverter aprovação de artigo</h2>
    <stong>Titulo do artigo:</strong>	 <?php echo $dataArticle['titulo']; ?><br>
      <?php
        echo '<strong>RESUMO</strong><br>'.$dataArticle['resumo'];
        
    ?>
<?php echo $this->Form->create('Artigo', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Reverter aprovação de artigo'); ?></legend>
	<?php echo $this->Form->input('comments', array('label'=>'Observações', 'required'=>true)); ?>
	<br>
<?php echo $this->Form->end(__('Enviar para revisão')); ?>
</fieldset>
</div>

