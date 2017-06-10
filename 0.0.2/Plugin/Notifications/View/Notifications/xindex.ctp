<div  style='width:1200px;'>
<div class="assist">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Notification'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index')); ?> </li>
	</ul>
</div>

	
<div class="main">
	<h2><?php echo __('Notifications'); ?></h2>
	<table cellpadding="0" cellspacing="0"  class="scroll" border='1'>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('system_id'); ?></th>
			<th><?php echo $this->Paginator->sort('from_user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('to_user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('msg_type'); ?></th>
			<th><?php echo $this->Paginator->sort('msg_text'); ?></th>
			<th><?php echo $this->Paginator->sort('msg_status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($notifications as $notification): ?>
	<tr>
		<td><?php echo h($notification['Notification']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($notification['System']['id'], array('controller' => 'systems', 'action' => 'view', $notification['System']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($notification['FromUser']['username'], array('controller' => 'users', 'action' => 'view', $notification['FromUser']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($notification['ToUser']['username'], array('controller' => 'users', 'action' => 'view', $notification['ToUser']['id'])); ?>
		</td>
		<td><?php echo h($notification['Notification']['msg_type']); ?>&nbsp;</td>
		<td><?php echo h($notification['Notification']['msg_text']); ?>&nbsp;</td>
		<td><?php echo h($notification['Notification']['msg_status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $notification['Notification']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $notification['Notification']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $notification['Notification']['id']), null, __('Are you sure you want to delete # %s?', $notification['Notification']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

</div>

