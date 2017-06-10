<div class="main">
	<h2>Termos de adesão de colunistas</h2>	
<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
	<tr>
		<th><?php echo $this->Paginator->sort('created', 'Criado em'); ?></th>
        <th><?php echo $this->Paginator->sort('createdby', 'Criado por'); ?></th>
        <th><?php echo $this->Paginator->sort('isactive', 'Status'); ?></th>
        <th>Ações</th>
	</tr>	
	<?php foreach ($Terms as $variavel): ?>
	<tr>
		<td><?php echo $this->Time->format('d/m/Y', $variavel['Term']['created']); ?></td>
        <td><?php echo $this->ReturnData->getNameMailUser($variavel['Term']['createdby']); ?></td>
        <td><?php echo $this->Complement->getStatusActive($variavel['Term']['isactive']); ?></td>
		<td class="actions">
			<?php echo $this->AclLink->link(__('Visualizar'), array('action' => 'seeTerm', $variavel['Term']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
    </table>
      
<?php echo $this->element('paginacao'); ?>
    
</div>
