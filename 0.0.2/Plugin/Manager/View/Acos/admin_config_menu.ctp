
<div class="main">
	
<?php echo $this->Form->create('AcoAdmin', array('class' => 'default2')); ?>
<fieldset>
<legend>Configurar item de menu</legend>
<strong>Módulo: </strong><?php echo $this->FormatManager->_returnModule($this->data['AcoAdmin']['module_id']); ?><br>
<strong>Função: </strong><?php echo $this->data['AcoAdmin']['aliasMetodo']; ?><br>

<strong>Descrição: <?php echo $this->data['AcoAdmin']['descricao']; ?></strong>
<br><br>

<?php  

echo $this->Form->input('menugroup_id', array('label'=>'Grupo no menu', 'options'=>$listmenu, 'default'=>$this->data['AcoAdmin']['menugroup_id'])); 
echo $this->Form->input('ordem_menu', array('label'=>'Ordem no menu', 'default'=>$this->data['AcoAdmin']['ordem_menu'])); 

echo $this->Form->input('aliasMenu', array('type'=>'text', 'label'=>'Nome da funcionalidade')); 
$options= array(
'N'=>'Não',
'Y'=>'Sim'
);
if($this->data['AcoAdmin']['parametro'] == 'N'){
echo $this->Form->input('menuEsquerdo', array('label'=>'Exibir no menu a esquerda?', 'options'=>$options)); 
echo $this->Form->input('menuSuperior', array('label'=>'Exibir no menu superior?', 'options'=>$options));
}
 ?>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>
</div>