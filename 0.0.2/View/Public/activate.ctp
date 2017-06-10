<h1>Criar conta de acesso</h1>
<?php if($this->Session->read('Message.flash.message')): ?>
		<div style="width: 100%; float: left; height: auto; margin-left: 0px; clear:both;">
			<?php
			if($this->Session->read('Message.flash.params.class') == 'success'){
				$styleCss = '"font-size: 20px; font-weight: bold; color:  #006400; "';
			}elseif($this->Session->read('Message.flash.params.class') == 'error'){
			    $styleCss = '"font-size: 20px; font-weight: bold; color:  #FF0000; "';
			}
			$message = '<div style='.$styleCss.'>'.$this->Session->read('Message.flash.message').'</div>';
			UNSET($_SESSION['Message']['flash']['message']);
			echo $message; ?>
		</div>
<?php endif; ?>
    <?php
if(!$permission)
{
    echo '<span style="font-size: 20px; font-weight: bold; color:  #FF0000;">'.$msgError.'</span>';
}else{
    if($stageActivate == "A")
    {
      
        echo $this->Element('cadastroColunista/formTerm');
        
    }elseif($stageActivate == "I"){
        echo $this->Element('cadastroColunista/formData');
        
        
    }
    
}



?>