<?php
App::uses('ConteudoAppModel', 'Conteudo.Model');
/**
 * Categoria Model
 * @property Categoria $ParentCategoria
 * @property Categoria $ChildCategoria
 * @property Conteudo $Conteudo
 */
class CatConteudo extends ConteudoAppModel {
    public $name = 'CatConteudo';
    public $useTable = 'cat_conteudos';
    public $tablePrefix = 'cw_';
    
	public $hasMany = array(
                			'Postagen' => array(
                                        			'className' => 'Conteudo.Postagen',
                                        			'foreignKey' => 'cat_conteudo_id',
                                        			'dependent' => false,
                                        			'conditions' => '',
                                        			'fields' => '',
                                        			'order' => '',
                                        			'limit' => '',
                                        			'offset' => '',
                                        			'exclusive' => '',
                                        			'finderQuery' => '',
                                        			'counterQuery' => ''
                		                        )
	                       );
}