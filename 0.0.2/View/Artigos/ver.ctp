  <?php 
    echo $this->Html->script(array('PublicLayout.highlight.pack.js'));
    echo $this->Html->css('PublicLayout.styles/darcula.css'); 
    ?>
<script>hljs.initHighlightingOnLoad();</script>
<span class="article-content">
    <h1><?php echo $title_for_layout; ?></h1>
    <span class="dateArticle">Postado em: <strong><?php echo $this->Time->format('d', $dateArticle); ?> de 
        <?php echo $this->Complement->getMonth($this->Time->format('m', $dateArticle)); ?> de <?php echo $this->Time->format('Y', $dateArticle); ?>
    </strong></span><br><br>
    
    <?php echo $content; ?>
    <br><br>
    
        <!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_orkut"></a>
</div>
<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
    </span>

    <span class="article-colum">
        <span class="article-colum-title">Artigos</span>
    <br><br>
    
        <?php if(!empty($articles)): ?>   
        <?php foreach($articles as $article): ?>    
          <?php echo $this->Html->link($article['titulo'], array('plugin'=>false, 'controller'=>'artigos', 'action'=>'ver', 'admin'=>false, $article['slug'])); ?>
            <br><?php echo $this->Complement->getMonth($this->Time->format('m', $article['data'])); ?> <?php echo  $this->Time->format('Y', $article['data']); ?> 
            <br><br>
        <?php endforeach; ?>     
        <?php endif; ?>       
       <?php echo $this->Html->link('Listar todos', array('plugin'=>false, 'controller'=>'artigos', 'action'=>'index')); ?>
    </span>