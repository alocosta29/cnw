<?php
App::uses('AppHelper', 'View/Helper'); 
class AvatarHelper extends Helper{
    public $helpers = array('Html');
    
    /**
     * Método que verifica se a imagem existe
     */
    public function checkImgExists($arquivo)
    {        
     
        $handle = @fopen($arquivo, "rb");
        $cont = @fread($handle, 100);

        if($cont == "servidor online") {
            return true;
        } else {
            return $cont;
        }        
    }   
    
    
    public function getThumbAvatar($params = array('person_id' => null, 'genero'=> 'M', 'image'=> null, 'idAvatar' => null, 'caderno'=>null)){
        if(empty($params['genero'])){ $params['genero'] = 'M';  }
        $img = array(
            'M'=> $this->Html->image('avatars/default/fotoH.jpg'),
            'F'=> $this->Html->image('avatars/default/fotoM.jpg')
        );
        $selectImg = $img[$params['genero']];
           
        $returnImg = $this->Html->image('avatars/default/fotoH.jpg');
        if(!empty($params['person_id']) and !empty($params['image']))
        {
           // $checkImage = HOST_IMAGE.'avatars'.DS.$params['person_id'].DS.'thumb'.DS.$params['image'];
            $checkImage = AVATAR.$params['person_id'].DS.'thumb'.DS.$params['image'];
            if(!file_exists($checkImage)){
               $returnImg = $this->Html->link($selectImg, array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'add',  $params['caderno'], $params['person_id']), array( 'escape'=>false)); 
            }else{
               $urlImage = 'avatars/'.$params['person_id'].'/thumb/'.$params['image'];
               $selectImg = $this->Html->image($urlImage, array('style'=>'width: 100%;', 'title'=>'Redimensionar imagem')); 
               $returnImg = $this->Html->link($selectImg, array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'redimensiona', $params['caderno'], $params['idAvatar']), array( 'escape'=>false)); 
            }
        }else{
           if(!empty($params['person_id'])){
               $returnImg = $this->Html->link($selectImg, array('plugin'=>'avatar', 'controller'=>'avatars', 'action'=>'add',  $params['caderno'], $params['person_id']), array('escape'=>false));
           } 
        }
        return $returnImg;
        
        
    }
    
    
    
      public function getAvatar($params = array('person_id' => null, 'image'=> null, 'idAvatar' => null))
      {
        $img = $this->Html->image('avatars/default/default.png');
        if(!empty($params['person_id']) and !empty($params['image']))
        {
            $checkImage = AVATAR.$params['person_id'].DS.'thumb'.DS.$params['image'];
            if(file_exists($checkImage)){
               $urlImage = 'avatars/'.$params['person_id'].'/thumb/'.$params['image'];
               $img = $this->Html->image($urlImage, array('style'=>'width: 50%;')); 
            }
        }    
        return $img;
    }
    
     public function getAuthorAvatar($params = array('person_id' => null, 'image'=> null, 'idAvatar' => null)){
        $img =false;
        if(!empty($params['person_id']) and !empty($params['image']))
        {
            $checkImage = AVATAR.$params['person_id'].DS.'thumb'.DS.$params['image'];
            if(file_exists($checkImage)){
               $urlImage = 'avatars/'.$params['person_id'].'/thumb/'.$params['image'];
               $img = $this->Html->image($urlImage, array('style'=>'max-width: 170px; border-radius: 100%; margin-right: 20px; ', 'align'=>'left')); 
            }
        }    
        return $img;
    }
    
    
     public function getAuthorImage($params = array('person_id' => null, 'image'=> null, 'idAvatar' => null)){
        $urlImage ='avatars/default/default.png';
        if(!empty($params['person_id']) and !empty($params['image']))
        {
            $checkImage = AVATAR.$params['person_id'].DS.'thumb'.DS.$params['image'];
            if(file_exists($checkImage)){
               $urlImage = 'avatars/'.$params['person_id'].'/thumb/'.$params['image'];
               
            }
        } 
        $img = $this->Html->image($urlImage, array('align'=>'left')); 
        return $img;
    }
    
    
    
    
    
}

