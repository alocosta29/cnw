<div class="menu_80">
<?php 
$action = $this->request->params['action'];
    if(strstr($action, 'display')) {
    $home = $this->Html->image('Layout.publicLayout/menu/home_h.png');
    echo $this->Html->link($home, array('plugin'=>false, 'controller'=>'pages', 'action'=>'index', 'admin'=>false), array('escape' => false)); 
    }else{  
    echo $this->Html->link('', array('plugin'=>false, 'controller'=>'pages', 'action'=>'index', 'admin'=>false), array('id'=>'efeito_home')); 
    }

?>
</div>

<div class="menu_90">
<?php 
  if(strstr($action, 'empresa')) {
    $empresa = $this->Html->image('Layout.publicLayout/menu/empresa_h.png');
    echo $this->Html->link($empresa, array('plugin'=>false, 'controller'=>'public', 'action'=>'empresa', 'admin'=>false), array('escape' => false)); 
    }else{  
    echo $this->Html->link('', array('plugin'=>false, 'controller'=>'public', 'action'=>'empresa', 'admin'=>false), array('id'=>'efeito_empresa'));
    }
 ?>
</div>

<div class="menu_90">
<?php 
    if(strstr($action, 'servicos')) {
    $servico = $this->Html->image('Layout.publicLayout/menu/servicos_h.png');
    echo $this->Html->link($servico, array('plugin'=>false, 'controller'=>'public', 'action'=>'servicos', 'admin'=>false), array('escape' => false)); 
    }else{  
    echo $this->Html->link('', array('plugin'=>false, 'controller'=>'public', 'action'=>'servicos', 'admin'=>false), array('id'=>'efeito_servicos'));
    }
 ?>
</div>

<div class="menu_183">
<?php 
    if(strstr($action, 'trabalhos')) {
    $trabalho = $this->Html->image('Layout.publicLayout/menu/palestras_h.png');
    echo $this->Html->link($trabalho, array('plugin'=>false, 'controller'=>'public', 'action'=>'trabalhos', 'admin'=>false), array('escape' => false)); 
    }else{  
    echo $this->Html->link('', array('plugin'=>false, 'controller'=>'public', 'action'=>'trabalhos', 'admin'=>false), array('id'=>'efeito_palestras')); 
    }

?>
</div>

<div class="menu_90">
<?php 
   if(strstr($action, 'downloads') || strstr($action, 'abrirPasta')) {
    $download = $this->Html->image('Layout.publicLayout/menu/download_h.png');
    echo $this->Html->link($download, array('plugin'=>false, 'controller'=>'public', 'action'=>'downloads', 'admin'=>false), array('escape' => false)); 
    }else{  
    echo $this->Html->link('', array('plugin'=>false, 'controller'=>'public', 'action'=>'downloads', 'admin'=>false), array('id'=>'efeito_download'));
    }
 ?>
</div>

<div class="menu_80">
<?php 
   if(strstr($action, 'contato')) {
    $contato = $this->Html->image('Layout.publicLayout/menu/contato_h.png');
    echo $this->Html->link($contato, array('plugin'=>false, 'controller'=>'public', 'action'=>'contato', 'admin'=>false), array('escape' => false)); 
    }else{  
    echo $this->Html->link('', array('plugin'=>false, 'controller'=>'public', 'action'=>'contato', 'admin'=>false), array('id'=>'efeito_contato')); 
    }

?>
</div>
<?php if(true==false): ?>
<div class="menu_80"><a href="home.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image16','','img/menu/home_hover.png',1)"><img src="img/menu/home_link.png" alt="" width="80" height="110" id="Image16"></a></div>
<div class="menu_90"><a href="empresa.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image17','','img/menu/empresa_hover.png',1)"><img src="img/menu/empresa_link.png" alt="" width="90" height="110" id="Image17"></a></div>
<div class="menu_90"><a href="servicos.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','img/menu/servicos_hover.png',1)"><img src="img/menu/servicos_link.png" alt="" width="90" height="110" id="Image18"></a></div>
<div class="menu_183"><a href="palestras.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image19','','img/menu/palestras_hover.png',1)"><img src="img/menu/palestras_link.png" alt="" width="183" height="110" id="Image19"></a></div>
<div class="menu_90"><a href="download.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image20','','img/menu/download_hover.png',1)"><img src="img/menu/download_link.png" alt="" width="90" height="110" id="Image20"></a></div>
<div class="menu_80"><a href="contato.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image21','','img/menu/contato_hover.png',1)"><img src="img/menu/contato_link.png" alt="" width="80" height="110" id="Image21"></a></div>
<?php endif; ?>