<?php
App::uses('ArticlesAppModel', 'Articles.Model');

class ArtigosCategoria extends ArticlesAppModel {
    public $name = 'ArtigosCategoria';
    public $useTable = 'artigos_categorias';
    public $tablePrefix = 'cwcol_';

	public $belongsTo = array(
	
		'Artigo' => array(
			'className' => 'Articles.Artigo',
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
