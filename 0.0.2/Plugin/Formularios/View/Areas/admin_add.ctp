<?php echo $this->Form->create('Area', array('class'=>'default2')); ?>
    <fieldset>
        <legend><?php echo __('Cadastrar setor da empresa'); ?></legend>
                <?php echo $this->Form->input('area', array('label'=>'Setor')); ?>
                <br>
<?php echo $this->Form->end(__('Salvar')); ?>
</fieldset>