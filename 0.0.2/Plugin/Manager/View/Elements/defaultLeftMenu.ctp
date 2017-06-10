<?php	
if($this->Session->read('Auth.User.person_id'))
{
?>
<ul>
<li>
<?php echo $this->Html->link('Home', array('controller'=>'users', 'action'=>'index', 'plugin'=>'manager', 'admin'=> true), array('class'=>'menu_format')); ?>
</li>	
		<?php
		 if(isset($this->params['menuSuperior']) and $this->params['menuSuperior']<>false): 
			$menuSuperior = $this->params['menuSuperior'];
			foreach($menuSuperior as $menu): ?>
			<li>
				<?php echo $this->Html->link($menu['grupo'], array('plugin'=>'manager', 'controller'=>'menu', 'action'=>'menu', $menu['id']), array('class'=>'menu_format')); ?>
			</li>
		<?php	
			endforeach;
		endif;
		?>
		
</ul>			
<?php	
}
?>
