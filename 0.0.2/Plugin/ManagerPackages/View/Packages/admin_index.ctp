<div class="main">
	<h2><?php echo __('Lista de pacotes com acesso controlado por usuário'); ?></h2>
	<table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
	<tr>
			<th><?php echo $this->Paginator->sort('nome'); ?></th>
			<th><?php echo $this->Paginator->sort('plugin'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach($packages as $package): ?>
	<tr>
		<td><?php echo h($package['Package']['nome']); ?>&nbsp;</td>
		<td><?php echo h($package['Package']['plugin']); ?>&nbsp;</td>
		<td class="actions">
		<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $package['Package']['id'])); ?>
			<?php 
			if($package['Package']['isactive'] == 'N')
			{
				echo $this->AclLink->postLink(__('Ativar'), array('action' => 'ativa', $package['Package']['id']), null, __('Tem certeza que deseja ativar o controle de acesso do pacote %s?', $package['Package']['nome']));	
			}else{
				echo $this->AclLink->postLink(__('Desativar'), array('action' => 'desativa', $package['Package']['id']), null, __('Tem certeza que deseja desativar o pacote %s do controle de acesso por usuário? Desativando, o controle de acesso passará a ser por grupo.', $package['Package']['nome']));
			}
			echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $package['Package']['id']), null, __('Você tem certeza que deseja deletar o pacote %s do controle de acesso por usuário?', $package['Package']['nome'])); 
			?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	<?php echo $this->element('paginacao'); ?>
</div>