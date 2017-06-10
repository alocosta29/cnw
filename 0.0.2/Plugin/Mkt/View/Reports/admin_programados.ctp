<div class="main" style="width: 95%; ">

<h2>ARTIGOS PROGRAMADOS</h2>	

<table cellpadding="3px" cellspacing="0"  width="100%" id="tab" class="display nowrap" style="font-size: 12px; ">
    
    <thead>
	<tr>            
            <th>Titulo do artigo</th>
            <th>Data de publicação</th>
            <th>Caderno</th>
            <th>Resumo</th>
            <th>Colunista</th>
        </tr>
    </thead>
    
    <tbody>
	<?php foreach ($Artigos as $variavel): ?>
	<tr>
            <td><?php echo $variavel['Artigo']['titulo']; ?></td>
            <td><?php echo $this->Time->format('d/m/Y H:i', $variavel['Artigo']['data_publicacao']); ?></td>
            <td><?php echo $variavel['Caderno']['nome']; ?></td>
            <td><?php echo $variavel['Artigo']['resumo']; ?></td>
            <td><?php echo $variavel['Colunista']['apelido']; ?></td>
	</tr>
        <?php endforeach; ?>
    </tbody>
    
</table>
<?php echo $this->element('getDataTable', array('id'=>'tab', 'col'=>1, 'order'=>'desc')); ?>   
</div>
