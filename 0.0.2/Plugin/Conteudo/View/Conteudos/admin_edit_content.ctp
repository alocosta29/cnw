<?php echo $this->Cms->getCms('texto'); ?>
<div class="telatoda" style = "width: 950px; margin-left: 10px; ">
    <h2>Editar conteúdo de sessão</h2>
    Sessão: <strong><?php echo $categoria; ?></strong>
        
    
     <?php echo $this->Form->create('Postagen', array('class' => 'default2')); ?>
        <fieldset>
            <legend>Edição da descrição institucional</legend>
        <?php
            echo $this->Form->input('titulo', array('label'=>'Título', 'type'=>'text'));
            echo $this->Form->input('resumo', array('label'=>'Resumo'));
            echo "<br>
            <label><strong><span style='font-size: 13px; '>Conteúdo</span><span style='color: #e32;'>*</span></strong></label>
            ";
            echo $this->Form->textarea('texto', array('id'=>'texto','class'=>'ckeditor'));
            echo $this->Form->end(__('Atualizar'));
        ?>
        </fieldset>
    
    
    
    
</div>
