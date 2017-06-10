<?php 
App::uses('AppHelper', 'View/Helper'); 
//App::uses('HtmlHelper', 'View/Helper');
class ArticleHelper extends AppHelper{
    public $helpers = array('Html');
        
    /**
           * Retorna a imagem do artigo
           * @param type $params
           * @return string
           */
    public function featuredImagePost($params = array('user_id'=> null, 'img'=> null, 'caderno'=>null, 'idPost'=>null))
    {
        $selectImage = $this->Html->image('noPostImage.png', array('style'=>'width: 170px;', 'title'=>'Inserir imagem destacada'));
        if(!empty($params['user_id']) and !empty($params['img']))
        {
            $checkImage = IMAGES.'img_destak'.DS.$params['user_id'].DS.$params['img'];
            if(file_exists($checkImage)){
               $image = 'img_destak/'.$params['user_id'].'/'.$params['img'];
               $selectImage =  $this->Html->image($image, array('style'=>'width: 170px;', 'title'=>'Inserir imagem destacada'));
            }
        }
        $returnLink = $this->Html->link($selectImage, array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'featuredImage', $params['caderno'], $params['idPost']), array('escape'=>false));
        return $returnLink;
    }
    
    
    /**
           * Retorna a imagem do artigo
           * @param type $params
           * @return string
           */
    public function exibeImagePost($params = array('user_id'=> null, 'img'=> null, 'caderno'=>null, 'idPost'=>null, 'width'=>null))
    {
        $selectImage = $this->Html->image('noPostImage.png', array('style'=>'width: '.$params['width']));
        if(!empty($params['user_id']) and !empty($params['img']))
        {
            $checkImage = IMAGES.'img_destak'.DS.$params['user_id'].DS.$params['img'];
            if(file_exists($checkImage)){
               $image = 'img_destak/'.$params['user_id'].'/'.$params['img'];
               $selectImage =  $this->Html->image($image, array('style'=>'width: '.$params['width']));
            }
        }
       // $returnLink = $this->Html->link($selectImage, array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'featuredImage', $params['caderno'], $params['idPost']), array('escape'=>false));
        return $selectImage;
    }
    
} 