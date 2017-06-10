<br>    
<ul>
        <li><?php echo $this->Html->link(__('Home'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action' => 'index', $caderno)); ?></li>    
        <li id="titleButtons">ANÚNCIOS</li>
        <li><?php //echo $this->Html->link(__('Criar novo anúncio (video)'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action' => 'addAdVideo', $caderno)); ?></li>
        <li><?php echo $this->Html->link(__('Criar novo anúncio'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action' => 'add', $caderno)); ?></li>
        <li><?php //echo $this->Html->link(__('Listar anúncios (formato vídeo)'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action' => 'listVideoAds', $caderno)); ?></li>
        
        <li><?php echo $this->Html->link(__('Listar anúncios'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action' => 'list', $caderno)); ?></li>
</ul>   
<br>
<ul>
     <?php 
            if(!empty($idAd)): 
            
                if($this->action <> 'admin_view' and !empty($idAd)):
                        echo '<li>'.$this->Html->link('Visualizar anúncio', array('plugin'=>'create_ads', 'controller'=>'ads', 'action'=>'view', $caderno, $idAd)).'</li>'; 
                endif;

                if($ValidEditAd->start($idAd, $caderno, 'changeStatusCol', 'A')):   
                 echo '<li>'.$this->Form->postLink(__('Enviar para análise'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action'=>'changeStatus', $caderno, $idAd, 'A'), null, __(''
                                         . 'ATENÇÃO! Após a conclusão desta operação, não será mais possível editar o anúncio. Tem certeza que deseja enviar o anúncio para análise da moderação? ', null)).'<li>';
                endif;   

                if($ValidEditAd->start($idAd, $caderno, 'changeStatusCol', 'R')):   
                 echo '<li>'.$this->Form->postLink(__('Retornar para modo rescunho'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action'=>'changeStatus', $caderno, $idAd, 'R'), null, __(''
                                         . 'Tem certeza que deseja retornar o anúncio para modo rascunho? ', null)).'<li>';
                endif;  

                if($this->action <> 'admin_edit' and $ValidEditAd->start($idAd, $caderno, 'editAd')):
                            echo '<li>'.$this->Html->link('Editar anúncio', array('plugin'=>'create_ads', 'controller'=>'ads', 'action'=>'edit', $caderno, $idAd)).'</li>'; 
                endif;
                
                  if($ValidEditAd->start($idAd, $caderno, 'newReview')):
                       echo '<li>'.$this->Form->postLink(__('Criar revisão'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action'=>'newReview', $caderno, $idAd), null, __(''
                                         . 'Tem certeza que deseja criar uma nova revisão para anúncio?', null)).'<li>';
                endif;

                if($ValidEditAd->start($idAd, $caderno, 'deleteAd')):
                            echo '<li>'.$this->Form->postLink(__('Deletar anúncio'), array('plugin'=>'create_ads', 'controller'=>'ads', 'action'=>'delete', $caderno, $idAd), null, __(''
                                                . 'Tem certeza que deseja deletar o anúncio? ', null)).'<li>';
                endif;
                
            endif;    
    ?>
</ul>



        
        