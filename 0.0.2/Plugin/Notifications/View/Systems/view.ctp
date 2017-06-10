<div class="systems view">
<h2><?php  echo __('System'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($system['System']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acronym'); ?></dt>
		<dd>
			<?php echo h($system['System']['acronym']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($system['System']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Versionnumber'); ?></dt>
		<dd>
			<?php echo h($system['System']['versionnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($system['System']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Createdby'); ?></dt>
		<dd>
			<?php echo h($system['System']['createdby']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($system['System']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifiedby'); ?></dt>
		<dd>
			<?php echo h($system['System']['modifiedby']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Isactive'); ?></dt>
		<dd>
			<?php echo h($system['System']['isactive']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Isdeleted'); ?></dt>
		<dd>
			<?php echo h($system['System']['isdeleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit System'), array('action' => 'edit', $system['System']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete System'), array('action' => 'delete', $system['System']['id']), null, __('Are you sure you want to delete # %s?', $system['System']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Systems'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New System'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Nt Notifications'), array('controller' => 'nt_notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Nt Notification'), array('controller' => 'nt_notifications', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Nt Notifications'); ?></h3>
	<?php if (!empty($system['NtNotification'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('System Id'); ?></th>
		<th><?php echo __('From User Id'); ?></th>
		<th><?php echo __('To User Id'); ?></th>
		<th><?php echo __('Msg Type'); ?></th>
		<th><?php echo __('Msg Text'); ?></th>
		<th><?php echo __('Msg Status'); ?></th>
		<th><?php echo __('Visualized'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Createdby'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Modifiedby'); ?></th>
		<th><?php echo __('Isactive'); ?></th>
		<th><?php echo __('Isdeleted'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($system['NtNotification'] as $ntNotification): ?>
		<tr>
			<td><?php echo $ntNotification['id']; ?></td>
			<td><?php echo $ntNotification['system_id']; ?></td>
			<td><?php echo $ntNotification['from_user_id']; ?></td>
			<td><?php echo $ntNotification['to_user_id']; ?></td>
			<td><?php echo $ntNotification['msg_type']; ?></td>
			<td><?php echo $ntNotification['msg_text']; ?></td>
			<td><?php echo $ntNotification['msg_status']; ?></td>
			<td><?php echo $ntNotification['visualized']; ?></td>
			<td><?php echo $ntNotification['created']; ?></td>
			<td><?php echo $ntNotification['createdby']; ?></td>
			<td><?php echo $ntNotification['modified']; ?></td>
			<td><?php echo $ntNotification['modifiedby']; ?></td>
			<td><?php echo $ntNotification['isactive']; ?></td>
			<td><?php echo $ntNotification['isdeleted']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'nt_notifications', 'action' => 'view', $ntNotification['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'nt_notifications', 'action' => 'edit', $ntNotification['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'nt_notifications', 'action' => 'delete', $ntNotification['id']), null, __('Are you sure you want to delete # %s?', $ntNotification['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Nt Notification'), array('controller' => 'nt_notifications', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
