
<div class="mhjscss">
		<div class="ajxmw1">
			<div class="ajxmw2">	
				<ul>
				<li style="position: static;" class="siglaSystem"><?php echo $this->Html->link('', array('controller'=>'users', 'action'=>'index', 'plugin'=>'manager', 'admin'=> true)); ?></li>	
				<?php	
				if($this->Session->read('Auth.User.person_id'))
				{
				?>
				<li style="position: static;" class="">
				<?php echo $this->Html->link('Home', array('controller'=>'users', 'action'=>'index', 'plugin'=>'manager', 'admin'=> true)); ?>
				</li>
					
					
				<?php echo $this->Element('Manager.dynamicUpperMenu'); ?>	
					
					
					
					
				<?php //echo $this->Element('Manager.menuSuperuser'); ?>
				<li style="position: static;" class=""><?php echo $this->Html->link('Sair', array('plugin'=>'manager', 'controller'=>'users', 'action'=>'logout', 'admin'=>'true')); ?></li>	
				<?php	
				}
				?>
				</ul>
			</div> <!-- FIM ajxmw2 -->
		</div> <!-- FIM ajxmw1 -->
</div> <!-- FIM mhjscss -->