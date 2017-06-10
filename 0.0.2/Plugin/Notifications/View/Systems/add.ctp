<div class="systems form">
<?php echo $this->Form->create('System'); ?>
	<fieldset>
		<legend><?php echo __('Add System'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Systems'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Nt Notifications'), array('controller' => 'nt_notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Nt Notification'), array('controller' => 'nt_notifications', 'action' => 'add')); ?> </li>
	</ul>
</div>
