<ul>
    <?php
    $controller = $this->params['controller']; 
    echo '<li>'.$this->Html->link('Página inicial', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'index', $caderno)).'<li><br>';
    if($controller == 'profiles') {
            if($this->action <> 'admin_view'):
            echo '<li>'.$this->Html->link('Visualizar perfil', array('plugin'=>'articles', 'controller'=>'profiles', 'action'=>'view', $caderno)).'</li>'; 
            endif;

            if($this->action <> 'admin_edit'):
            echo '<li>'.$this->Html->link('Editar perfil', array('plugin'=>'articles', 'controller'=>'profiles', 'action'=>'edit', $caderno)).'</li>'; 
            endif;
    }else{
        echo '<li>'.$this->Html->link('Visualizar perfil', array('plugin'=>'articles', 'controller'=>'profiles', 'action'=>'view', $caderno)).'</li>'; 
        echo '<li>'.$this->Html->link('Editar perfil', array('plugin'=>'articles', 'controller'=>'profiles', 'action'=>'edit', $caderno)).'</li>'; 
    }
    
    
    
     $avatar_id = $this->Session->read('Auth.User.Avatar.id');
    if($controller == 'avatars') 
     {

        if($this->action <> 'admin_add'):
        echo '<li>'.$this->Html->link('Enviar/alterar avatar', array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'add', $caderno)).'</li>'; 
        endif;
        if($this->action <> 'admin_redimensiona' and !empty($avatar_id)):
        echo '<li>'.$this->Html->link('Redimensionar avatar', array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'redimensiona', $caderno, $this->Session->read('Auth.User.Avatar.id'))).'</li>'; 
        endif;
     }else{
   
         echo '<li>'.$this->Html->link('Enviar/alterar avatar', array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'add', $caderno)).'</li>';
        
        if(!empty($avatar_id)):
        echo '<li>'.$this->Html->link('Redimensionar avatar', array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'redimensiona', $caderno, $this->Session->read('Auth.User.Avatar.id'))).'</li>'; 
        endif;
        
         
    }
    
    
 
    
    
    
  
    ?>
    
    
    
</ul>