<?php
echo $this->Html->script(array('jquery-1.8.3', 'Manager.ui/jquery-ui10', 'Manager.ui/modal2'));?>
<?php echo $this->Html->css(array('Manager.jquery-ui', 'Manager.estiloManager', 'estilo1Preto/formularios'));?>
<?php echo $this->Html->script(array('Manager.mask2', 'Manager.jquery.validate')); ?>

  <script>
	  $(function() {
	    $( "#accordion" ).accordion({
	      collapsible: true
	    });
	  });
  </script>
  
    
    <div class="caixa_sanfona">
    <?php echo __('FILTROS DE CONSULTA:'); ?>
    
    <section>	
	<div id="accordion">
		<h3><a href="#"><center>CONSULTAR PERFIL</center></a></h3>
			<div>
				<?php
				echo $this->Form->create('Person', array('class' => 'default'));
				echo $this->Form->input('cpf', array('label' => 'CPF:', 'id'=>'cpf'));
				echo $this->Form->input('nome', array('label' => 'Nome:', 'id'=>'nome'));
				echo $this->Form->hidden('pessoa', array('value' => 'F'));
				echo $this->Form->end(__('Filtrar'));
				?>
			</div>

		<!-- 
		<h3><a href="#"><center>PESSOA JURÍDICA</center></a></h3>
			<div>
				<?php
				/*echo $this->Form->create('Person', array('class' => 'default'));
				echo $this->Form->input('cnpj', array('label' => 'CNPJ:', 'id'=>'cnpj'));
				echo $this->Form->input('r_social', array('label' => 'Razão social:'));
				echo $this->Form->input('fantasia', array('label' => 'Nome fantasia:'));
				echo $this->Form->hidden('pessoa', array('value' => 'J'));
				echo $this->Form->end(__('Filtrar'));*/
				?>
			</div>	
			-->
	</div>
	</section>

	<script>
		jQuery(function($){
			 $("#dataj").mask("99/99/9999");
		     $("#dataij").mask("99/99/9999");
		     $("#data").mask("99/99/9999");
		     $("#datai").mask("99/99/9999");
		     $("#cnpj").mask("99.999.999/9999-99");
		     $("#tel").mask("(99)9999-9999");
		     $("#cpf").mask("999.999.999-99");
			});
	</script>
	
</div>