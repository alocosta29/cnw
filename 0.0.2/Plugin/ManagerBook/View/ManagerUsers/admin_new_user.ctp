
 <?php if(!empty($user)) :?>
    

    
    <?php 

   echo '<img src="data:image/jpeg;base64,'.base64_encode($user['User']['avatar']).'" width="290" height="290"/>'; ?>
    
    
    <?php endif; ?>