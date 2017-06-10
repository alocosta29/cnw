<div class="main">
	<h2>Consultar usuários</h2>
	<?php echo $this->element('consultaUser'); ?>
	
<?php if(isset($users) and !empty($users)): ?>
	<table border="0" class="scroll" width="100%" cellpadding="5px">
			<tr>
			<th>Nome</th>
			<th>Login</th>
			<th>CPF</th>
			<th>Permissão no sistema</th>
			<th>Ações</th>
			</tr>
			<?php foreach($users as $user): ?>
			<tr>
			<td><?php echo $user['Individual']['nome']; ?></td>
			<td><?php echo $user['User']['username']; ?></td>
			<td><?php echo $this->FormatManager->_mask($user['Individual']['cpf'], '###.###.###-##'); ?></td>
			<td><?php echo $this->FormatManager->_consultaPermissaoSistema($user['User']['id']); ?></td>
			<td class="actions">
			<?php echo $this->AclLink->link('Visualizar perfil', array('controller'=>'persons', 'action'=>'view', $user['Person']['id'])); ?>
			</td>
			</tr>
				<?php endforeach; ?>
	</table>
<?php echo $this->element('paginacao'); ?>
<?php endif; ?>
</div>