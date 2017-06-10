<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo __('SGP::Sistema de Gestão de Pessoal'); ?>
		</title>
		<?php
			echo $this->Html->meta('Manager.favicon.png');
			echo $this->Html->css('Manager.estilo1Preto/estiloScreen');
			echo $this->Html->script(array('Manager.menumhjscss', 'Manager.jquery-1.8.3'));
			echo $scripts_for_layout;
			$url_corrigida = HOST_REAL.'webroot/js/';
		?>
		<script>
			//Variável de ambiente de suporte para o editor de conteudo
			var VARS_AMBIENTE = new Array();
			VARS_AMBIENTE['caminho_servidor'] = "<?php echo $url_corrigida; ?>";
		</script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<?php  echo $this->Element('Manager.menuSuperior');  ?>
				
				<?php	
				$usuarioId = AuthComponent::user('id');
				$usuarioNome = AuthComponent::user('username');
                $usuarioLogin = ucfirst(AuthComponent::user('username'));#primeira letra Maiuscula
				if(isset($usuarioId))
				{
					echo "
                    	<a title='Alterar minha senha!' class='usuario' href='".$this->Html->url("/admin/manager/users/trocarsenha")."'>
                    	<span>Logado como</span> $usuarioLogin </a>
                    ";	
				}
				else
				{
				?>
					<!-- <form name="login" method="post" action="#" class="login">  -->
					<?php echo $this->Form->create('Manager.User', array('name' => 'login', 'class' => 'login'));?>
						<label>Usuário: 
							<input name="data[User][username]" type="text" tabindex="1" size="15" class="campos" /> 
						</label>
						<label>Senha: 
							<input name="data[User][password]" type="password" tabindex="2" size="15" class="campos"/> 
							<input type="submit" name="Submit" value="OK" tabindex="3" class="botao" />
						</label> 
					</form>
				<?php
				}
				?>
			</div>
			<div id="content">
				<?php 
				//echo $this->Element('Installation.linkInstall');
				echo $this->Element('Manager.screenLoading');
				if(!isset($usuarioId))
				{
					echo $this->element('Manager.sessionFlashMessage');
					echo "<div class='capa'>".$this->Html->image('capa.png')."</div>";
				}else{
					echo $this->element('Manager.sessionFlashMessage');
					echo $content_for_layout; 
				}
				?>
				<div id='clear'></div>
			</div>
			
			
			<div id="footer" style="left: 0px; right:0px; bottom: 0px; ">
				<?php echo $this->Html->link(
						$this->Html->image('Manager.logo.png', array('alt' => __('Virtual Telecom: tecnologia e liberdade.'), 'border' => '0')),
						'http://www.virtualtelecom.com.br/',
						array('target' => '_blank', 'escape' => false)
					);
				?>
			</div>
		</div>
		<?php //echo $this->element('sql_dump'); ?>
	</body>
</html>
<?php //echo $this->element('Manager.sessionFlashModal'); ?>