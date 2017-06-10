<?php 
if(!empty($extras)){
            foreach ($extras as $extra) { ?>
            <article>
               <?php 
                            $nameCad = false;
                              $image = $this->Complement->getUrlImageExtra(array('img'=>$this->Complement->getIconExtra($extra['Extra']['tipo_arquivo'])));
                              //$image = WWW_ROOT.'img'.DS.'extra_icons'.DS.$this->Complement->getIconExtra($extra['Extra']['tipo_arquivo']);
                              // echo $this->Complement->getIconExtra($extra['Extra']['tipo_arquivo']);
                               #echo $image;
                               $div = '<div class= "figure" style="background-image:url('.$image.'); background-size: 100% ; background-repeat:no-repeat;  " >'.$nameCad.'</div>';
                               ?>
                               <?php echo $div; ?>
                               <section class="listArticle">
                                  <h1 id = "titleArticle">

                                  <?php echo $this->Html->link($extra['Extra']['nome'], array('plugin'=>false, 'controller'=>'public', 'action'=>'getFile', $extra['Extra']['arquivo'], $extra['Extra']['tipo_arquivo']), array('target'=>'_blank')) ;?>
                                  </h1>
                                  <p>Disponibilizado por <?php             
                                  if(!empty($extra['Colunista']['apelido']) and !empty($extra['Colunista']['alias'])){
                                      echo $this->Complement->linkCol($extra['Colunista']['apelido'], $extra['Colunista']['alias']) ;
                                  }elseif(!empty($extra['Extra']['person_id'])){
                                      echo $this->Complement->linkColSearch(array('person_id'=>$extra['Extra']['person_id'])) ;
                                  }

                                  ?> | <?php echo $this->Complement->getDateArticle($extra['Extra']['created']); ?></p>
                               <?php echo $extra['Extra']['descricao'] ;?>
                             </section>    
            </article> 
             <?php   }  ?>

  <?php }else{ ?>
    
<span style="font-weight: bold; color: #ff0000; font-size: 1.2em; margin-top: 1em; ">Pedimos desculpa, ainda não disponibilizamos materiais extras para este caderno! :(</span>

  <?php } ?>
