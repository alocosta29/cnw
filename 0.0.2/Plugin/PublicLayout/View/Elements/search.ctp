<?php echo $this->Html->css(array('PublicLayout.styleSearch.css')); ?>            
    
   <?php echo $this->Form->create('Artigo', array('id'=>'search', 'url'=>array('plugin'=>false, 'controller'=>'public', 'action'=>'searchPosts'))); ?>
        <div id="label"><label for="search-terms" id="search-label">search</label></div>
        <div id="input"><input type="text" name="search-terms" id="search-terms" placeholder="Digite aqui..."></div>
   <?php echo $this->Form->end(); ?>

    <?php if(true == false): ?>
        <form id="search" action="#" method="post">
            <div id="label"><label for="search-terms" id="search-label">search</label></div>
            <div id="input"><input type="text" name="search-terms" id="search-terms" placeholder="Digite aqui..."></div>
        </form>
    <?php endif; ?>
    
<?php echo $this->Html->script(array('PublicLayout.classie.js', 'PublicLayout.search.js')); ?>