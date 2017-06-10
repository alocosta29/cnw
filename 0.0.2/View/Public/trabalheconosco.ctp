<h1><?php echo $title_for_layout; ?></h1>
<?php echo $this->Element('formSuccess');   ?>
<span class="text-content"><?php //echo $content; ?>
<?php //echo $this->Html->image('form.png'); ?>
<?php echo $this->Html->css('Layout.publicLayout/forms.css'); ?>
<?php echo $this->Html->script(array('Layout.pavan/jquery.mask')); ?>
<span class="text-content">
<br><strong>Seja Bem-Vindo(a)!</strong><br><br>
Agradecemos a sua visita e o seu interesse em fazer parte do quadro de colaboradores de nossa empresa.<br>
Selecionamos os participantes dos processos seletivos também pelos currículos enviados pelo site. <br>Ressaltamos, por isso, a importância de enviar o currículo com todos os seus dados atualizados.
<br>
Se você se identificou com a nossa missão e com os nossos valores e deseja trabalhar conosco, envie seu currículo através do formulário abaixo.
<br><br>
Sucesso e Boa Sorte!!
</span>
<br><br>
<?php echo $this->Form->create('Rh', array('class' => 'default2', 'type'=>'file')); ?>
<?php
    
    echo $this->Form->input('nome', array('label'=>'Nome completo', 'class'=>'required', 'type'=>'text'));
   //echo $this->Form->input('tel', array('label'=>'Telefone', 'id'=>'tel', 'class'=>'required'));
    echo $this->Form->hidden('assunto', array('value'=>'Envio de currículo pelo site'));
    echo $this->Form->input('email', array('label'=>'E-mail', 'class'=>'required'));
    echo $this->Form->input('telefone', array('label'=>'Telefone', 'class'=>'required', 'id'=>'txttelefone', 'pattern'=>"\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}"));

    echo $this->Form->input('area_id', array('label'=>'Área pretendida', 'options'=>$listSectors)); 
    echo $this->Form->input('arquivo_anexo', array('label'=>'Anexar currículo', 'type'=>'file')); 
    echo $this->Form->input('mensagem', array('type' => 'textarea', 'label'=>'Mensagem'));
?>
<?php echo $this->Form->end(__('Enviar', true)); ?>
<span class="obr">**Campos obrigatórios</span>
<script type="text/javascript">$("#txttelefone").mask("(00) 0000-00009");</script>