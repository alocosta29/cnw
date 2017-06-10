<div class="assist">    
    <?php echo $this->element('Articles.linksEditArticle'); ?>
    <br>
    <ul>
    <?php
        if($dataArticle['status'] == 'N'){
          echo '<li>'.$this->Form->postLink(__('Criar nova revisão'), array('action' => 'createNewVersion', 
              $caderno, $dataArticle['id']), null, __('Tem certeza que deseja criar uma nova versão do post %s?', $dataArticle['titulo'])).'</li>'; 
        }
        if(in_array($dataArticle['status'], array('R', 'N'))){
          echo '<li>'.$this->Form->postLink(__('Deletar'), array('action' => 'delete', 
              $caderno, $dataArticle['id']), null, __('Tem certeza que deseja deletar # %s?', $dataArticle['titulo'])).'</li>'; 
        }
    ?>
  </ul>  
</div>
<div class="main">
    
    <?php 
    echo $this->Html->script(array('PublicLayout.highlight.pack.js'));
    echo $this->Html->css('PublicLayout.styles/darcula.css'); 
    ?>
    <script>hljs.initHighlightingOnLoad();</script>
   	<h2><?php echo $this->ReturnData->getBook($caderno).': ';   ?> <?php echo $dataArticle['titulo']; ?></h2>	
    <?php echo $this->element('Articles.resumeReproved'); ?>
    <?php
        echo '<strong>VERSÃO: </strong>'.$dataArticle['versao'].'<br>';
        echo '<strong>STATUS: </strong>'.$this->Complement->getStatusPost($dataArticle['status']).'<br>';
        $today = date('Y-m-d H:i');
        
        if(strtotime($today) < strtotime($dataArticle['data_publicacao'])){
            $titleDate = 'DATA/HORA PROGRAMADA DE PUBLICAÇÃO';
        }else{
            $titleDate = 'DATA/HORA DE PUBLICAÇÃO';
        }
        echo '<strong>'.$titleDate.': </strong>'.$this->Time->format('d/m/Y H:i', $dataArticle['data_publicacao']).'<br><br>';
        echo '<strong>SUB-CATEGORIAS</strong><br>'.$dataArticle['categorias'].'<br><br>';
        echo '<strong>PALAVRAS-CHAVE</strong><br>'.$dataArticle['keywords'].'<br><br>';
        echo '<strong>RESUMO</strong><br>'.$dataArticle['resumo'].'<br><br>';
        echo '<strong>TEXTO</strong><br><div style="overflow-y: scroll; max-height: 160px; padding-right: 5px; margin-bottom: 20px;">'.$dataArticle['texto'].'<br></div>';    
    
        echo '<br><strong>ARQUIVOS ANEXOS</strong><br>';
        
        if(!empty($listFiles)){
            echo '<ul>';
            foreach($listFiles as $list){
               echo "<li>".$list['Extra']['nome'].' ('.$list['Extra']['descricao'].'): '.$this->Html->link('DOWNLOAD', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'getExtraFile', $list['Extra']['arquivo'], $list['Extra']['tipo_arquivo']), array('target'=>'_blank'));
               if($dataArticle['status'] == 'R'):
               echo ' | '.$this->Form->postLink(__('DELETE'), array('action' => 'deleteExtra', $caderno, $list['Extra']['id']), null, __('Tem certeza que deseja excluir o arquivo %s?', $list['Extra']['nome']));
              endif;
               echo '</li>';
            }
            echo '</ul><br><br>';
        }else{
            echo "<span style='color: #FF0000; '>ESTE ARTIGO NÃO CONTÉM ARQUIVOS ANEXOS! </span><br><br>";
            
        }
        
       // echo $this->Html->link('Baixar manual de colunista', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'getManual'), array('target'=>'_blank'));
        ?>
   <?php
    $imagem = $this->Html->image('voltar.png');
    echo $this->Html->link($imagem, array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'listPosts', $caderno), array('escape'=>false));
    ?>
</div>