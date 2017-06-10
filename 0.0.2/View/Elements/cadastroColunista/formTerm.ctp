<?php echo $this->Html->css('PublicLayout.forms'); ?>
<?php 
    echo $this->Form->create('Cadastro', array('class' => 'default2', 'style'=>'width: 100%; ')); 
    echo "<fieldset>";
    
   echo "<legend>Termo de utilização do portal</legend>";
    echo '<div style="overflow-y: auto; max-height: 300px; border-radius: 1px; width: 100%; padding-left: 5px; padding-right: 5px; margin-top: 10px; ; margin-bottom: 10px; ">'.$term['texto'].'</div>';
    echo "<br>";
    
    
    
    
    echo $this->Form->input('aceite_termo', array(
    'options' => array(
                        'Y'=> 'SIM, EU, <strong>'.mb_strtoupper($dataCadastro['nome'], 'UTF8').'</strong>, CONCORDO COM OS TERMOS DE UTILIZAÇÃO DO PORTAL',
                        'N' => 'NÃO, EU, <strong>'.mb_strtoupper($dataCadastro['nome'], 'UTF8').'</strong>, NÃO CONCORDO COM OS TERMOS DE UTILIZAÇÃO DO PORTAL E GOSTARIA DE CANCELAR ESTA SOLICITAÇÃO',
                      ), 
    'type' => 'radio',
    'legend'=>false,
    'default'=>'Y'    
                                                )
            );
    
 /*   echo $this->Form->input('aceite_termo', array('type' => 'checkbox',
     'label'=>'SIM, EU, <strong>'.mb_strtoupper($dataCadastro['nome'], 'UTF8').'</strong>, CONCORDO COM OS TERMOS DE UTILIZAÇÃO DO PORTAL'));
    */
    
   echo $this->Form->end(__('Salvar'));  
    
echo "</fieldset>";
    
     
?>
