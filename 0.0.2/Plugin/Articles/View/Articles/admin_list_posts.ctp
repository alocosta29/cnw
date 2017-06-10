<div class="assist2" >    
  <?php echo $this->element('Articles.linksEditArticle'); ?>
</div>
<div class="main" style="width: 90%;" >
   	<h2>Gerenciamento de artigos</h2>	
<table width="100%" id="tab" cellpadding="3px"  style="font-size: 12px; " class="display">
    <thead>
	<tr>
        <th>VERSÃO</th>
        <th>Titulo</th>
        <th>Resumo</th>
        <th>Palavras-chave</th>
        <th>Imagem destacada</th>
        <th>Status</th>
        <th>Ações</th>
	</tr>	
    </thead>
    <tbody>
    <?php foreach($Artigos as $variavel): ?>
	<tr>
                <td><?php echo h($variavel['Artigo']['versao']); ?></td>
                <td><?php echo h($variavel['Artigo']['titulo']); ?></td>
                <td><?php 
                        if(!empty($variavel['Artigo']['resumo'])){
                            echo '<span class="success-destak">CRIADO</span>';
                        }else{
                            echo '<span class="text-destak">NÃO CRIADO</span>';
                        }
                     ?>
                </td>
                 <td><?php 
                        if(!empty($variavel['Artigo']['keywords'])){
                            echo '<span class="success-destak">DEFINIDAS</span>';
                        }else{
                            echo '<span class="text-destak">NÃO DEFINIDAS</span>';
                        }
                     ?>
                </td>
                
                
                <td>
                    <?php 
                        if(!empty($variavel['Artigo']['imagem'])){
                             echo '<span class="success-destak">DEFINIDA</span>';
                        }else{
                            echo '<span class="text-destak">NÃO DEFINIDA</span>';
                        }
                     ?>
                </td>
                <td><?php echo $this->Complement->getStatusPost($variavel['Artigo']['status']); ?></td>
		<td class="actions">
                    <?php 
                    
                    
                    
                    
                    if($variavel['Artigo']['status'] == 'R')
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
                        'A' => $this->Html->link('Detalhes', array('action'=>'view', $caderno, $variavel['Artigo']['id'])),
                        'N' => $this->Html->link('Detalhes', array('action'=>'view', $caderno, $variavel['Artigo']['id'])),
                            'P'=>$this->Html->link('Detalhes', array('action'=>'view', $caderno, $variavel['Artigo']['id'])),
                        );
                        echo $arrayStatus[$variavel['Artigo']['status']];
                        ?>
		</td>
	</tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    <?php echo $this->element('getDataTable', array('id'=>'tab', 'col'=>0, 'order'=>'desc')); ?>   
</div> 

