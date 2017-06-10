<?php $this->layout = 'administrador';  ?>

<div class="assist">
	<?php
		echo $this->element('Manager.dynamicmenu');
	?>
	
</div>
<div class="main">
<?php echo $this->Form->create('Aco', array('class' => 'default')); ?>
<?php  echo $this->Form->input('parent_id', array('label'=>'Nó pai', 'options'=>$parent_id)); 

//pr($parent_id);

?>
<?php  //echo $this->Form->input('model', array('label'=>'Model')); ?>
<?php  //echo $this->Form->input('foreign_key', array('label'=>'Chave estrangeira')); ?>
<?php  echo $this->Form->input('alias', array('label'=>'Nome')); ?>


<?php echo $this->Form->end(__('Cadastrar')); ?>

</div>