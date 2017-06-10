<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Crescer na Web - Login de colunistas e moderadores</title>
    <?php echo $this->Html->css('LoginLayout.style'); ?>
    
  </head>

  <body>
  <?php if(!$this->Session->read('Auth.User.id')): ?>

      
      
      <div class="login-form">
         <h1><?php echo $this->Html->image('PublicLayout.logoLogin.png', array('style'=>'width: 70%;')); ?></h1>
         <div class="form-group ">
        <?php if($this->Session->read('Message.flash.message')): ?>
             
            <span style="color: #FF0000; font-size: 0.8em; width: 100%; float: left; text-align: center;  "><?php
            $message = $this->Session->read('Message.flash.message');
	UNSET($_SESSION['Message']['flash']['message']);
	echo $message;
            ?></span> 
             <?php endif; ?>
             <?php 
             echo $this->Form->create('Manager.User', array('class'=>'login', 'name'=>'login')); 
             echo $this->Form->input('username', array('class'=>'form-control', 'placeholder'=>'Username', 'id'=>'UserName', 'div'=>false, 'label'=>FALSE));
             ?>
           <i class="fa fa-user"></i>
         </div>
         <div class="form-group log-status">
           <?php echo $this->Form->input('password', array('class'=>'form-control', 'placeholder'=>'Senha', 'type'=>'password', 'id'=>'Passwod', 'div'=>false, 'label'=>false)); ?>  

           <i class="fa fa-lock"></i>
         </div>
    
             
             
  
         
         
         
          
          
          
          
          <?php if(true == false): ?>
          <a class="link" href="#">Lost your password?</a>
          <?php endif; ?>
         <?php
           echo $this->Form->submit('Logar', array('class'=>'log-btn', 'div'=>false)); 
					   echo $this->Form->end();
         ?>
         
       </div>
 




 <?php endif; ?>   
      
      
      <?php echo $this->Html->script(array('LoginLayout.jquery.min.js', 'LoginLayout.index.js')); ?>

    
    
    
  </body>
</html>

