<div class="assist">
    <?php echo $this->element('ManagerAds.menuManagerAds'); ?>
</div>

<div class="main">
    
    
    <?php echo $this->Form->create('Ad', array('class'=>'default2')); ?>
	<fieldset>
		<legend><h2>Enviar anúncio para revisão</h2></legend>
         <?php echo $this->element('ManagerAds.detailsAd'); ?>
	<?php echo $this->Form->input('comments', array('label'=>'Observações', 'required'=>true, 'div'=>'required')); ?>
	<br>
<?php echo $this->Form->end(__('Enviar para revisão')); ?>
</fieldset>
    
    
    
</div>

