<div class="assist">
		<?php 
		echo '<br><ul>'.$this->element('Manager.dynamicmenu').'</ul><br>'; 
	 ?>
</div>
<div class="main">
	<h2>titulo da view.</h2>	
<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
	<tr>
		<th><?php echo $this->Paginator->sort('campo', 'titulocampo'); ?></th>
	</tr>	
	<?php foreach ($variavels as $variavel): ?>
	<tr>
		<td><?php echo h($variavel['Model']['campo']); ?></td>
		<td class="actions">
			<?php echo $this->AclLink->link(__('Edit'), array('action' => 'edit', $variavel['Model']['id'])); ?>
			<?php echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $variavel['Model']['id']), null, __('Tem certeza que deseja deletar # %s?', $variavel['Model']['campo'])); ?>
			<?php if($duration['Model']['isactive'] == 'N'){
			echo $this->AclLink->postLink(__('Delete'), array('action' => 'ativaModel', $duration['Model']['id']), null, __('Tem certeza que deseja ativar # %s?', $duration['Model']['referencia']));	
			}else{
			echo $this->AclLink->postLink(__('Delete'), array('action' => 'desativaModel', $duration['Model']['id']), null, __('Tem certeza que deseja desativar # %s?', $duration['Model']['referencia']));
			}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</div>