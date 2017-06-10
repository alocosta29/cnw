<?php if(!empty($anuncio_sidebar)): ?>
<ul id = "listAds">
<?php foreach($anuncio_sidebar as $anuncio): ?>
    <li><?php 
    
    $image = $this->Html->image('img_ads/'.$anuncio['user_id'].'/'.$anuncio['imagem'], array('style'=>'max-width: 100%; '));
    
    echo $this->Html->link($image, $anuncio['link'], array('escape'=>false, 'target'=>'_blank')); ?>
        
        
    </li>
    
    
<?php endforeach; ?>
</ul>
<?php endif; ?>

