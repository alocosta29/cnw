<div class="main">
	<h2>Configurar Aco</h2>
    <?php echo $this->Form->create('AcoSuperuser', array('class' => 'default2')); ?>
    <fieldset>
            <legend>Configurar aco</legend>
            <strong>Plugin: </strong><?php echo $this->data['AcoSuperuser']['plugin']; ?><br>
            <strong>Controller: </strong><?php echo $this->data['AcoSuperuser']['controller']; ?><br>
            <strong>Action: </strong><?php echo $this->data['AcoSuperuser']['action']; ?><br>
            <strong>Descrição: <?php echo $this->data['AcoSuperuser']['descricao']; ?></strong>
            <br><br>
            <?php
            	echo $this->Form->input('aliasMetodo', array('type'=>'text', 'label'=>'Apelido do método(Programador)')); 
            	echo $this->Form->input('descricao', array('label'=>'Descrição')); 
            	$options= array(
            	'N'=>'Não',
            	'Y'=>'Sim'
            	);
            	echo $this->Form->input('module_id', array('label'=>'Módulo', 'options'=>$listModule)); 
            	echo $this->Form->input('parametro', array('label'=>'Este método possui parâmetro', 'options'=>$options));  
            	echo $this->Form->input('restrito', array('label'=>'Restrito para acesso apenas do superusuário?', 'options'=>$options)); 
             ?>
            <?php echo $this->Form->end(__('Salvar')); ?>
    </fieldset>
</div>