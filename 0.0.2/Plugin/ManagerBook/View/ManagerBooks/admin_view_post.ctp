<div class="assist">    
  <?php //echo $this->element('Articles.menuCol'); ?>

    <ul>
        <?php 
            
        if($dataArticle['status'] == 'A'){
            
        echo '<li>'.$this->Html->link('Preview', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'previewPost', $caderno, $dataArticle['id']), array('target'=>'_blank')).'</li>'; 
            
              echo '<li>'.$this->Form->postLink(__('Aprovar'), array('action' => 'authorizePosts', $caderno, $dataArticle['id']), null, __('Tem certeza que deseja aprovar o artigo %s?', $dataArticle['titulo'])).'</li>'; 
              echo '<li>'.$this->Html->link(__('Reprovar (Envia para revisão do colunista)'), array('action' => 'reprovePosts', $caderno, $dataArticle['id'])).'</li>';
            }elseif($dataArticle['status'] == 'P'){
               echo '<li>'.$this->Html->link(__('Reverter Aprovação'), array('action' => 'reverseApprovalPosts', $caderno, $dataArticle['id'])).'</li>'; 
            }
            
            
            
        ?>
    </ul>  
    
   <br>
    <?php echo $this->element('ManagerBook.menuManagerBook'); ?>
    <br>
    <br>
    <br>    
 
</div>
<div class="main">
   	<h2>Título: <?php echo $dataArticle['titulo']; ?></h2>	
    <?php
        echo '<strong>Publicado em </strong>'.$this->Time->format('d/m/Y H:i', $dataArticle['data_publicacao']).'<br><br>';
        echo '<strong>RESUMO</strong><br>'.$dataArticle['resumo'].'<br><br>';
         echo '<strong>SUB-CATEGORIAS</strong><br>'.$dataArticle['categorias'].'<br><br>';
        
         echo '<div style="width: 100%; max-height: 150px; overflow-y: auto; padding-right:10px; ">';
         echo '<strong>TEXTO</strong><br>'.$dataArticle['texto'].'<br><br>'; 
         
         echo '</div>';
          echo '<br><br><strong>ARQUIVOS ANEXOS</strong><br>';
        
        if(!empty($listFiles)){
            echo '<ul>';
            foreach($listFiles as $list){
               echo "<li>".$list['Extra']['nome'].' ('.$list['Extra']['descricao'].'): '.$this->Html->link('DOWNLOAD', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'getExtraFile', $list['Extra']['arquivo'], $list['Extra']['tipo_arquivo']), array('target'=>'_blank'));
        
               echo '</li>';
            }
            echo '</ul><br><br>';
        }else{
            echo "<span style='color: #FF0000; '>ESTE ARTIGO NÃO CONTÉM ARQUIVOS ANEXOS! </span><br><br>";
            
        }
         
    ?>
</div>
