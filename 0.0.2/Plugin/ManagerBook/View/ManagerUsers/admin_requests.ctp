<div class="assist">
<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>
<div class="main">
    <h2><?php echo $this->ReturnData->getBook($caderno).': ';   ?>Novas solicitações </h2>	
<table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
	<tr>
		<th>Nome</th>
        <th>Data/Hora da solicitação</th>
        <th>E-mail</th>
        <th>mensagem</th>
        <th>Ações</th>
        
	</tr>	
	<?php foreach ($list as $variavel): ?>
	<tr>
		<td><?php echo $variavel['Cadastro']['nome']; ?></td>
        <td><?php echo $this->Time->format('d/m/Y H:i', $variavel['Cadastro']['created']); ?></td>
        <td><?php echo $variavel['Cadastro']['email'];  ?></td>
        <td><?php echo $variavel['Cadastro']['mensagem'];  ?></td>
		<td class="actions">
            <?php    
            echo $this->AclLink->postLink(__('Autorizar'), array('action' => 'autorizeRequest', $caderno, $variavel['Cadastro']['id']), null, __('Ao autorizar a solicitação, o solicitante receberá um e-mail com as instruções para criação de cadastro de colunista. Caso o solicitante faça todo o cadastro, ainda caberá ao administrador do caderno liberar o acesso ao módulo de colunistas. Tem certeza que deseja autorizar a solicitação de %s?', $variavel['Cadastro']['nome']));
            echo $this->AclLink->postLink(__('Negar'), array('action' => 'denyRequest', $caderno, $variavel['Cadastro']['id']), null, __('Ao negar a solicitação, o solicitante receberá um e-mail informando a decisão e seu e-mail ficará impossibilitado de nova tentativa. Tem certeza que deseja negar a solicitação de %s?', $variavel['Cadastro']['nome']));
            ?>
            
            
		</td>
	</tr>
<?php endforeach; ?>
    </table>
    <?php echo $this->element('paginacao'); ?>
</div>
