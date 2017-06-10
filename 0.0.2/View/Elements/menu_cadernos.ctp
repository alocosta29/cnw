		<?php echo $this->Html->css('Layout2.sgpLayout/menuEsquerdo'); ?>
		
		<script type="text/javascript">
		    $(document).ready(function() {
		        var accordion_head = $('.accordion > li > a'),
		            accordion_body = $('.accordion li > .sub-menu');
		        accordion_head.on('click', function(event) {
		            if ($(this).attr('class') != 'active'){
		                accordion_body.slideUp();
		                $(this).next().stop(true,true).slideToggle('slow');
		               accordion_head.removeClass('active');
		                $(this).addClass('active');
		            }
		        });
		    });
		</script>
		
		<ul class="accordion">
			<li id="one"> 
	       	<?php 
	       	$home = $this->Html->image('Layout2.menu_colunas/home.png');
	       	echo $this->Html->link($home, 
	       	array('plugin'=>'manager', 'controller'=>'users', 'action'=>'index', 'admin'=>'true'), array('escape'=>false)); ?>
	    	</li>
		
			
			
			<?php 
			/**
			 * Menu dos recursos para assinantes
			 */		
			##### MENU PARA COLUNISTAS	#####
			if($this->params['permission']){
				$permission = $this->params['permission']; ?>
			<?php 
			if(in_array('Columnists', $permission)): ?>
				<li id="four" class="cloud">
		       	<a href="#"><?php echo $this->Html->image('Layout2.menu_colunas/postagens.png'); ?></a>
		       	 <ul class="sub-menu">
		       	 		<li><?php echo $this->Html->link('Posts', array('plugin'=>'content', 'controller'=>'columnists', 'action'=>'index', 'admin'=>true)); ?></li>
		       	 		<li><?php echo $this->Html->link('Adicionar post', array('plugin'=>'content', 'controller'=>'columnists', 'action'=>'add', 'admin'=>true)); ?></li>
				      	<li><?php echo $this->Html->link('Tags', array('plugin'=>'content', 'controller'=>'columnists', 'action'=>'taglist', 'admin'=>true)); ?></li>
				      	<li><?php echo $this->Html->link('Adicionar tag', array('plugin'=>'content', 'controller'=>'columnists', 'action'=>'addtag', 'admin'=>true)); ?></li>
				      	<li><?php echo $this->Html->link('Categorias', array('plugin'=>'content', 'controller'=>'columnists', 'action'=>'categoria', 'admin'=>true)); ?></li>
				      	<li><?php echo $this->Html->link('Adicionar categoria', array('plugin'=>'content', 'controller'=>'columnists', 'action'=>'addcategoria', 'admin'=>true)); ?></li>
					</ul>
				 </li>
			 <?php endif; 
			 
			 ##### FIM DE MENU PARA COLUNISTAS	#####
			 
			 ?>	
    		<?php } ?>
	
			<li id="three" class="cloud">
	       	<a href="#"><?php echo $this->Html->image('Layout2.menu_colunas/usuarios.png'); ?></a>
				 <ul class="sub-menu">
			      	<li><?php echo $this->Html->link('Alterar senha', array('controller'=>'users', 'action'=>'trocarsenha',  'plugin'=>'manager', 'admin'=>true)); ?></li>
<li><?php echo $this->Html->link('Enviar foto', array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'add', 'admin'=>true)); ?></li>
		       <li><?php echo $this->Html->link('Redimensionar foto', array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'redimensiona', 'admin'=>true)); ?></li>
			   	<li>
				<?php echo $this->Html->link('Deletar perfil', array('plugin'=>'assinante', 'controller'=>'assinantes', 'action'=>'deleteAssinante', 'admin'=>true)); ?>
				</li>
			     </ul>
	        </li>	
        
	        <li id="nineteen" class="cloud">
	       	<a href="#"><?php echo $this->Html->image('Layout2.menu_colunas/negocios.png'); ?></a>
				 <ul class="sub-menu">
						<li>
						<?php echo $this->Html->link('Administrar páginas', array('plugin'=>'enterprise', 'controller'=>'enterprises', 'action'=>'index', 'admin'=>true)); ?>
						</li>
						<li>
						<?php echo $this->Html->link('Cadastrar negócio', array('plugin'=>'enterprise', 'controller'=>'enterprises', 'action'=>'add', 'admin'=>true)); ?>
						</li>
						<li>
						<?php echo $this->Html->link('Mensagens', array('plugin'=>'classificados', 'controller'=>'messages', 'action'=>'index', 'admin'=>true)); ?>
						</li>
						
			     </ul>
	        </li>	
	        <li id="one"> 
		       	<?php 
		       	$sair = $this->Html->image('Layout2.menu_colunas/sair.png');
		       	echo $this->Html->link($sair, 
		       	array('plugin'=>'manager', 'controller'=>'users', 'action'=>'logout', 'admin'=>'true'), array('escape'=>false)); ?>
	    	</li>
       </ul> 