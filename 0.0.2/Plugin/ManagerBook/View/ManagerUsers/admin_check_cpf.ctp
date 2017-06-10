<div class="assist">
	<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>

<?php echo $this->Html->script(array('Manager.jquery-1.8.3')); ?>

<div class="main">
    <h2><?php echo $this->ReturnData->getBook($caderno).':';   ?>Verificar base de dados </h2>	
    <?php 
echo $this->Html->script(array('Manager.mask2'));
?> 
<?php echo $this->Form->create('Individual', array('class'=>'default2')); ?>

	<?php echo $this->Form->input('cpf', array('label'=>'CPF', 'id'=>'cpf')); ?>
	<br>
<?php echo $this->Form->end(__('Avançar')); ?>
    
    <script>
		jQuery(function($)
		{
		    $("#cpf").mask("999.999.999-99");
		});
	</script>
</div>
