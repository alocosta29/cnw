<div class="systemsreleases form">
<?php echo $this->Form->create('Systemsrelease'); ?>
	<fieldset>
		<legend><?php echo __('Add Systemsrelease'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Systemsreleases'), array('action' => 'index')); ?></li>
	</ul>
</div>
