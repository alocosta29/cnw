<?php
App::uses('ArticlesAppModel', 'Articles.Model');
class Extra extends ArticlesAppModel {
    public $name = 'Extra';
    public $useTable = 'cwcol_extras';
    //public $tablePrefix = 'cwcol_';
        
    public $validate = array(
                                'nome' =>array(
                                                'notEmpty' => array(
                                                'rule' => 'notEmpty',
                                                'message' => "Por favor digite o nome do arquivo",
                                                                   ),
                                               ),
                                    'descricao' =>array(
                                                'notEmpty' => array(
                                                'rule' => 'notEmpty',
                                                'message' => "Por favor digite a descrição do arquivo",
                                                                   ),
                                               ),
                       'arquivo' =>array(
                                                'notEmpty' => array(
                                                'rule' => 'notEmpty',
                                                'message' => "Por favor, selecione uma arquivo",
                                                                   ),
                                               ),
	                        );
     
     
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
     
}
