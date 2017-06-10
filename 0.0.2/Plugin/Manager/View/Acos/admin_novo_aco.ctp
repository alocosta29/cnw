<div class="main">
	<table border="0" class="scroll" width="100%">
	<tr><th>Acos(controllers e/ou métodos) recém adicionados</th></tr>	
	<?php foreach($missing_aco_nodes as $aco): ?> 
	<tr><td><?php echo $aco; ?></td></tr>
	<?php endforeach; ?>
	
	<?php if(!empty($missing_aco_nodes)): ?>
		<tr><td><br></td></tr>
		<tr><td class="actions">
			<?php echo $this->Html->link('Adicionar aco', array('action'=>'synchronize', $run = 'run')); ?></td></tr>
		
	<?php endif; ?>
	
	
	
	
	</table>
	
	
	
	
</div>