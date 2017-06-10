<div class="systems form">
<?php echo $this->Form->create('System'); ?>
	<fieldset>
		<legend><?php echo __('Edit System'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('acronym');
		echo $this->Form->input('description');
		echo $this->Form->input('versionnumber');
		echo $this->Form->input('createdby');
		echo $this->Form->input('modifiedby');
		echo $this->Form->input('isactive');
		echo $this->Form->input('isdeleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('System.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('System.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Systems'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Nt Notifications'), array('controller' => 'nt_notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Nt Notification'), array('controller' => 'nt_notifications', 'action' => 'add')); ?> </li>
	</ul>
</div>
