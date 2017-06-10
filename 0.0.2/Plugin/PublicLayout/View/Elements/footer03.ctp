<div id="footer" >
        <!-- parte INICIAL do rodapé -->
        <div class="prev-footer" >
             <div class="wrap-footer">
                <div id="prev-left-footer">
                    <?php echo $this->Html->image('logoColorClara.png'); ?>    
                </div>    
                 <div id="prev-social-footer">
                      <?php $twitter = $this->Html->image('twitter_footer.png', array('class'=>'rede-footer'));
            $face = $this->Html->image('face_footer.png', array('class'=>'rede-footer'));
            ?>
                     <ul id = "redes-sociais-footer">
                         <li><?php echo $this->Html->link($twitter, 'https://twitter.com/crescerweb', array('escape'=>false, 'target'=>'_blank')); ?></li>
                         <li><?php echo $this->Html->link($face, 'https://facebook.com/crescernaweb', array('escape'=>false, 'target'=>'_blank')); ?></li>
                     </ul>
                     
                 </div>
            </div>
        </div>
        <!-- fim da parte INICIAL do rodapé -->
    
        <!-- parte FINAL do rodapé -->
         <div class="after-footer" >
                 <div class="wrap-footer" style="text-align: center;">

                                  <span class="wrap-footer-font"> © Copyright 2017 Crescer na Web - Todos os direitos reservados</span>
                 </div>
         </div>
         <!-- fim da parte FINAL do rodapé -->
</div>