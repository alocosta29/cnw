<?php if(!empty($caderno)): ?>
    <div class ="faixaCaderno">
        <div class="conteudoFaixaCaderno">
           <h3> Tudo sobre <span style="color: <?php echo $caderno['cor'];  ?>; font-weight: bold; text-transform: lowercase; font-size: 1.3em; "><?php echo $caderno['nome']; ?></span></h3>
           <div class="formSignature">
                <span  class="textMail">
                 Coloque o seu email aqui para receber 
                 gratuitamente as atualizações de <span style="color: <?php echo $caderno['cor'];  ?>; "><?php echo $caderno['nome'];  ?></span>!
                </span>
                <span class="boxmail" >
                     <form action="<?php echo $caderno['url_post_form'];  ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                     <input type="email" name="EMAIL" placeholder = "Insira seu e-mail">
                     <input type="submit" value="Quero receber!"  name="subscribe" id="mc-embedded-subscribe" style="background-color: <?php echo $caderno['cor'];  ?>; ">  
                </span>
               <?php echo $this->Form->end(); ?>
             </div>   
        </div>   
    </div>
<?php endif; ?>

