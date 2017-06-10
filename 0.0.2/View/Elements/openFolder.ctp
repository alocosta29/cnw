<?php 
if(!empty($listItens)):
    
    $image = $this->Html->image('folder.png');
    $imageC = $this->Html->image('folderC.png');
    $fileIcon = $this->html->image('file.png');
foreach($listItens as $list): 
?>


<div class="categorie_download">
      <?php
   
      if($list['type'] == 'folder')
      {
        
        if($list['isprotected'] == 'Y'){
           echo $this->Html->link($imageC, array('plugin'=>false, 'controller'=>'public', 'action'=>'abrirPasta', 'admin'=>false,  $this->Complement->cryptDecrypt($list['id'], true)), array('escape'=>false)); 
        }else{
            echo $this->Html->link($image, array('plugin'=>false, 'controller'=>'public', 'action'=>'abrirPasta', 'admin'=>false,  $this->Complement->cryptDecrypt($list['id'], true)), array('escape'=>false));
        }
    ?><br>
    <?php echo $list['nome']; 
    
      }else{
          
          
         echo $this->Html->link($fileIcon, array('controller' => 'download', 'action' => 'get', $this->Complement->cryptDecrypt($list['id'], true)), array('escape' => false, 'target'=>'blank'));
     echo '<br>'.$list['descricao']; 
          
    ?>
    
<?php } ?>
</div>














<?php endforeach; 

endif; 
?>