<div class="main">
	<h2>Módulos cadastrados</h2>	
<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
	<tr>
		<th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>
		<th><?php echo $this->Paginator->sort('alias', 'Pseudônimo'); ?></th>
		<th>Ações</th>
	</tr>	
	<?php foreach ($Modules as $module): ?>
	<tr>
		<td><?php echo h($module['Module']['nome']); ?></td>
		<td><?php echo h($module['Module']['alias']); ?></td>
		<td class="actions">
			<?php echo $this->AclLink->link(__('Edit'), array('action' => 'edit', $module['Module']['id'])); ?>
			<?php echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $module['Module']['id']), null, __('Tem certeza que deseja deletar # %s?', $module['Module']['nome'])); ?>
			
		</td>
	</tr>
<?php endforeach; ?>
</div>