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
<div class="assist2" >
    <?php echo $this->element('Articles.linksEditArticle'); ?>
</div>   

<div class="telatoda" style = "width: 950px; margin-left: 10px; ">
    <h2>Edição de artigo</h2>
<?php echo $this->Form->create('Artigo', array('class' => 'default2', 'style'=>'width: 1000px;')); ?>
		<table class="scroll" cellpadding="5px" width="100%">
		<tr>
		<td style="width: 80%; ">		
	<?php echo $this->Form->input('titulo', array('id'=>'titulo'));
		
		echo $this->Form->input('alias', array('id'=>'slug'));
		echo $this->Form->input('texto', array('label'=>'Texto', 'id'=>'texto', 'class'=>'ckeditor', 'type'=>'textarea'));
        echo $this->Form->input(
                                    'data_publicacao', array( 'label' => 'Data de publicação',
                                    'dateFormat' => 'D/M/Y H:i',
                                    'timeFormat' => '24',
                                    'minYear' => date('Y') - 0,
                                    'maxYear' => date('Y') + 1 )
                                ); 
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
		echo $this->Form->input('comment_status', array('options'=>$options, 'label'=>'Permitir comentários?'))
		echo "<br>";
		echo $this->Form->input('Taxonomia.0.taxonomia_id', array('options'=>$categorias, 'label'=>'Categorias', 'multiple'=>'multiple'));
		echo "<br>";
		echo $this->Form->input('Taxonomia.1.taxonomia_id', array('options'=>$tags, 'label'=>'Tags', 'multiple'=>'multiple'));*/
        
        echo $this->Form->select('ArtigosCategoria.categoria_id', 
		$listCategories, array('multiple' => 'checkbox', 'value'=>$postCategories)); 
        
        echo '<fieldset><legend>Imagem destacada</legend>'; 
        echo $this->Article->featuredImagePost(array('user_id'=>$post['user_id'], 'img'=>$post['imagem'], 'caderno'=>$caderno, 'idPost'=>$post['id']));
        
        echo '</fieldset>';
	?>
<?php echo $this->Form->end(__('Atualizar')); ?>
</td>
</tr>
</table>
</div>