
<div class="main">
		<h2><?php echo __('Papeís/Grupos');?></h2>
		
		<table class="scroll" width="100%" cellpadding="5px" cellpadding="0">
			<tr>
				<th>Papel/Grupo</th>
				<th>Ações</th>
			<tr>
				
			<?php foreach($aros as $aro): ?>
			<tr>
				<td><?php echo $aro['Role']['alias']; ?></td>
				<td class="actions">
				<?php echo $this->AclLink->link(__('Editar'), array('action' => 'edit', $aro['Role']['id'])); ?>
				<?php echo $this->AclLink->postLink(__('Deletar'), array('action' => 'delete', $aro['Role']['id']), null, __('Você tem certeza que deseja deletar esse grupo?', $aro['Role']['id'])); ?>
				<?php echo $this->AclLink->link(__('Gerenciar permissões'), array('plugin'=>'manager' ,'controller'=>'permissions' ,'action'=>'index' ,'admin' => true, 
				$aro['Role']['id'])); ?>
				</td>
			<tr>
			<?php endforeach; ?>	
		</table>
		
</div>