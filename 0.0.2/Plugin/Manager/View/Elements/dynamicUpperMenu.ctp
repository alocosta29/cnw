<?php


 if(isset($this->params['menuSuperior']) and $this->params['menuSuperior']<>false): 
	$menuSuperior = $this->params['menuSuperior'];
	foreach($menuSuperior as $menu):
	?>
<li style="position: static;" class="">
	<a class="ajxsub" href="#">
	<?php echo $menu['grupo']; ?>
	</a><ul>
		<?php echo $this->MenuAssistent->_show($menu['id']); ?>	
		<?php echo $this->SubmenuAssistent->_showSubmenu($menu['id'], $this->Session->read('Auth.User.role_id')); ?>				
	</ul>	
	</li>		
<?php 
endforeach;
endif; ?>