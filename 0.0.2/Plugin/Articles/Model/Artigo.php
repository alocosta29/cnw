<?php
App::uses('ArticlesAppModel', 'Articles.Model');
class Artigo extends ArticlesAppModel {
    public $name = 'Artigo';
    public $useTable = 'cwcol_artigos';
    public $virtualFields = array(
    'versao' => 'CONCAT(Artigo.numero_artigo, ".", Artigo.versao_artigo)'
);
    
    public $validate = array
	(
			'titulo' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'Por favor, informe um titulo'
					)),
        
 			'alias' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'Por favor, defina um alias'
					),
                        'checkSame' =>array(
                        		'rule' => array('checkSame'),
							'message' => 'Por favor, defina um alias diferente. O mesmo ja foi utilizado em outro artigo'
                                            )
                ),       
			'texto' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'o conteúdo do artigo está em branco'
					)),  
         );   
    
    /**
     * Verifica se o mesmo alias já não foi utilizado am alguma postagem
     * @return boolean
     */
    public function checkSame(){
            $data = $this->data;   
            $return = true;
            $options = array('conditions'=>array(
                'Artigo.alias'=>$data['Artigo']['alias'],
                'NOT'=>array(
                    'Artigo.status' => 'N',
                    'AND'=>array(
                                'Artigo.user_id'=>$data['Artigo']['user_id'],
                                'Artigo.numero_artigo'=>$data['Artigo']['numero_artigo']
                                )
                ),
                'Artigo.isdeleted' => 'N',
            ));
            if(!empty($data['Artigo']['id'])){
               $options['conditions']['NOT']['Artigo.id'] =  $data['Artigo']['id'];
            }
            $find = $this->find('first', $options);
            if(!empty($find))
            {
                return false;
            }
            return $return;
    }    
    
   /*  public $hasAndBelongsToMany = array(
        'Categoria' =>
            array(
                'className' => 'Articles.Categoria',
                'joinTable' => 'cwcol_artigos_categorias',
                'foreignKey' => 'artigo_id',
                'associationForeignKey' => 'categoria_id',
                'unique' => true,
            /*  'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => ''*/
        /*    )
    );*/
     
  
     public $belongsTo = array(
	'Caderno' => array(
			'className' => 'ConfigBook.Caderno',
			'foreignKey' => 'caderno_id',
			'conditions' => '',
			'fields' => '',
			'order' => '' 
		
	),   
    
         
        'Individual' => array(
            'className' => 'Manager.Individual',
            //'joinTable' => 'roles_users',
            'foreignKey' => false,
           // 'associationForeignKey' => 'person_id',
            //'dependent' => true,
            'conditions' => array('Artigo.person_id = Individual.person_id'),
            //'conditions' => array(' `User`.`person_id` = `Individual`.`person_id`'),
            'fields' => array('nome'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
          'Colunista' => array(
            'className' => 'ManagerBook.Colunista',
            //'joinTable' => 'roles_users',
            'foreignKey' => false,
           // 'associationForeignKey' => 'person_id',
            //'dependent' => true,
            'conditions' => array('Artigo.person_id = Colunista.person_id'),
            //'conditions' => array(' `User`.`person_id` = `Individual`.`person_id`'),
            'fields' => array('alias', 'apelido'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
         

     );
     
          
	public $hasMany = array(
			
		'Countview' => array(
				'className' => 'Articles.Countview',
				'foreignKey' => 'artigo_id',
				//'dependent' => false,
				'conditions' => '',
				'fields' =>'',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
		),
            'Extra' => array(
				'className' => 'Articles.Extra',
				'foreignKey' => 'artigo_id',
				//'dependent' => false,
				'conditions' => '',
				'fields' =>'',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
		),
            
            'ArticlesCategorie' => array(
				'className' => 'Articles.ArticlesCategorie',
				'foreignKey' => 'artigo_id',
				//'dependent' => false,
				'conditions' => '',
				'fields' =>'',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
		)
            
            
            
            
            
            
			);
     
     
     
     
}