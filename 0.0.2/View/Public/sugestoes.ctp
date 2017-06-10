<h1><?php echo $title_for_layout; ?></h1>
<?php echo $this->Element('formSuccess');  ?>
<span class="text-content"><?php //echo $content; ?>
<?php //echo $this->Html->image('form.png'); ?>
<?php echo $this->Html->css('Layout.publicLayout/forms.css'); ?>

Prezado <strong>Colaborador</strong>!

A Pavan se tornou uma forte referência no seguimento de material de construção, em Juiz de Fora e região.<br>
Acreditamos que nada disso seria possível sem o ótimo trabalho realizado pelos colaboradores que passaram e que passam por nossa empresa, ao longo de mais de 50 anos de história.<br>
O trabalho em equipe é união e amizade em prol de um bem e de um objetivo comum, por isso é muito mais nobre do que uma batalha individual.<br>
Pensando nisso, resolvemos criar esse canal de comunicação.  <br>
O profissional envolvido na rotina diária possui maior percepção do que precisa ser melhorado e, consequentemente, possui melhores condições de desenvolver idéias que poderão melhorar o desempenho da empresa e gerar resultados que poderão ser compartilhados com todos.<br> 
Envie sua idéia ou crítica através do formulário abaixo.<br>
Pode ser uma idéia para melhorar um processo, uma crítica com relação a algo que o incomode ou mesmo sugestões para melhorar condições de trabalho. <br> 
Desde já, agradecemos a sua colaboração.<br>
Atenciosamente,<br>
Equipe Pavan
</span>
<?php echo $this->Form->create('Sugestao', array('class' => 'default2')); ?>
<?php
    echo $this->Form->input('nome', array('label'=>'Nome do colaborador(campo não obrigatório)', 'type'=>'text'));
   // echo $this->Form->input('tel', array('label'=>'Telefone', 'id'=>'tel', 'class'=>'required'));
    echo $this->Form->hidden('assunto', array('value'=>'Sugestões'));
    $type = array(
        'cri'=>'Crítica',
        'sug'=>'Sugestão'
    );
    echo $this->Form->input('tipo', array('label'=>'Tipo', 'options'=>$type));
   /* $area = array(
        'vendas'=>'Vendas',
        'administrativo'=>'Administrativo',
        'entrega'=>'Entrega',
        'bem-estar-colaborador'=>'Bem-estar do colaborador',
        'outros'=>'Outros'
    );*/
    
    echo $this->Form->input('area_id', array('label'=>'Área', 'options'=>$area));
    echo $this->Form->input('mensagem', array('type' => 'textarea', 'label'=>'Mensagem', 'class'=>'required'));
?>
<?php echo $this->Form->end(__('Enviar', true)); ?>
<span class="obr">**Campos obrigatórios</span>