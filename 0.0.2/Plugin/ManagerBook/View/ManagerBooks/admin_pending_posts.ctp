<div class="assist">
	<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>
<div class="main">
   	
    <h2>Artigos pendentes para avaliação</h2>	
    
    <table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
    <tr>
            <th><?php echo $this->Paginator->sort('titulo', 'Titulo'); ?></th>
            <th>Colunista</th>
            <th><?php echo $this->Paginator->sort('modified', 'Enviado em'); ?></th>
            <th>Ações</th>
    </tr>
    
<?php foreach($lists as $variavel): ?>
	<tr>
        <td><?php echo $variavel['Artigo']['titulo']; ?></td>
        <td><?php echo $this->ReturnData->getNameMailUser($variavel['Artigo']['user_id']); ?></td>
        <td><?php echo $this->Time->format('d/m/Y H:i', $variavel['Artigo']['modified']); ?></td>
		<td class="actions"> 
        <?php echo $this->Html->link(__('Visualizar'), array('action' => 'viewPost', $caderno, $variavel['Artigo']['id'])); ?>
        </td>
	</tr>
<?php endforeach; ?>
    
    </table>
</div>
