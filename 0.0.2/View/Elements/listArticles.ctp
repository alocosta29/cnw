<?php
echo $this->Html->css(array( 'PublicLayout.estilo.css'));
foreach($artigos as $artigo):
    ?>
<article>
   <?php 
                   if(in_array($this->action, array('caderno'))){
                      $nameCad = false;
                   }else{
                      $nameCad = '<h3 style="background-color:'.$artigo['Caderno']['cor'].' ">'.$artigo['Caderno']['nome'].'</h3>';  
                   }
                   $image = $this->Complement->getUrlImage(array('folder'=> $artigo['Artigo']['user_id'], 'img'=>$artigo['Artigo']['imagem']));
                   //echo $image;
                   $div = '<div class= "figure" style="background-image:url('.$image.'); background-size: 100% 100%; background-repeat:no-repeat;  " >'.$nameCad.'</div>';
                   ?>
                   <?php echo $div; ?>
                   <section class="listArticle">
                      <h1 id = "titleArticle">
                      
                      <?php echo $this->Html->link($artigo['Artigo']['titulo'], array('plugin'=>false, 'controller'=>'public', 'action'=>'artigo', $artigo['Artigo']['id'], $artigo['Artigo']['alias'])) ;?>
                      </h1>
                      <p>Por <?php             
                      if(!empty($artigo['Colunista']['apelido']) and !empty($artigo['Colunista']['alias'])){
                          echo $this->Complement->linkCol($artigo['Colunista']['apelido'], $artigo['Colunista']['alias']) ;
                      }elseif(!empty($artigo['Artigo']['person_id'])){
                          echo $this->Complement->linkColSearch(array('person_id'=>$artigo['Artigo']['person_id'])) ;
                      }
                      
                      ?> | <?php echo $this->Complement->getDateArticle($artigo['Artigo']['data_publicacao']); ?></p>
                   <?php echo $artigo['Artigo']['resumo'] ;?>
                 </section>    
</article>



<?php endforeach; ?>