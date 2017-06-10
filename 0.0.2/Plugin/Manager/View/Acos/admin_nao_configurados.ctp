<div class="main">
		<h2><?php echo __('Acos não-configurados');?></h2>
<table border="0" class="scroll" width="100%">
	<tr>
		<?php if($this->Session->read('Auth.User.role_id') == 1): ?>
		<th><?php echo $this->Paginator->sort('alias', 'Plugin/Controller/Método'); ?></th>
		<?php endif; ?>
		<th>Ações</th>
	</tr>	

	<?php 
	foreach($acos as $aco): 
		$palavra = $aco['Aco']['alias'];
		if(strtoupper($palavra[0])==$palavra[0] or $palavra == 'Xdisplay' or $palavra == 'ajaxMsg') 
		{
		} 
		else 
		{
	?> 
	<tr>
		<?php if($this->Session->read('Auth.User.role_id') == 1): ?>
		<td>
			<?php 
			foreach($parent_id as $parent):
				if($aco['Aco']['parent_id'] == $parent['Aco']['id'])
				{
					 echo $parent['AcoParent']['alias'].' > '.$parent['Aco']['alias'];	
				}else{
					echo '';
				}
			endforeach;
			?> > <?php echo $aco['Aco']['alias']; ?>
		</td>
		<?php endif; ?>
	
		<td class="actions">
				<?php //echo $this->Html->link('Editar apelido', array('action'=>'add_apelido', $aco['Aco']['id'])); ?>
				<?php 
				echo $this->AclLink->link('Configurar aco', array('action'=>'configAco', $aco['Aco']['id']));
				if(!empty($aco['Aco']['aliasMetodo']) and $aco['Aco']['parametro'] == 'N'):	
					echo $this->AclLink->link('Configurar menu', array('action'=>'configMenu', $aco['Aco']['id']));	
				endif;	
				?>	
		</td>
	</tr>	
	<?php
	}
	 endforeach; 
	 ?>

</table>
<?php echo $this->Element('paginacao'); ?>
</div>