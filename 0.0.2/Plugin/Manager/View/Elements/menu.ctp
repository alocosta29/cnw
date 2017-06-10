<script>
var tempo = window.setInterval(loadNotif, 20000);
function loadNotif() {
	$('#conteudoNotif').load("<?php echo $this->Html->url('/');?>notifications/notifications/regs");
}
</script>
<div class="mhjscss">
		<div class="ajxmw1">
			<div class="ajxmw2">	
				<ul>
				<li style="position: static;" class="siglaSystem"><?php echo $this->Html->link('', array('controller'=>'users', 'action'=>'index', 'plugin'=>'manager', 'admin'=> true)); ?></li>	
				<li style="position: static;" class="btNt">
					<div id="conteudoNotif">
						<?php //echo $this->Notifications->show(); ?>
					</div>	
				</li>	
				<?php	
				if($this->Session->read('Auth.User.person_id'))
				{
				?>
				<li style="position: static;" class=""><?php echo $this->Html->link('Home', array('controller'=>'users', 'action'=>'index', 'plugin'=>'manager', 'admin'=> true)); ?></li>
						<!-- Menu Variavel -->
						<?php 
				echo $this->requestAction(
				    array('controller' => 'Menuitens', 'action' => 'geraMenu', 'admin'=>false, 'plugin'=>'manager'),
				    array('return')
				);
				
				 ?>
						
						<!-- FIM Menu Variavel -->	
				<li style="position: static;" class=""><?php echo $this->Html->link('Sair', array('plugin'=>'manager', 'controller'=>'users', 'action'=>'logout', 'admin'=>'true')); ?></li>	
				<?php	
				}
				?>
				</ul>
			</div> <!-- FIM ajxmw2 -->
		</div> <!-- FIM ajxmw1 -->
</div> <!-- FIM mhjscss -->