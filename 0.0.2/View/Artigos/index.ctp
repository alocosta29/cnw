<span class="article-content">
    <h1><?php echo $title_for_layout; ?></h1>

<?php echo $this->element('listPosts'); ?>






    </span>

    <span class="article-colum">
        <span class="article-colum-title">Artigos</span>
    <br><br>
    
        <?php if(!empty($articles)): ?>   
        <?php foreach($articles as $article): ?>    
          <?php 
                    echo $this->Html->link($article['titulo'], array('plugin'=>false, 'controller'=>'artigos', 'action'=>'ver', 'admin'=>false, $article['slug'])); ?>
                   <br> <?php echo $this->Complement->getMonth($this->Time->format('m', $article['data'])); ?> <?php echo  $this->Time->format('Y', $article['data']); ?>  
            
            <br><br>
        <?php endforeach; ?>     
        <?php endif; ?>       
    </span>