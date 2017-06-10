<?php echo $this->Cms->getCms('texto'); ?>
<?php echo $this->Html->script('jquery.stringToSlug.js'); ?>
<script>
$(document).ready( function() {
		$("#titulo").stringToSlug({
			setEvents: 'keyup keydown blur',
			getPut: '#slug',
			space: '-'
		});
	});
</script>

<div class="telatoda" style = "width: 1300px; ">
    <h2>Criar artigo</h2>
<?php echo $this->Form->create('Artigo', array('class' => 'default2', 'style'=>'width: 1000px;')); ?>
		<table class="scroll" cellpadding="5px" width="100%">
		<tr>
		<td style="width: 80%; ">		
	<?php echo $this->Form->input('titulo', array('id'=>'titulo'));
		
		echo $this->Form->input('alias', array('id'=>'slug'));
		echo $this->Form->input('texto', array('label'=>'Texto', 'id'=>'texto', 'class'=>'ckeditor', 'type'=>'textarea'));
	   echo $this->Form->input('data_publicacao', array( 'label' => 'Data de publicação',
	                        'dateFormat' => 'D/M/Y H:i',
                            'timeFormat' => '24',
	                        'minYear' => date('Y') - 0,
	                        'maxYear' => date('Y') + 1 )); 
        
        
               // echo $this->Form->input('resumo', array('label'=>'resumo', 'type'=> 'textarea'));
	?>
	</td>
	<td style="vertical-align: top; " style="width: 20%; ">
		<?php
		/*$options1 = array(
		'N' =>'Não',
		'Y' => 'Sim'
		);
		echo $this->Form->input('publish', array('options'=>$options1, 'label'=>'Publicar'));	*/
	
	echo "<br>";
	
		/*$options = array(
		1 => 'Sim',
		0 =>'Não'
		);
		echo $this->Form->input('comment_status', array('options'=>$options, 'label'=>'Permitir comentários?'));
		
		echo "<br>";
		echo $this->Form->input('Taxonomia.0.taxonomia_id', array('options'=>$categorias, 'label'=>'Categorias', 'multiple'=>'multiple'));
		echo "<br>";
		echo $this->Form->input('Taxonomia.1.taxonomia_id', array('options'=>$tags, 'label'=>'Tags', 'multiple'=>'multiple'));*/
        
         echo $this->Form->select('ArtigosCategoria.categoria_id', 
		$listCategories, array('multiple' => 'checkbox', 'value'=>false)); 
        
        
	?>
<?php echo $this->Form->end(__('Salvar')); ?>
</td>
</tr>
</table>
</div>