<div class="main" style="width: 95%; ">
	<h2>Especificações de anúncios</h2>	
<table cellpadding="2px" cellspacing="0" id="tab" width="100%" class="display" style="font-size: 12px; ">
    <thead>
	<tr>
		<th>Tipo</th>
                <th>Alias</th>
                <th width="10%">Largura mínima(px)</th>
                <th width="10%">Largura máxima(px)</th>
                <th width="10%">Altura mínima(px)</th>
                <th width="10%">Altura máxima(px)</th>
                <th>Descrição</th>
                <th width="15%">Ações</th>
	</tr>	
    </thead>
    <tbody>
	<?php foreach ($AdTypes as $variavel): ?>
	<tr>
		<td><?php echo h($variavel['AdType']['tipo']); ?></td>
                <td><?php echo h($variavel['AdType']['alias']); ?></td>
                <td><?php echo h($variavel['AdType']['min_width']); ?></td>
                <td><?php echo h($variavel['AdType']['max_width']); ?></td>
                <td><?php echo h($variavel['AdType']['min_height']); ?></td>
                <td><?php echo h($variavel['AdType']['max_height']); ?></td>
                <td><?php echo h($variavel['AdType']['descricao']); ?></td>
       
		<td class="actions">
			<?php echo $this->AclLink->link(__('Edit'), array('action' => 'edit', $variavel['AdType']['id'])); ?>
			<?php echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $variavel['AdType']['id']), null, __('Tem certeza que deseja deletar a especificação %s?', $variavel['AdType']['tipo'])); ?>
			
		</td>
	</tr>
<?php endforeach; ?>
        </tbody>
        </table>
        <?php echo $this->element('getDataTable', array('id'=>'tab', 'col'=>1, 'order'=>'desc')); ?>   
</div>

