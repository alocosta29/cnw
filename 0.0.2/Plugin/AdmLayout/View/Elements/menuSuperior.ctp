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
				<?php if(true == true) :?>
                <li style="position: absolute; " class="btNt">
					<div id="conteudoNotif" style="width:23px;position: absolute;">
						<?php echo $this->Notifications->show(); ?>
					</div>	
				</li>	
                <?php endif; ?>
                <?php	
				if($this->Session->read('Auth.User'))
				{
				?>
                    <li style="position: static;padding-left: 23px;" class=""> <?php echo $this->Html->link('Home', array('controller'=>'users', 'action'=>'index', 'plugin'=>'manager', 'admin'=> true)); ?>
                    </li>
                    <?php echo $this->Element('AccessUsers.menuCols'); ?>
                    <?php echo $this->Element('AdmLayout.dynamicUpperMenu'); ?>
                    <?php //echo $this->Element('Layout.menuHelper'); ?>
                    <?php echo $this->Element('AdmLayout.menuSuperuser'); ?>
                    <li style="position: static;" class=""><?php echo $this->Html->link('Sair', array('plugin'=>'manager', 'controller'=>'users', 'action'=>'logout', 'admin'=>'true')); ?></li>	
				<?php	
				}
				?>
				</ul>
			</div> <!-- FIM ajxmw2 -->
		</div> <!-- FIM ajxmw1 -->
</div> <!-- FIM mhjscss -->