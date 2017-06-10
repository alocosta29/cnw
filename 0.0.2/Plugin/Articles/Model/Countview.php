<?php
App::uses('ArticlesAppModel', 'Articles.Model');
/**
 * Categoria Model
 * @property Categoria $ParentCategoria
 * @property Categoria $ChildCategoria
 * @property Conteudo $Conteudo
 */
class Countview extends ArticlesAppModel {
    public $name = 'Countview';
    public $useTable = 'countviews';
    public $tablePrefix = 'cwcol_';
    

    
    
    
      
     public $belongsTo = array(
        'Caderno' => array(
                'className' => 'ConfigBook.Caderno',
                'foreignKey' => 'caderno_id',
                'conditions' => '',
                'fields' => '',
                'order' => '' 
                ),

        'Artigo' => array(
                'className' => 'Articles.Artigo',
                'foreignKey' => 'artigo_id',
                'conditions' => '',
                'fields' => '',
                'order' => '' 
                ),
     );
     

     
     
     
     
}