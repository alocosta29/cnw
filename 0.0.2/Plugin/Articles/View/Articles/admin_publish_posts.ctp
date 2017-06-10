<div class="assist">    
  <?php echo $this->element('Articles.linksEditArticle'); ?>
</div>
<div class="main">
   	<h2>Artigos publicados</h2>	
<table cellpadding="3px" cellspacing="0" class="scrollQuebra" width="100%">
	<tr>
        <th><?php echo $this->Paginator->sort('versao', 'VERSÃO'); ?></th>
        <th><?php echo $this->Paginator->sort('titulo', 'Titulo'); ?></th>
        <th><?php echo $this->Paginator->sort('data_publicacao', 'Data/hora da publicação '); ?></th>
        <th>Total de visitas</th>
        <th>Total de visitantes únicos</th>
        <th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
        <th>Ações</th>
	</tr>	
	<?php foreach($Artigos as $variavel): ?>
	<tr>
                <td><?php echo h($variavel['Artigo']['versao']); ?></td>
                <td><?php echo h($variavel['Artigo']['titulo']); ?></td>
                <td><?php echo $this->Time->format('d/m/Y H:i', $variavel['Artigo']['data_publicacao']); ?>h</td>
                <td><?php 
                        $total = 0;
                        $unique = 0;
                        if($ArticleStats->start($variavel['Artigo']['id'])){
                            $total = $ArticleStats->totalViews ;
                            $unique = $ArticleStats->uniqueViews ;
                        }
                        echo $total;
                     ?>
                </td>
                <td>
                    <?php 
                       echo $unique;
                    
                     ?>
                </td>
                <td><?php echo $this->Complement->getStatusPost($variavel['Artigo']['status']); ?></td>
		<td class="actions">
                    <?php if($variavel['Artigo']['status'] == 'R')
                        { 
                    //    echo $this->Html->link('Editar resumo', array('action'=>'editResumo', $caderno, $variavel['Artigo']['id'])); 
                        echo $this->Html->link('Editar', array('action'=>'edit', $caderno, $variavel['Artigo']['id']));
                        echo $this->Html->link('Detalhes', array('action'=>'view', $caderno, $variavel['Artigo']['id']));
                       // echo $this->Html->link('Imagem destacada', array('action'=>'featuredImage', $caderno, $variavel['Artigo']['id']));
                        }
                        $arrayStatus = array(
                      /*  'R' => $this->Form->postLink(__('Enviar para análise'), array('action' => 'changeStatus', $caderno, $variavel['Artigo']['id'], 'A'), null, __(''
                            . 'Após o envio do artigo para análise, o mesmo não poderá ser editado e será enviado para aprovação do moderador.'
                            . 'Tem certeza que deseja fechar o artigo %s?', $variavel['Artigo']['titulo'])),*/
                        'R' => null,  
                        'A' => null,
                        'N' => $this->Html->link('Detalhes', array('action'=>'view', $caderno, $variavel['Artigo']['id'])),
                            'P'=>$this->Html->link('Detalhes', array('action'=>'view', $caderno, $variavel['Artigo']['id'])),
                        );
                        echo $arrayStatus[$variavel['Artigo']['status']];

                        
                        ?>
                    
		</td>
	</tr>
<?php endforeach; ?>
        </table>
    <?php echo $this->element('paginacao'); ?>
</div> 


