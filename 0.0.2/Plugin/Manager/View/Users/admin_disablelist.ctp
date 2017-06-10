<div class="main">
	<h2><?php echo __('Usuários Desativados');?></h2>
	
	<div style=" width:800px;">
		<table cellpadding="0" cellspacing="0" id="dataTable1" width="800" class="scroll">
			<tr>
					<th><span class="space"><?php echo $this->Paginator->sort('id', 'Nº');?></span></th>
					<th><span class="space"><?php echo $this->Paginator->sort('name', 'Nome');?></span></th>
					<th><span class="space"><?php echo $this->Paginator->sort('group_id', 'Grupo');?></span></th>
					<th><span class="space"><?php echo $this->Paginator->sort('email', 'E-mail');?></span></th>
					<th class="actions"><span class="space"><?php echo __('Ações');?></span></th>
			</tr>
			
			<?php 
			$x=1;
			foreach ($users as $user): 
			?>
				<tr>
					<td><span class="space"><?php echo $x; ?>&nbsp;</span></td>
					<td><span class="space"><?php echo h($user['User']['username']); ?>&nbsp;</span></td>
					<td>
						<span class="space">
						<?php //echo $this->Html->link($user['Role'][0]['alias'], array('controller' => 'roles', 'action' => 'view', $user['Role'][0]['id'])); ?>
						<?php 
							if(isset($user['Role'][0]['alias'])){
								echo $user['Role'][0]['alias'];
							} 
						?>
						</span>
					</td>
					<td><span class="space">
						<?php
						if(isset($user['Person']['Contact']) and !empty($user['Person']['Contact'])){
							$sepvalue = '';
							foreach ($user['Person']['Contact'] as $key => $value) {
								if ( isset($value['Contactstype']['tipo']) && ($value['Contactstype']['tipo']=='email') && (strlen(trim($value['contato']))>0) ){
									echo $sepvalue.$value['contato'];
									$sepvalue = ', ';
								} 
							}
						}
						?>
					&nbsp;</span></td>
					<td class="actions">
							<?php echo $this->Form->postLink(__('Reativar'), array('action' => 'reactivate', 
					$user['User']['id']), null, __('Você tem certeza que deseja reativar o usuário %s?', $user['User']['username'])); ?>
	
					</td>
				</tr>
			<?php 
			$x++;
			endforeach; 
			?>
		</table>
	</div>
	
		<?php echo $this->element('paginacao'); ?>
	
</div>

		

<script type="text/javascript">
            fxheaderInit('dataTable1',400,2,0);
            fxheader();
</script>