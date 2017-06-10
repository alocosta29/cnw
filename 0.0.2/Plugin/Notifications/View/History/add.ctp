<div class="notifications form">
<?php echo $this->Form->create('Notification'); ?>
	<fieldset>
		<legend><?php echo __('Add Notification'); ?></legend>
	<?php
		echo $this->Form->input('to_user_id');
		echo $this->Form->input('msg_text');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Notifications'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New System'), array('controller' => 'systems', 'action' => 'add')); ?> </li>
	</ul>
</div>
