<h3><?php echo __('Gerenciar menu administrativo'); ?></h3>
	<ul>
		
		<?php if($this->Session->read('Auth.User.role_id') == 1): ?>
		<li><?php echo $this->Html->link(__('Listar item'), array('controller' => 'menuitens','action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Adicionar item'), array('controller' => 'menuitens','action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Listar grupos'), array('controller' => 'menugroups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Adicionar grupo'), array('controller' => 'menugroups', 'action' => 'add')); ?> </li>
		<?php endif; ?>
		
		<li><?php echo $this->Html->link(__('Associar menu e perfil'), array('controller' => 'MenuitensRoles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar associações'), array('controller' => 'MenuitensRoles', 'action' => 'index')); ?> </li>
	
	
	</ul>