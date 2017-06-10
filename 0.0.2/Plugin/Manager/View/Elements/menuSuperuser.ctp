<?php if($this->Session->read('Auth.User.role_id') == 1): ?>
<li style="position: static;" class=""><a class="ajxsub" href="#">Superuser</a>
	<ul style="display: none;">	
	<li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Menus</a>
		<ul style="display: none;">
			<li style="position: static;" class=""><?php echo $this->AclLink->link('Adicionar grupo', array('plugin'=>'manager','controller'=>'menugroups', 'action'=>'add', 'admin'=>true)); ?></li>
			<li style="position: static;" class=""><?php echo $this->AclLink->link('Visualizar grupos', array('plugin'=>'manager','controller'=>'menugroups', 'action'=>'index', 'admin'=>true)); ?></li>
			<li style="position: static;" class=""><?php echo $this->AclLink->link('Configurar', array('plugin'=>'manager','controller'=>'menugroups', 'action'=>'configMenu', 'admin'=>true)); ?></li>
		</ul>	
	</li>
	<li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Módulos</a>
		<ul style="display: none;">
			<li style="position: static;" class=""><?php echo $this->AclLink->link('Adicionar módulo', array('plugin'=>'manager','controller'=>'modules', 'action'=>'add', 'admin'=>true)); ?></li>
			<li style="position: static;" class=""><?php echo $this->AclLink->link('Visualizar módulos', array('plugin'=>'manager','controller'=>'modules', 'action'=>'index', 'admin'=>true)); ?></li>
			
		</ul>	
	</li>						
	<li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Controllers e métodos(acos)</a>
		<ul style="display: none;">
		<li style="position: static;" class=""><?php echo $this->AclLink->link('Acos obsoletos', array('plugin'=>'manager','controller'=>'acos', 'action'=>'acosObsoletos', 'admin'=>true)); ?></li>
		<li style="position: static;" class=""><?php echo $this->AclLink->link('Acos não cadastrados', array('plugin'=>'manager','controller'=>'acos', 'action'=>'novoAco', 'admin'=>true)); ?></li>
		<li style="position: static;" class=""><?php echo $this->AclLink->link('Acos configurados', array('plugin'=>'manager','controller'=>'acos', 'action'=>'configurados', 'admin'=>true)); ?></li>
		<li style="position: static;" class=""><?php echo $this->AclLink->link('Acos não-configurados', array('plugin'=>'manager','controller'=>'acos', 'action'=>'naoConfigurados', 'admin'=>true)); ?></li>
		</ul>	
	</li>
	<li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Configurações de e-mail</a>
		<ul style="display: none;">
			<li style="position: static;" class=""><?php echo $this->AclLink->link('Adicionar remetente', array('plugin'=>'manager','controller'=>'configmails', 'action'=>'add', 'admin'=>true)); ?></li>
			<li style="position: static;" class=""><?php echo $this->AclLink->link('Visualizar remetente', array('plugin'=>'manager','controller'=>'configmails', 'action'=>'index', 'admin'=>true)); ?></li>
		</ul>	
	</li>
	</ul>
</li>
<?php endif; ?>