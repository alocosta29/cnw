<h1 id='titleSeeArticle'><?php echo $artigo['titulo'] ;?></h1>
  <?php 
    echo $this->Html->script(array('PublicLayout.highlight.pack.js'));
    echo $this->Html->css('PublicLayout.styles/darcula.css'); 
    ?>
<script>hljs.initHighlightingOnLoad();</script>
<hr>
<span class='detailsArticle'>
<?php echo $this->Complement->getDateArticle($artigo['data_publicacao']); ?>, por 
<?php echo $this->Complement->linkCol($colunista['apelido'], $colunista['alias'], 'nameColArticle') ;?>
</span>
<hr>
<p style='padding-top: 1.5em; '>
<?php echo $artigo['texto']; ?>
</p>

<?php echo $this->element('viewExtras'); ?>
<br>

<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
    
    <?php if(true == false): ?>
        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
        <a class="a2a_button_facebook_messenger"></a>
        <a class="a2a_button_skype"></a> 
    <?php endif; ?>
        
        <a class="a2a_button_facebook"></a>
        <a class="a2a_button_linkedin"></a>
        <a class="a2a_button_twitter"></a>
        <a class="a2a_button_google_plus"></a>
        <a class="a2a_button_whatsapp"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->

<?php 

echo $this->element('mailCapture');
echo $this->element('PublicLayout.disqus'); ?>