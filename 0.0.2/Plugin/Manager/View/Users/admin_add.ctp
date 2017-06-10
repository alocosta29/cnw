<div class="main">
<?php 
if(isset($person[0]['Person']['tipo_pessoa'])):
	echo $this->Form->create('User', array('class'=>'default2'));?>

        <fieldset><br>
        <?php if($person[0]['Person']['tipo_pessoa'] == 'F'){ ?>	
	        <strong>Nome: </strong><?php echo $person[0]['Individual'][0]['nome']; ?>	
	      	<br><br>
      	<?php }else{ ?>
	      	<strong>Razão Social: </strong><?php echo $person[0]['Companie'][0]['r_social']; ?>	
	      	<br><br>	
      	<?php } ?>
      	
        <legend>Criar login e senha de usuário</legend>
        <?php
      
        echo $this->Form->input('username', array('label'=>'Login'));
        echo $this->Form->input('password', array('label'=>'Senha')); 
		echo $this->Form->hidden('person_id', array('value'=>$person[0]['Person']['id'], 'type'=>'text')); 
		echo $this->Form->input('confirm_password', array('type' => 'password', 'label'=>'Confirmar senha')); 
		
		?>
		<br>
   		<?php echo $this->Form->end('Cadastrar');?>
       	</fieldset>
<?php
else:
?>	
	<h2> Nenhuma pessoa localizada para poder abrir o cadastro de usuario.</h2>
<?php	
endif	
?>     
</div>