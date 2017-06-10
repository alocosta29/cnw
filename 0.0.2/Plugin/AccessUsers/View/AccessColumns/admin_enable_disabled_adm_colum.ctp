<div class="main">
    <h2>Permissão de moderador</h2>
    
    
    <?php echo $this->Form->create('AccessUser', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Confiuração de permissões'); ?></legend>
	<?php echo $this->Form->input('enabled', array('type'=>'checkbox', 'label'=>'Permissão do módulo de moderação', 'default'=>$authorizedPackage)); ?>
	<br>
    
    
    
    <?php 

    echo $this->Form->select('AccessCaderno.caderno_id', 
		$list, array('multiple' => 'checkbox', 'value'=>$checkCadernos)); ?>
    
    
    <?php echo $this->Form->end(__('Salvar')); ?>
    </fieldset>
    
    
    
    
    
    
</div>
