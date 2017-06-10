        <h1><?php echo $title_for_layout; ?></h1>
        <?php  echo $this->Element('formSuccess'); ?>
        
        <span class="text-content">
           <?php echo $this->Html->script(array('Layout.sgpLayout/jquery.mask')); ?>
            <?php echo $this->Html->css('PublicLayout.forms'); ?>
            Perguntas críticas, comentários, sugestões? Entre em contato conosco!<br>
            Preencha o formulário abaixo e nos envie. Estaremos sempre prontos para lhe atender!
        </span>

        <?php 
            echo $this->Form->create('Contato', array('class' => 'default2')); 
            echo $this->Form->input('nome', array('label'=>'Nome completo', 'class'=>'required', 'type'=>'text'));
            //echo $this->Form->input('tel', array('label'=>'Telefone', 'id'=>'tel', 'class'=>'required'));
            echo $this->Form->hidden('assunto', array('value'=>'Formulario de contato do site'));
            echo $this->Form->input('email', array('label'=>'E-mail', 'class'=>'required'));
            echo $this->Form->input('tel', array('label'=>'Telefone', 'class'=>'required', 'id'=>'txttelefone'));
            echo $this->Form->input('mensagem', array('type' => 'textarea', 'label'=>'Mensagem', 'class'=>'required'));
            echo $this->Recaptcha->show(array(
            		'theme' => 'clean',
            		'lang' => 'pt',
            ));
            echo $this->Recaptcha->error();
            echo $this->Form->end(__('Enviar', true)); 
        ?>
        <span class="obr">**Campos obrigatórios</span>
        <script type="text/javascript">
         jQuery(function($)
		 {
            $("#txttelefone").mask("(00) 0000-00009");
         });      
        </script>