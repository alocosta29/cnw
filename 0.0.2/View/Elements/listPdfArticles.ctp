<?php

echo $this->Html->css(array( 'PublicLayout.estilo.css'));
foreach($artigos as $artigo):
    ?>
<article>
   <?php 
              
                   $image = $this->Complement->getUrlImage(array('folder'=> $artigo['Artigo']['user_id'], 'img'=>$artigo['Artigo']['imagem']));
                   //echo $image;
                   $div = '<a href="'.HOST_REAL.'public'.DS.'baixarPdf'.DS.$this->Complement->crypt($artigo['Artigo']['id'], 'cnw2017', true).'" title="Baixar artigo em PDF"><div class= "figure" style="background-image:url('.$image.'); background-size: 100% 100%; background-repeat:no-repeat;  " >'.$this->Html->image('download_pdf.png', array('style'=> 'width: 30%; ')).'</div></a>';
                   ?>
                   <?php echo $div; ?>
                   <section class="listArticle">
                      <h1 id = "titleArticle">
                      
                      <?php echo $artigo['Artigo']['titulo'];?>
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
