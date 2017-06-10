<div class="main">
	
			<table class="scroll" width="100%">
				
			<tr>
				<th colspan="2"><?php  echo __('Configuração selecionada');?></th>
			</tr>
			<tr>
				<th><?php echo __('Id'); ?></th>
				<td><?php echo h($configmail['Configmail']['id']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Transport'); ?></th>
				<td><?php echo h($configmail['Configmail']['transport']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('From'); ?></th>
				<td><?php echo h($configmail['Configmail']['from']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Host'); ?></th>
				<td><?php echo h($configmail['Configmail']['host']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Port'); ?></th>
				<td><?php echo h($configmail['Configmail']['port']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Timeout'); ?></th>
				<td><?php echo h($configmail['Configmail']['timeout']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Username'); ?></th>
				<td><?php echo h($configmail['Configmail']['username']); ?></td>
			</tr>		
			<tr>
				<th><?php echo __('Password'); ?></th>
				<td><?php echo h($configmail['Configmail']['password']); ?></td>
			</tr>		
			<tr>
				<th><?php echo __('Client'); ?></th>
				<td><?php echo h($configmail['Configmail']['client']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('EmailFormat'); ?></th>
				<td><?php echo h($configmail['Configmail']['emailFormat']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Log'); ?></th>
				<td><?php echo h($configmail['Configmail']['log']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Charset'); ?></th>
				<td><?php echo h($configmail['Configmail']['charset']); ?></td>
			</tr>
			
			<tr>
				<th><?php echo __('HeaderCharset'); ?></th>
				<td><?php echo h($configmail['Configmail']['headerCharset']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Attachments'); ?></th>
				<td><?php echo h($configmail['Configmail']['attachments']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Tls'); ?></th>
				<td><?php echo h($configmail['Configmail']['tls']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Template'); ?></th>
				<td><?php echo h($configmail['Configmail']['template']); ?></td>
			</tr>
	</table>
</div>

