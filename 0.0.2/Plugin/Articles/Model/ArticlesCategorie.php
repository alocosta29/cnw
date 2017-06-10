<?php
App::uses('ArticlesAppModel', 'Articles.Model');

class ArticlesCategorie extends ArticlesAppModel {
    public $name = 'ArticlesCategorie';
    public $useTable = 'artigos_categorias';
    public $tablePrefix = 'cwcol_';

	public $belongsTo = array(
	
		'Article' => array(
			'className' => 'Articles.Article',
			'foreignKey' => 'artigo_id',
			'conditions' => '',
			'fields' => '',
			'order' => '' ),
			
		'Categoria' => array(
			'className' => 'Articles.Categoria',
			'foreignKey' => 'categoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => '' )
		
	);
}
