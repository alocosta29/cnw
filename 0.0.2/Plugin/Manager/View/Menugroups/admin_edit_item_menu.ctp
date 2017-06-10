<div class="main">
<h2>Editar item de menu</h2>
<?php echo $this->Form->create('Aco', array('class'=>'default2')); ?>
<fieldset>
<legend><strong><?php echo $this->FormatManager->_returnModule($this->data['Aco']['module_id']); ?>: Função </strong><?php echo $this->data['Aco']['aliasMetodo']; ?></legend>
<?php
	if($this->data['Aco']['parametro'] == 'Y'):
		echo '<strong><span style="color: red; ">Esta função possui parâmetro. Portanto, não é possível encontrá-la no menu</span></strong>'; 
	endif;
	echo $this->Form->input('aliasMenu', array('label'=>'Nome da função no menu'));
	echo $this->Form->input('descricao', array('label'=>'Descrição da função'));
	$listOptions = array(
							'Y'=>'Sim',
							'N'=>'Não'
						);
	if($this->data['Aco']['parametro'] == 'N'):
		echo $this->Form->input('menugroup_id', array('label'=>'Grupo no menu', 'options'=>$listmenu, 'empty'=>'Sem grupo'));
		echo $this->Form->input('menuEsquerdo', array('label'=>'Exibir no menu esquerdo?', 'options'=>$listOptions));
		echo $this->Form->input('menuSuperior', array('label'=>'Exibir no menu superior?', 'options'=>$listOptions));
		echo $this->Form->input('ordem_menu', array('label'=>'Ordem de exibição no menu'));
	endif; ?>
	<br>
	<?php echo $this->Form->end(__('Atualizar')); ?>
</div>