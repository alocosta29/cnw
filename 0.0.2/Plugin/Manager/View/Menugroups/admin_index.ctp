<div class="main">
	<h2><?php echo __('Grupo de menu'); ?></h2>
	<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
	<tr>
			<th><?php echo $this->Paginator->sort('grupo'); ?></th>
			<th><?php echo $this->Paginator->sort('parent_id', 'Pai'); ?></th>
			<th><?php echo $this->Paginator->sort('ordem'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach($menugroups as $menugroup): ?>
	<tr>
		<td><?php echo h($menugroup['Menugroup']['grupo']); ?>&nbsp;</td>
		<td><?php 
		if(empty($menugroup['Menugroup']['parent_id'])){
			echo 'Nenhum';
		}else{
			echo h($menugroup['ParentMenugroup']['grupo']);
		}
		 ?></td>
		<td><?php echo h($menugroup['Menugroup']['ordem']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->AclLink->link(__('Editar'), array('action' => 'edit', $menugroup['Menugroup']['id'])); ?>
			<?php echo $this->AclLink->postLink(__('Deletar'), array('action' => 'delete', $menugroup['Menugroup']['id']), null, __('Você tem certeza que deseja excluir o grupo # %s?', $menugroup['Menugroup']['grupo'])); ?>
		</td>
	</tr>
    <?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->element('paginacao'); ?>
</div>
