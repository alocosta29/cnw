<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $this->Html->charset(); ?>
		<title><?php echo __('.: CNW - Crescer na Web :.'); ?></title>
		<?php
			echo $this->Html->meta('AdmLayout.sgpLayout/favicon.png');
			echo $this->Html->css('AdmLayout.sgpLayout/estiloScreen');
			echo $this->Html->script(array('jquery-3.2.0.min', 'Manager.menumhjscss'));
			echo $scripts_for_layout;
			$url_corrigida = HOST_REAL.'webroot/js/';
		?>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<?php  
				echo $this->Element('AdmLayout.menuSuperior');  	
				$usuarioId = AuthComponent::user('id');
				$usuarioNome = AuthComponent::user('username');
                // $usuarioLogin = $this->Complement->linkCol($this->Session->read('Auth.User.Individual.nome'));#primeira letra Maiuscula
				$usuarioLogin = $this->Complement->getSimpleName($this->Session->read('Auth.User.Individual.nome'));                              
                if(isset($usuarioId))
				{
                        echo "<a title='Alterar minha senha!' class='usuario' href='".$this->Html->url("/admin/manager/users/trocarsenha")."'>
                            <span>Seja bem vindo </span> $usuarioLogin </a>
                        ";	
				}else{ 
					    echo $this->Form->create('Manager.User', array('class'=>'login', 'name'=>'login'));
					    echo $this->Form->input('username', array('class'=>'campos', 'size'=>'15', 'tabindex'=>'1', 'div'=>false, 'label'=>'Usuário'));
                        echo $this->Form->input('password', array('class'=>'campos', 'size'=>'15', 'type'=>'password', 'tabindex'=>'2', 'div'=>false, 'label'=>'Senha'));
					    echo $this->Form->submit('Ok', array('class'=>'botao', 'tabindex'=>'3', 'div'=>false)); 
					    echo $this->Form->end();
				}
				?>
			</div>
			<div id="content">
				<?php 
                echo $this->Element('titulo_caderno');
				echo $this->Element('Manager.screenLoading');
				if(!isset($usuarioId) and $so == 'CN=lubuntu')
				{
					echo "<div class='capa'>".$this->Html->image('Layout2.sgpLayout/capa.png')."</div>";
				}
                    echo $this->element('Manager.sessionFlashMessage');
                    echo $content_for_layout; 
                    
				 ?>
				<div id='clear'></div>
			</div>
			<div id="footer" style="left: 0px; right:0px; bottom: 0px; ">
				<?php /*echo $this->Html->link(
						$this->Html->image('Manager.logo.png', array('alt' => __('Virtual Telecom: tecnologia e liberdade.'), 'border' => '0')),
						'http://www.virtualtelecom.com.br/',
						array('target' => '_blank', 'escape' => false)
					);*/
				?>
			</div>
		</div>
		<?php //echo $this->element('sql_dump'); ?>

    <!-- scripts_for_layout -->
    <?php echo $scripts_for_layout; ?>
    <!-- Js writeBuffer -->
    <?php //if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer(); ?>
	</body>
</html>
<?php //echo $this->element('Manager.sessionFlashModal'); ?>