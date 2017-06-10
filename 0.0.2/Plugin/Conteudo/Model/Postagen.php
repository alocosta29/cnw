<?php
App::uses('ConteudoAppModel', 'Conteudo.Model');

class Postagen extends ConteudoAppModel{
    public $name = 'Postagen';
    public $useTable = 'postagens';
    public $tablePrefix = 'cw_';

	public $validate = array(
		'titulo' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, digite um título!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, //Stop validation after this rule
				//'on' => 'create', //Limit validation to 'create' or 'update' operations
			),
		),
	  /* 'texto' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Por favor, digite o conteúdo!',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, //Stop validation after this rule
                //'on' => 'create', //Limit validation to 'create' or 'update' operations
            ),
        ),*/
        
        'resumo' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Por favor, digite o resumo! Ele aparecerá na descrição da página,quando esta for indexada pelos mecanismos de busca!',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, //Stop validation after this rule
                //'on' => 'create', //Limit validation to 'create' or 'update' operations
            ),
        ),
        
        
        
	);    
    
    /**
     * @var array
     */
	public $belongsTo = array(
                        		'CatConteudo' => array(
                        			'className' => 'Conteudo.CatConteudo',
                        			'foreignKey' => 'cat_conteudo_id',
                        			'conditions' => '',
                        			'fields' => '',
                        			'order' => ''
	                         )
	                    );
}