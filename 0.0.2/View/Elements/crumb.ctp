<?php
$Home = $this->Html->link('Home', array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false)); 
$QuemSomos = $this->Html->link('A empresa', array('plugin'=>false, 'controller'=>'public', 'action'=>'empresa')); 
$Colunistas = $this->Html->link('Colunistas', array('plugin'=>false, 'controller'=>'colunistas', 'action'=>'index'));
$Contato = $this->Html->link('Contato', array('plugin'=>false, 'controller'=>'public', 'action'=>'contato'));



$color = '#c02230';
if(!empty($selectColor)){
   $color = $selectColor; 
}
$crumb = 'Você está em '.$Home;
$isCrumb = false;
$pass = false;
if(!empty($this->params['pass'][0])){
    $pass = $this->params['pass'][0];
}
$controller = $this->params['controller'];
$action = $this->action;
if($controller == 'public')
{
    switch ($action) {
        case 'empresa':
            $isCrumb = true;
            $crumb .= " > <span style = 'color: ".$color.";  font-weight: bold; '>A empresa</span>";
            break;
        case 'contato':
            $isCrumb = true;
            $crumb .= " > <span style = 'color: ".$color.";  font-weight: bold; '>Contato</span>";
            break;
        
        case 'caderno':
            $isCrumb = true;
            $crumb .= " > <span style = 'color: ".$color.";  font-weight: bold; '>".$crumbTitle."</span>";
            break;
        
           case 'categoria':
            $isCrumb = true;
            $Caderno = $this->Html->link($caderno['nome'], array('plugin'=>false, 'controller'=>'public', 'action'=>'caderno', 'admin'=>false, $caderno['alias'])); 
            $crumb .= ' > '.$Caderno." > <span style = 'color: ".$color.";  font-weight: bold; '>".$crumbTitle."</span>";
            break;
        
          case 'artigo':
            $isCrumb = true;
            $Caderno = $this->Html->link($caderno['nome'], array('plugin'=>false, 'controller'=>'public', 'action'=>'caderno', 'admin'=>false, $caderno['alias'])); 
           $crumb .= ' > '.$Caderno." > <span style = 'color: ".$color.";  font-weight: bold; '>".$this->Complement->limitarTexto($crumbTitle, 40, false)."</span>";
           
           # $crumb .= ' > '.$Caderno." > <span style = 'color: ".$color.";  font-weight: bold; '>".$this->Complement->limitarTexto($teste, 20, false)."</span>";
            
            break;
        
        
        
           case 'searchPosts':
            $isCrumb = true;
            $crumb .= " > <span style = 'color: ".$color."; font-weight: bold; '>Pesquisar artigos</span>";
            break;
           
          case 'download':
           $isCrumb = true;
            $crumb .= " > <span style = 'color: ".$color.";  font-weight: bold; '>Materiais extras do caderno de ".$crumbTitle."</span>";
            break;
        
        default:
            break;
    }
    
    
    
}elseif($controller == 'colunistas'){
    
    switch ($action) {
        case 'index':
            $isCrumb = true;
            $crumb .= " > <span style = 'color: ".$color.";  font-weight: bold; '>Colunistas</span>";
            break;
        case 'colunista':
            $isCrumb = true;
            $crumb .= ' > '.$Colunistas." > <span style = 'color: ".$color.";  font-weight: bold; '>".$crumbTitle."</span>";
            break;
        
  
        
        
        
        
        default:
            break;
    }
    
}


if($isCrumb){
    echo '<section class="crumb">'.$crumb.'</section>';
}


?>

    



