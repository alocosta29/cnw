<?php if(!empty($postagens)): ?>
    
    
    <?php
    foreach($postagens as $post):
    echo '<span class="list-article">'.$this->Html->link($post['Postagen']['titulo'], 
    array('plugin'=>false, 'controller'=>'artigos', 'action'=>'ver', $post['Postagen']['slug'])).'</span>'.' |'.$this->Complement->getMonth($this->Time->format('m', $post['Postagen']['created'])).$this->Time->format('Y', $post['Postagen']['created']);
    echo '<br>'.$post['Postagen']['resumo'].'<br><br>';
    ?>
<?php endforeach; ?>
<span style="font-size: 0.7em; ">
<?php echo $this->element('paginacao'); ?>
</span>
<?php endif; ?>