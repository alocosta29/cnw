<div class="assist">
	<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>
<div class="main">
<h2>Subcategorias do caderno</h2>	
<table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
	<tr>
		<th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>
        <th><?php echo $this->Paginator->sort('alias', 'Alias'); ?></th>
        <th>Ações</th>
	</tr>	
	<?php foreach ($Categorias as $variavel): ?>
	<tr>
		<td><?php echo $variavel['Categoria']['nome']; ?></td>
        <td><?php echo $variavel['Categoria']['alias']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'editCategorie', $caderno, $variavel['Categoria']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'deleteCategorie', $caderno, $variavel['Categoria']['id']), null, __('Tem certeza que deseja deletar a categoria %s?', $variavel['Categoria']['nome'])); ?>
		</td>
	</tr>
    <?php endforeach; ?>
    </table>
<?php echo $this->element('paginacao'); ?>
</div>