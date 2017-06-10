<div class="systemsreleases view">
<h2><?php  echo __('Systemsrelease'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acronym'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['acronym']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Versionupdate'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['versionupdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Versionnumber'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['versionnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Versionnotes'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['versionnotes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Createdby'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['createdby']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifiedby'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['modifiedby']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Isactive'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['isactive']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Isdeleted'); ?></dt>
		<dd>
			<?php echo h($systemsrelease['Systemsrelease']['isdeleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Systemsrelease'), array('action' => 'edit', $systemsrelease['Systemsrelease']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Systemsrelease'), array('action' => 'delete', $systemsrelease['Systemsrelease']['id']), null, __('Are you sure you want to delete # %s?', $systemsrelease['Systemsrelease']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Systemsreleases'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Systemsrelease'), array('action' => 'add')); ?> </li>
	</ul>
</div>
