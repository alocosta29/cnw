<?php 

if($this->Session->read('Auth.User.specialAccess')): ?>
<li style="position: static;" class=""><a class="ajxsub" href="#">Cadernos</a>
    <ul style="display: none;">	
        <?php if($this->Session->read('Auth.User.specialAccess.book_adm')): ?>
        <li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Moderar</a>
                        <ul style="display: none;">
                            <?php 
                            $cadernosAdmin = $this->Session->read('Auth.User.specialAccess.book_adm');
                            foreach($cadernosAdmin as $admin): ?>
                                <li style="position: static;" class=""><?php echo $this->Html->link($this->ReturnData->getNameBook($admin), array('plugin'=>'manager_book', 'controller'=>'managerBooks', 'action'=>'index', $admin)); ?></li>
                        <?php endforeach ;?>
                        </ul>	
                </li>
        <?php endif; ?>
        
        <?php if($this->Session->read('Auth.User.specialAccess.book_col')): ?>
        <li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Escrever</a>
                        <ul style="display: none;">
                            <?php 
                            $cadernosPost = $this->Session->read('Auth.User.specialAccess.book_col');
                            foreach($cadernosPost as $post): ?>
                                <li style="position: static;" class=""><?php echo $this->Html->link($this->ReturnData->getNameBook($post), array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'index', $post)); ?></li>
                        <?php endforeach ;?>
                        </ul>	
                </li>
        <?php endif; ?>
    
        <?php if($this->Session->read('Auth.User.specialAccess.ads_adm')): ?>
        <li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Moderar anúncios</a>
                        <ul style="display: none;">
                            <?php 
                            $cadernos = $this->Session->read('Auth.User.specialAccess.ads_adm');
                            foreach($cadernos as $post): ?>
                                <li style="position: static;" class=""><?php echo $this->Html->link($this->ReturnData->getNameBook($post), array('plugin'=>'manager_ads', 'controller'=>'managerAds', 'action'=>'index', $post)); ?></li>
                        <?php endforeach ;?>
                        </ul>	
                </li>
        <?php endif; ?>       
                
       
               <?php if($this->Session->read('Auth.User.specialAccess.ads_pub')): ?>
        <li style="position: static;" class="sfirst"><a class="ajxsub" href="#">Criar anúncios</a>
                        <ul style="display: none;">
                            <?php 
                            $cadernos = $this->Session->read('Auth.User.specialAccess.ads_pub');
                            foreach($cadernos as $post): ?>
                                <li style="position: static;" class=""><?php echo $this->Html->link($this->ReturnData->getNameBook($post), array('plugin'=>'create_ads', 'controller'=>'ads', 'action'=>'index', $post)); ?></li>
                        <?php endforeach ;?>
                        </ul>	
                </li>
        <?php endif; ?>        
                
                
                
                
                
                
    
    </ul>
</li>
<?php endif; ?>
