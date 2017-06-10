<?php echo $this->Html->css(array( 'PublicLayout.mail_capture.css')); ?>
<div class="mail-cap">
    <h4 class="mail-cap-title">FIQUE POR DENTRO</h4>
    <div class="mail-cap-text">
        Coloque aqui o seu melhor email para receber 
                 gratuitamente as atualizações do caderno de <span style="color: <?php echo $caderno['cor'];  ?>; font-weight: bold; "><?php echo $caderno['nome'];  ?></span>!
          <span class="mail-cap-boxmail" >
                     <form action="<?php echo $caderno['url_form'];  ?>" method="post" id="mail_cap" name="mail_cap" class="validate" target="_blank" novalidate>
                     <input type="email" name="EMAIL" placeholder = "Insira seu e-mail">
                     <input type="submit" value="Quero receber!"  style="background-color: <?php echo $caderno['cor'];  ?>; ">  
                </span>
        </div>
    
    
 </div>
