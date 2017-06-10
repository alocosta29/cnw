<h1>Nossos colunistas</h1>
<?php foreach($Colunistas as $col): ?>

<article class="article-list-colunistas">
    <div class="colunistas-avatar">
        <?php 
             echo $this->Avatar->getAuthorImage(
                         array(
                                 'person_id'=>$col['Colunista']['person_id'], 
                                 'image'=>$col['Avatar']['avatar'],
                                 'idAvatar' => $col['Avatar']['id']
                             ));
        ?>
    </div>
    <h1 class="name-colunista">
            <?php echo $this->Html->link($col['Colunista']['apelido'], array('plugin'=>false, 'controller'=>'colunistas', 'action'=>'colunista','admin'=>false , $col['Colunista']['alias'] )); ?>
    </h1>
   <p>
       <?php echo $this->Html->link($col['Colunista']['resumo'], array('plugin'=>false, 'controller'=>'colunistas', 'action'=>'colunista','admin'=>false , $col['Colunista']['alias'] )); ?>
  </p>
</article>

<?php endforeach; ?>

<span style="font-size: 0.7em; ">
<?php echo $this->element('paginacao'); ?>
</span>


