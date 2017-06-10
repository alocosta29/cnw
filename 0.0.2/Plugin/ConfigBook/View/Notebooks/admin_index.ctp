<div class="main">
<table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
	<tr>
		<th><?php echo $this->Paginator->sort('nome'); ?></th>
                <th><?php echo $this->Paginator->sort('alias'); ?></th>
                <th><?php echo $this->Paginator->sort('descricao', 'Descrição'); ?></th>
                <th><?php echo $this->Paginator->sort('cor'); ?></th>
                <th>Ações</th>
	</tr>	
	<?php foreach ($variavels as $variavel): ?>
	<tr>
		<td><?php echo h($variavel['Caderno']['nome']); ?></td>
                <td><?php echo h($variavel['Caderno']['alias']); ?></td>
                <td><?php echo h($variavel['Caderno']['descricao']); ?></td>
                <td bgcolor="<?php echo h($variavel['Caderno']['cor']); ?>" style="color: #fff; font-weight: bold; "><?php echo h($variavel['Caderno']['cor']); ?></td>
		<td class="actions">
			<?php echo $this->AclLink->link(__('Edit'), array('action' => 'edit', $variavel['Caderno']['id'])); ?>
			<?php echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $variavel['Caderno']['id']), null, __('Tem certeza que deseja deletar o caderno %s?', $variavel['Caderno']['nome'])); ?>
			<?php if($variavel['Caderno']['isactive'] == 'N'){
			echo $this->AclLink->postLink(__('Delete'), array('action' => 'ativaModel', $variavel['Caderno']['id']), null, __('Tem certeza que deseja ativar o caderno %s?', $variavel['Caderno']['nome']));	
			}else{
			echo $this->AclLink->postLink(__('Delete'), array('action' => 'desativaModel', $variavel['Caderno']['id']), null, __('Tem certeza que deseja desativar o caderno # %s?', $variavel['Caderno']['nome']));
			}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
    <?php echo $this->element('paginacao'); ?> 
        
</div>