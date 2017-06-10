<div  style='width:1200px;'>

<div class="action">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Notification'), array('action' => 'edit', $notification['Notification']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Notification'), array('action' => 'delete', $notification['Notification']['id']), null, __('Are you sure you want to delete # %s?', $notification['Notification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New System'), array('controller' => 'systems', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New From User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

<div class="main">
<h2><?php  echo __('Notification'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd>
			<?php echo $this->Html->link($notification['System']['id'], array('controller' => 'systems', 'action' => 'view', $notification['System']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('From User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($notification['FromUser']['username'], array('controller' => 'users', 'action' => 'view', $notification['FromUser']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($notification['ToUser']['username'], array('controller' => 'users', 'action' => 'view', $notification['ToUser']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Msg Type'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['msg_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Msg Text'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['msg_text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Msg Status'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['msg_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visualized'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['visualized']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Createdby'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['createdby']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifiedby'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['modifiedby']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Isactive'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['isactive']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Isdeleted'); ?></dt>
		<dd>
			<?php echo h($notification['Notification']['isdeleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

</div>
