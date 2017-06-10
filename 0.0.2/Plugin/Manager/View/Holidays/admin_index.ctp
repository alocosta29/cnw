
<div class="main">
	<h2><?php echo __('Feriados'); ?></h2>
	<table class="scroll" width="100%" cellpadding="5px">
	<tr>
			<th><?php echo $this->Paginator->sort('data'); ?></th>
			<th><?php echo $this->Paginator->sort('descricao'); ?></th>
			<th class="actions"><?php echo __('Ações'); ?></th>
	</tr>
	<?php foreach ($holidays as $holiday): ?>
	<tr>
		<td><?php echo $this->Time->Format('d/m/Y', $holiday['Holiday']['data'] ); ?>&nbsp;</td>
		<td><?php echo h($holiday['Holiday']['descricao']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $holiday['Holiday']['id'])); ?>
			<?php echo $this->Form->postLink(__('Deletar'), array('action' => 'delete', $holiday['Holiday']['id']), null, __('Você tem certeza que deseja deletar o feriado %s?', $holiday['Holiday']['descricao'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->element('paginacao'); ?></div>
