 <?php if($this->Session->read('Auth.User.specialAccess.book_col')): ?>

    <h2 style="text-align: center; ">ESCREVER</h2>
    <?php foreach($this->Session->read('Auth.User.specialAccess.book_col') as $col):
            ?>
        <ul>
           <li><?php echo  $this->Html->link($this->ReturnData->getBook($col), array('plugin'=>'articles','controller'=>'articles' , 'action'=>'index', $col), array('escape'=>false)); ?></li>
        </ul>
         <?php 
            endforeach; ?>
    <?php
    endif; ?>

    <?php if($this->Session->read('Auth.User.specialAccess.book_adm')): ?>
    <h2 style="text-align: center; ">MODERAR</h2>
    <?php foreach($this->Session->read('Auth.User.specialAccess.book_adm') as $adm):
            ?>
        <ul>
           <li><?php echo $this->Html->link($this->ReturnData->getBook($adm), array('plugin'=>'manager_book','controller'=>'managerBooks' , 'action'=>'index', $adm), array('escape'=>false)); ?></li>
        </ul>
         <?php 
            endforeach; ?>
    <?php
    endif; 
        
    if($this->Session->read('Auth.User.specialAccess.ads_adm')): ?>
    <h2 style="text-align: center; ">MODERAR ANÚNCIOS</h2>
    <?php foreach($this->Session->read('Auth.User.specialAccess.ads_adm') as $ads):
            ?>
        <ul>
           <li><?php echo  $this->Html->link($this->ReturnData->getBook($ads), array('plugin'=>'manager_ads','controller'=>'managerAds' , 'action'=>'index', $ads), array('escape'=>false)); ?></li>
        </ul>
         <?php 
            endforeach; ?>
    <?php
    endif; 
    
      if($this->Session->read('Auth.User.specialAccess.ads_pub')): ?>
    <h2 style="text-align: center; ">CRIAR ANÚNCIOS</h2>
    <?php foreach($this->Session->read('Auth.User.specialAccess.ads_pub') as $cad):
            ?>
        <ul>
           <li><?php echo  $this->Html->link($this->ReturnData->getBook($cad), array('plugin'=>'create_ads','controller'=>'ads' , 'action'=>'index', $cad), array('escape'=>false)); ?></li>
        </ul>
         <?php 
            endforeach; ?>
    <?php
    endif;  

    ?>