<div class="assist">
    <?php echo $this->element('Articles.linksEditArticle'); ?>
</div>   
<div class="main">
    <h2>Imagem destacada do artigo</h2>	
     OBS: <span style = "color: #ff0000; font-weight: bold; ">A imagem de destaque será aquela que será exibida na listagem de 
        posts na área pública.</span>
     <br> <br>
     
    <table class="scrollQuebra" width="500px" cellpadding="5px">
        
        <tr>
            <th>Artigo</th>
            <td><?php echo $dataCaderno['titulo']; ?></td>
        </tr>  
        
        <tr>
            <th>Sub-categorias</th>
            <td><?php 
            echo $dataCaderno['categorias']; ?></td>
        </tr>   
    
        <tr>
            <th>Imagem selecionada</th>
            <th>Alterar imagem(500x413px)</th>
        </tr>
        
        <tr>
            <td> <?php echo $this->Article->exibeImagePost(array('user_id'=>$dataCaderno['user_id'], 'img'=>$dataCaderno['imagem'], 'caderno'=>$caderno, 'idPost'=>$dataCaderno['id'], 'width'=>"170px")); ?>
                </td>
            <td>
               <?php echo $this->Form->create('Artigo', array('class'=>'default2', 'type'=>'file')); ?>
               <?php echo $this->Form->input('imagem', array('type'=>'file', 'label'=>FALSE)); ?>
               <?php echo $this->Form->end(__('Alterar')); ?>
            </td>
        </tr>
        
     </table>
     
    <br>
    <?php
    $imagem = $this->Html->image('voltar.png');
    echo $this->Html->link($imagem, array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'view', $caderno, $dataCaderno['id']), array('escape'=>false));
    ?>
</div> 