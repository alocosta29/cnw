<?php
App::uses('ArticlesAppModel', 'Articles.Model');
class Categoria extends ArticlesAppModel {
    public $name = 'Categoria';
    public $useTable = 'cwcol_categorias';
    //public $tablePrefix = 'cwcol_';
        
    public $validate = array(
                                'nome' =>array(
                                                'notEmpty' => array(
                                                'rule' => 'notEmpty',
                                                'message' => "Por favor digite o nome da categoria",
                                                                   ),
                                               ),
                                'alias' =>array(
                                                'checkDuplicate' => array(
                                                'rule' => 'checkDuplicate',
                                                'message' => "Já existe uma categoria com esse alias!",
                                                                         )
                                               )
	                        );
    
    /**
     * Método que verifica se a categoria já não está cadastrada
     */
    public function checkDuplicate()
    {
            $data = $this->data;
            $options = array(
                'conditions'=>array(
                                    'Categoria.isdeleted'=>'N',
                                    'Categoria.alias'=>$data['Categoria']['alias'],
                                    )
                                );
            if(!empty($data['Categoria']['id'])){
                $options['conditions']['NOT']['Categoria.id'] = $data['Categoria']['id'];            
            }
            $count = $this->find('count', $options);
            if($count > 0)
            {
                $this->data = $data; return false;
            }else{
                $this->data = $data; return true;
            }
    }
  
     public $hasAndBelongsToMany = array(
        'Artigo' => array(
                            'className' => 'Articles.Artigo',
                            'joinTable' => 'cwcol_artigos_categorias',
                            'foreignKey' => 'categoria_id',
                            'associationForeignKey' => 'artigo_id',
            'unique' => true,
                          /*'unique' => true,
                            'conditions' => '',
                            'fields' => '',
                            'order' => '',
                            'limit' => '',
                            'offset' => '',
                            'finderQuery' => '',
                            'with' => ''*/
                          )
    ); 
     
     
     	public $belongsTo = array(
                        		'Caderno' => array(
                        			'className' => 'ConfigBook.Caderno',
                        			'foreignKey' => 'caderno_id',
                        			'conditions' => '',
                        			'fields' => '',
                        			'order' => ''
	                         )
	                    );
     
}
