
<?php if(!empty($colunista)): ?>
    <div class = "sidebar_autor_artigo">
    <?php 
            echo $this->Avatar->getAvatar(
                    array(
                            'person_id'=>$colunista['person_id'], 
                            'image'=>$avatar['avatar'],
                            'idAvatar' => $avatar['id']
                        ));
            ?>
        <hr>
        <span style='color: <?php echo $selectColor; ?>; font-weight: bold;font-size: 1.4em; '>
        <?php echo $colunista['apelido']; ?>
            </span>
        <hr>
        <?php echo $colunista['resumo']; ?><br>
     
        <?php echo $this->Html->link('Saiba mais aqui →', array('plugin'=>false, 'controller'=>false, 'action'=>'colunista', $colunista['alias'], 'admin'=>false)); ?>
    </div>    
<?php endif; ?>

<?php if(!empty($cadernos)){ ?>
        <ul id = "listCadernos">
            <?php  foreach($cadernos as $cad): ?>
                <li style="background: <?php echo $cad['cor']; ?>"><?php echo $this->Html->link($cad['nome'], array('plugin'=>false, 'controller'=>'public', 'action'=>'caderno', $cad['alias'], 'admin'=>false)); ?></li>
            <?php endforeach; ?>
        </ul>
<?php 
    echo $this->Element('PublicLayout.sidebarBanners'); 

}else{ 
    echo $this->Element('PublicLayout.sidebarBanners'); 
        if(!empty($categorias)){ ?>
        <ul id = "listCategorias">
            <?php foreach($categorias as $categoria): ?>
            <?php if(!empty($listCategories) and in_array($categoria['id'], $listCategories)){ ?>
                 <li style="background: <?php echo $selectColor; ?>; color: #fff;  "><?php echo $this->Html->link($categoria['nome'], array('plugin'=>false, 'controller'=>'public', 'action'=>'categoria', $categoria['alias'], 'admin'=>false), array('style'=>'color: #fff;')); ?></li>
                
            <?php }else{ ?>  
                
             <li style="background: #ececec; "><?php echo $this->Html->link($categoria['nome'], array('plugin'=>false, 'controller'=>'public', 'action'=>'categoria', $categoria['alias'], 'admin'=>false), array('style'=>'color: #414141;')); ?></li>
            <?php } ?>
  <?php endforeach; ?>
        </ul>
        <?php } ?>     
<?php 



            } ?>  

    
    
