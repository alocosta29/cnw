<?php $action = $this->action; ?>    
<br>    
<ul>
        <li><?php echo $this->Html->link(__('Home'), array('plugin'=>'manager_ads', 'controller'=>'managerAds', 'action' => 'index', $caderno)); ?></li>
                
        <li id="titleButtons">ANÚNCIOS</li>
        <?php if($action <> 'admin_pendingAds'): ?>
        <li><?php echo $this->Html->link(__('Para análise'), array('plugin'=>'manager_ads', 'controller'=>'managerAds', 'action' => 'pendingAds', $caderno)); ?></li>
        <?php endif; ?>
       
        <?php if($action <> 'admin_authorizedAds'): ?>
        <li><?php echo $this->Html->link(__('Autorizados'), array('plugin'=>'manager_ads', 'controller'=>'managerAds', 'action' => 'authorizedAds', $caderno)); ?></li>
        <?php endif; ?>
        
        <?php if($action <> 'admin_reprovedAds'): ?>
        <li><?php echo $this->Html->link(__('Enviados para revisão'), array('plugin'=>'manager_ads', 'controller'=>'managerAds', 'action' => 'reprovedAds', $caderno)); ?></li>
        <?php endif; ?>
        
</ul> 
<br>
<ul>
     <?php 
            if(!empty($idAd)): 
                if($ValidManagerAd->start($idAd, $caderno, 'publish')):
                        echo '<li>'.$this->Form->postLink(__('Aprovar anúncio'), array('plugin'=>'manager_ads', 'controller'=>'managerAds', 'action'=>'publish', $caderno, $idAd), null, __(''
                                                                 . 'ATENÇÃO! Após a conclusão desta operação, o anúncio será exibido no portal. Tem certeza que deseja aprovar este anúncio? ', null)).'<li>';                
                endif;

                if($ValidManagerAd->start($idAd, $caderno, 'reprove') and $action <> 'admin_reproveAds'):   
                        echo '<li>'.$this->Html->link(__('Enviar para revisão'), array('plugin'=>'manager_ads', 'controller'=>'managerAds', 'action' => 'reproveAds', $caderno, $idAd)).'</li>';
               endif;   
            endif;    
    ?>
</ul>