<div class="main">
	
<table border="0" class="scroll" width="100%">
	<tr><th>Acos(controllers e/ou métodos) obsoletos(não existentes do controller)</th></tr>	
	<?php foreach($nodes_to_prune as $aco): ?> 
	<tr><td><?php echo $aco; ?></td></tr>
	<?php endforeach; ?>
	
	<?php if(!empty($nodes_to_prune)): ?>
		<tr><td><br></td></tr>
		<tr><td class="actions">
		<?php echo $this->Html->link('Apagar acos obsoletos', array('action'=>'synchronize', $run = 'delete')); ?>
		
		
		
		
		</td></tr>
		
	<?php endif; ?>
	
	
	
	
	</table>
		
	
	
</div>