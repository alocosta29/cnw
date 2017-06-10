<nav class="menu">
    <ul class="active" id="listMenu" >
        <li class="current-item"><?php echo $this->Html->link('Home', array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false)); ?></li>
        <li><?php echo $this->Html->link('A empresa', array('plugin'=>false, 'controller'=>'public', 'action'=>'empresa', 'admin'=>false))?></li>
        <li><?php echo $this->Html->link('Colunistas', array('plugin'=>false, 'controller'=>'colunistas', 'action'=>'index', 'admin'=>false))?></li>
        <li><?php echo $this->Html->link('Seja um(a) colunista', array('plugin'=>false, 'controller'=>'public', 'action'=>'colunista', 'admin'=>false))?></li>
        <li><?php echo $this->Html->link('Contato', array('plugin'=>false, 'controller'=>'public', 'action'=>'contato', 'admin'=>false))?></li>
    </ul>
<a class="toggle-nav" href="#">&#9776;</a>
<h1 class="logo">
<?php 
$logo = $this->Html->image('PublicLayout.logo.png');
echo $this->Html->link($logo, array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false), array('escape'=>false)); ?>
</h1>


</nav>
<h1 class="logo2">
<?php 
$logo = $this->Html->image('PublicLayout.logo.png');
echo $this->Html->link($logo, array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false), array('escape'=>false)); ?>
</h1>
<div class="widget_header">
    <ul id = "redes-sociais">
        <li>
            <?php $face = $this->Html->image('PublicLayout.facebook.png'); 
                  echo $this->Html->link($face, 'https://facebook.com/crescernaweb', array('escape'=>false, 'target'=>'_blank'));
            ?>
        </li>
        <li>
            <?php $twitter = $this->Html->image('PublicLayout.twitter.png');
            echo $this->Html->link($twitter, 'https://twitter.com/crescerweb', array('escape'=>false, 'target'=>'_blank'));
            ?>
        
        </li>
     </ul>   
        <div class="search-box">
            <?php echo $this->element('PublicLayout.search'); ?>
        </div>    
</div>