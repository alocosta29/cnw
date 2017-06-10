<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->element('headTags'); ?>
     

            <?php
                    //echo $this->Html->meta('Layout.sgpLayout/favicon.png');
                    echo $this->Html->css(array( 'PublicLayout.estilo.css', 'PublicLayout.menu.css'));
                    echo $this->Html->script(array('jquery-3.1.0.min', 'PublicLayout.scriptmenu'));
                    echo $scripts_for_layout;
                    //$url_corrigida = HOST_REAL.'webroot/js/';
            ?>
            <?php echo $this->Element('analitycs'); ?>  
</head>
   
    
  <body>
      <?php $color = '#c02230';
    if(!empty($selectColor)){
        $color = $selectColor;
    }
   
    ?>
      
  <div class="geral">
      
      <header class="main" style = "background-color: <?php echo $color; ?>;" id="header">
          <div class="content_header">
              <?php echo $this->Element('PublicLayout.menuLogo'); ?>
          </div>
      </header>
      
    
          <?php echo $this->Element('mosaic'); ?>
          <section class="content">
              <?php echo $this->Element('crumb'); ?>
              <section class="contentMain">
                   <?php echo $content_for_layout;  ?>
              </section>   
              <section class="sidebar">
              <?php echo $this->element('PublicLayout.sidebar'); ?>
              </section>
          </section>
          

          
 
       <div style="clear: both; "></div>
   
<?php 
//echo $this->element('PublicLayout.footer01'); 
 //echo $this->element('PublicLayout.footer02');
 echo $this->element('PublicLayout.footer03');
?>
          

  </div>
  </body>
</html>	
