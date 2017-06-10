<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
    <title>
        <?php echo __('.: SGP - Sistema de Gestão de Pessoas :.'); ?>
    </title>
    
    <?php
    echo $this->Html->meta('Layout.sgpLayout/favicon.png');
    
    ?>

<?php 
echo $this->Html->script(array('Layout.layoutFlat/menumhjscss', 'Layout.layoutFlat/jquery-1.8.3', 'Layout.layoutFlat/superfish'));
echo $this->Html->css('Layout.layoutFlat/estiloScreen'); ?>
    
</head>

	<body>
		<div id="container">
			<div id="header">
				<?php  
				echo $this->Element('Manager.menuSuperior');  	
				$usuarioId = AuthComponent::user('id');
				$usuarioNome = AuthComponent::user('Individual.nome');
                $usuarioLogin = ucfirst(AuthComponent::user('username'));#primeira letra Maiuscula
				if(isset($usuarioId))
				{ ?>
                     
                    
                    
             <span class='usuario' style = "background-image:url('img/iconeUserLogado.png'); "><?php echo $usuarioNome; ?>  </span>
				<span class = "buttonsRight"><img src="img/iconFErramentas.png"></span>   
                    
			<?php	}else{ 	
				    ?>
					<!-- <form name="login" method="post" action="#" class="login">  -->
					<?php 
					   echo $this->Form->create('Manager.User', array('class'=>'login', 'name'=>'login'));
					   echo $this->Form->input('username', array('class'=>'campos', 'size'=>'15', 'tabindex'=>'1', 'div'=>false, 'label'=>'Usuário'));
                       echo $this->Form->input('password', array('class'=>'campos', 'size'=>'15', 'type'=>'password', 'tabindex'=>'2', 'div'=>false, 'label'=>'Senha'));
					   echo $this->Form->submit('Ok', array('class'=>'botao', 'tabindex'=>'3', 'div'=>false)); 
					   echo $this->Form->end();
					?>
				<?php
				}
				?>
					
				
			</div>
			
			<div id="content">
				<div class = "assistEsquerda"><?php //echo $this->element('Layout.dynamicUpperMenu'); ?></div>
				<div class = "main">
                <?php 
				//echo $this->Element('Installation.linkInstall');
				echo $this->Element('Manager.screenLoading');
				if(!isset($usuarioId))
				{
					echo "<div class='capa'>".$this->Html->image('Layout.sgpLayout/capa.png')."</div>";
				}
                    echo $this->element('Manager.sessionFlashMessage');
                    echo $content_for_layout; 
                    
				 ?>
				<div id='clear'></div>
                
                
                </div>
			</div>
			
			<div id="footer">	
				
			</div>
		</div>
	</body>
</html>

