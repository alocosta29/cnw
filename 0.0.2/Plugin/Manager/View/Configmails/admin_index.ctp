
<div class="main">
	<h2><?php echo __('Configurações de remetente');?></h2>
	<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
	<tr>
			<th><?php echo $this->Paginator->sort('transport', 'Transporte');?></th>
			<th><?php echo $this->Paginator->sort('from', 'Remetente');?></th>
			<th><?php echo $this->Paginator->sort('isdeleted', 'Ativo?');?></th>
			<th class="actions"><?php echo __('Ações');?></th>
	</tr>
	<?php
	foreach ($configmails as $configmail): ?>
	<tr>
		
		<td><?php echo h($configmail['Configmail']['transport']); ?>&nbsp;</td>
		<td><?php echo h($configmail['Configmail']['from']); ?>&nbsp;</td>
		<td><?php 
		if($configmail['Configmail']['isdeleted'] == 'N')
		{
			echo "Sim";
		}else{
			echo 'Não';
		}
		 ?></td>
	
	
		<td class="actions">
			<?php 
			
			echo $this->Html->link(__('Editar'), array('action' => 'edit', $configmail['Configmail']['id'])); ?>
			
			<?php 
			if($this->Session->read('Auth.User.role_id') == 1):
			echo $this->Html->link(__('Visualizar'), array('action' => 'view', $configmail['Configmail']['id'])); ?>
			<?php 
			if($configmail['Configmail']['isdeleted'] == 'N')
			{
			echo $this->Form->postLink(__('Desativar'), array('plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'disableConfigmail',
									'admin'=>false, $configmail['Configmail']['id']), null, __('Você tem certeza que deseja desativar essa configuração?', $configmail['Configmail']['id']));	
			}else{
			echo $this->Form->postLink(__('Reativar'), array('plugin'=>'manager',
									'controller'=>'configmails',	
									'action' => 'enableConfigmail',
									'admin'=>false, $configmail['Configmail']['id']), null, __('Você tem certeza que deseja ativar essa configuração?', $configmail['Configmail']['id']));		
			}
			
			
			endif;

?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->element('paginacao'); ?>
</div>
