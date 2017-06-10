<div class="systemsreleases form">
<?php echo $this->Form->create('Systemsrelease'); ?>
	<fieldset>
		<legend><?php echo __('Edit Systemsrelease'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('acronym');
		echo $this->Form->input('versionupdate');
		echo $this->Form->input('versionnumber');
		echo $this->Form->input('versionnotes');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Systemsrelease.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Systemsrelease.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Systemsreleases'), array('action' => 'index')); ?></li>
	</ul>
</div>
