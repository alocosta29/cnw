<?php echo $this->Html->css(array('Layout.publicLayout/paginacao.css')); ?>
<div class="paging" style="width: 100%; float: left; margin-top: 30px; ">
	<?php
	
	if($page > 1 ){
	    $previousPage = $page-1;
	}else{
	    $previousPage = false;
	}
    
    
	
	if($page < $numberPages){
	    $nextPage = $page + 1;
	}else{
	    $nextPage = false;
	}
 
    if($previousPage){
     $anterior = $this->Html->link('<< Anterior', array('plugin'=>false, 'controller'=>'public', 'action'=>'abrirPasta', $id, 'page:'.$previousPage));   
        
    }else{
      $anterior =  '<span class="pn_disabled"><< Anterior</span>';
    }
    
    if($nextPage){
     $proximo = $this->Html->link('Próximo >>', array('plugin'=>false, 'controller'=>'public', 'action'=>'abrirPasta', $id, 'page:'.$nextPage));   
        
    }else{
      $proximo =  '<span class="pn_disabled">Próximo >></span>';
    }
    
	echo $anterior.' ';
    $i=1;
   while($i<=$numberPages){
      
      if($i == $page){
          echo '<span class="current">'.$i.'</span>';
          
      } else{
          echo $this->Html->link($i, array('plugin'=>false, 'controller'=>'public', 'action'=>'abrirPasta', $id, 'page:'.$i), array('escape'=>false)); 
      }  
       
       
       
       
       $i++;
   }
    
    
    
    
    echo ' '.$proximo;

	
	
		/*echo $this->Paginator->prev('< ' . __('anterior '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | '));
		echo $this->Paginator->next(__(' próximo') . ' >', array(), null, array('class' => 'next disabled'));*/
	?>
	</div>