<?php 
echo $this->Html->css('Manager.calendario_ui/jquery_data'); 
echo $this->Html->script(array('Manager.calendario_ui/jquery-ui.js'));
echo $this->Html->script(array('Manager.mask2', 'Manager.jquery.validate'));
?>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy',
    showOn: "button"   
    });
  });
  </script>
<div class="main">
<?php echo $this->Form->create('Holiday', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Atualizar feriado'); ?></legend>
	<?php
	echo $this->Form->input('id');
		echo $this->Form->input('data', array('type'=>'text', 
		'id'=>'datepicker', 'style'=>'width: 150px; '));
		echo $this->Form->input('descricao');
	?>

<?php echo $this->Form->end(__('Salvar')); ?>
	</fieldset>
	
			<script>
		jQuery(function($)
		{
			$("#datepicker").mask("99/99/9999");
		});
	</script>
</div>
