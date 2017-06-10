<?php echo $this->Form->create('Area', array('class'=>'default2')); ?>
    <fieldset>
        <legend><?php echo __('Editar setor'); ?></legend>
    <?php
        echo $this->Form->input('area');
    ?>
    <br>
<?php echo $this->Form->end(__('Atualizar')); ?>
</fieldset>