<?php echo $this->Html->script(array('Layout.sgpLayout/jquery.mask')); ?>
<?php echo $this->Html->css('PublicLayout.forms'); ?>
<?php 
    echo $this->Form->create('Person', array('class' => 'default2')); 
    echo $this->Form->input('Individual.0.nome', array('label' => 'Nome completo', 'class' => 'required', 'type' => 'text', 'value' => $dataCadastro['nome']));
    echo $this->Form->input('Individual.0.cpf', array('label' => 'CPF', 'id' => 'cpf'));
    echo $this->Form->input('User.0.username', array('label' => 'Email de login', 'value' => $dataCadastro['email'], 'readonly'=>'readonly'));
    echo $this->Form->input('User.0.password', array('label' => 'Senha', 'type'=>'password'));
    echo $this->Form->input('User.0.confirmPassword', array('label'=>'Repetir senha', 'type'=>'password'));
    echo $this->Form->end(__('Enviar')); 
?>
<script>
    jQuery(function($)
    {
        $("#cpf").mask("999.999.999-99");
    });
</script>