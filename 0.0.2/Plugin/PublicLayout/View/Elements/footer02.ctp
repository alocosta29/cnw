
<script type="text/javascript">
jQuery(document).ready(function($) { 
    $(".scroll").click(function(event){        
        event.preventDefault();
        $('html,body').animate({scrollTop:$(this.hash).offset().top}, 800);
   });
});
</script>
<div id="footer" >
<div class="prev-footer" >
    <div class="wrap-footer">
      <div id="prev-left-footer">
          <h2>O PROJETO</h2>
          Com conteúdo especializado nas áreas de tecnologia e gestão empresarial, o portal Crescer na Web nasceu com o propósito de alavancar carreiras, negócios e oportunidades.
          
      </div>
        <div id="prev-center-footer">
            <h2>MENU</h2>
            <ul id="menu-footer">
                <li><?php echo $this->Html->link('Página inicial', array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false)); ?> </li>
                <li><?php echo $this->Html->link('A empresa', array('plugin'=>false, 'controller'=>'public', 'action'=>'empresa')); ?></li>
                <li><?php echo $this->Html->link('Colunistas', array('plugin'=>false, 'controller'=>false, 'action'=>'colunistas')); ?></li>
                <li><?php echo $this->Html->link('Contato', array('plugin'=>false, 'controller'=>'public', 'action'=>'contato')); ?></li>
            </ul>
        </div> 
        <div id="prev-social-footer">
            <?php $twitter = $this->Html->image('twitter_color.png', array('class'=>'rede-footer'));
            $face = $this->Html->image('face_color.png', array('class'=>'rede-footer'));
            ?>
            <h2>SIGA-NOS</h2>
        <ul id = "redes-sociais-footer">
        <li>
            <?php 
                  echo $this->Html->link($face, 'https://facebook.com/crescernaweb', array('escape'=>false, 'target'=>'_blank'));
            ?>
        </li>
        <li>
            <?php 
            echo $this->Html->link($twitter, 'https://twitter.com/crescerweb', array('escape'=>false, 'target'=>'_blank'));
            ?>
        
        </li>
     </ul>   
        </div>    
        
         <div id="prev-final-footer">
        
             
            
             
             
   <?php if(true == false): ?>          
                   
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
             
        
<div class="fb-page" data-href="https://www.facebook.com/crescernaweb/" data-width="300" data-height="160" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/crescernaweb/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/crescernaweb/">Crescer na Web</a></blockquote></div>         
   <?php endif; ?>          
             
             
          
             
        </div>
        
        
        
        
        
    </div>
</div>
<div class="after-footer" >
<div class="wrap-footer">
     <div id="left-footer">
                  © Copyright 2016 - Todos os direitos reservados
              </div>
     <div id="right-footer" style="text-align: right;">
                 <a href="#header" class="scroll"><?php echo $this->Html->image('seta.png'); ?></a>
              </div>
</div>
</div>
     </div>