<?php
  $socialImg = HOST_REAL.'img'.DS.'testeImg.png';
  if(!empty($imgDestak)){
     $socialImg = HOST_REAL.'img'.DS.$imgDestak;
  }
  $keywords = "crescer na web, tecnologia, marketing, gestão, empreendedorismo";
  if(!empty($pageKeywords)){
      $keywords = $pageKeywords;
  }  
  
  $title = 'Crescer na Web: Disseminando conhecimento que transforma vidas!';
    if(!empty($title_for_layout) and !in_array($title_for_layout, array('Home', 'Public'))){
        $title = $title_for_layout;
    }
    $descPage = "Conteúdo rico, simples e objetivo!";
    if(!empty($metaDesc)): 
    $descPage = $metaDesc;
    endif;
    $urlPage = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name = "description" content="<?php echo $descPage; ?>" />
<meta name="keywords" content="<?php echo $keywords; ?>"/>

<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:type" content="website"/> 
<meta property="og:url" content="<?php echo $urlPage; ?> "/>
<meta property="og:site_name" content="Crescer na Web"/>
<meta property="fb:admins" content="crescernaweb"/>  
<meta property="og:image" content="<?php echo $socialImg; ?>"/>

<meta name="twitter:description" content="<?php echo $descPage; ?>" />
<meta name="twitter:title" content="<?php echo $title; ?> " />
<meta name="twitter:url" content="<?php echo $urlPage; ?>" />
<meta name="twitter:image"content="<?php echo $socialImg; ?>" />

<title><?php echo $title; ?></title>
<?php echo $this->Html->meta('icon', $this->Html->url('/img/favicon.png'));; ?>
