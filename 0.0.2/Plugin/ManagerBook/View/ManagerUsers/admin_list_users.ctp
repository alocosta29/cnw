
<div class="assist">
<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>
<div class="main">
    <h2><?php echo $this->ReturnData->getBook($caderno).': ';   ?>Listagem de colunistas </h2>	
<table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
	<tr>
		<th>Nome</th>
        <th><?php echo $this->Paginator->sort('username', 'Login de usuário'); ?></th>
        <th><?php echo $this->Paginator->sort('created', 'Cadastrado em'); ?></th>
        <th>Autorizado por</th>
        <th>Ações</th>
        
	</tr>	
	<?php foreach ($list as $variavel): 

        ?>
	<tr>
		<td><?php echo $variavel['User']['nome']; ?></td>
        <td><?php echo $variavel['User']['username']; ?></td>
        <td><?php echo $this->Time->format('d/m/Y H:i', $variavel['AccessCaderno']['created']); ?></td>
        <td><?php echo $variavel['AccessCaderno']['autorizebyname']; ?></td>
		<td class="actions">
<?php echo $this->Html->link(__('Detalhes'), array('action' => 'viewProfile', $caderno, $variavel['User']['person_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
    </table>
    <?php echo $this->element('paginacao'); ?>
</div>