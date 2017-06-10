<?php
App::uses('ManagerBookAppModel', 'ManagerBook.Model');
class Colunista extends ManagerBookAppModel{
	//public $displayField = 'nome';
	public $name = 'Colunista';
	public $useTable = 'colunistas';
	public $tablePrefix = 'cwcol_';
    public $primaryKey = 'person_id';  
        
    public $validate = array
	(

			'apelido' => array(
					'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'Por favor, informe um apelido para o colunista'
					)),
        
            'alias' => array(
                        'notempty' => array(
                                'rule' => array('notempty'),
                                'message' => 'Por favor, informe um alias para o colunista'
                        ))
            
            
         );   
        
        public $belongsTo = array(
                                'Person' => array(
                                    'className' => 'Manager.Person',
                                    'foreignKey' => 'person_id',
                                    'conditions' => '',
                                    'fields' => '',
                                    'order' => ''
                                ),
                               'Avatar' => array(
                                   'className' => 'Avatar.Avatar',
                                   'foreignKey' => 'person_id',
                                   'associationForeignKey' => "person_id",
                                   'conditions' => array('Avatar.isdeleted' => 'N'),
                                ),
                               'Individual' => array(
                                   'className' => 'Manager.Individual',
                                   'foreignKey' => 'person_id',
                                   'associationForeignKey' => "person_id",
                                   'fields' => array('nome', 'data_nascimento')
                                ),
                                );
        
         public function beforeFind($queryData)
    {
        //Certifique-se de variável de swap Keys é inicializada
        $this->swapKeys = array();
        //Verificar se qualquer associação belongsTo é definida no model
        if(!empty($this->belongsTo))
        {
            
            foreach($this->belongsTo as $key => $value)
            {
                if(!is_array($value)) continue;
                //Verifique se associationForeignKey está definido.
                //Se for, em seguida, alterar a chave primária do modelo associado
                if(array_key_exists('associationForeignKey', $value) && !empty($value['associationForeignKey']))
                {
                    // salvar chave primária orignal
                    $this->swapKeys[$key] = $this->{$key}->primaryKey;  
                    //altera a chave primária
                    $this->{$key}->primaryKey = $value['associationForeignKey']; 
                }
              } //next $key
          } 
} 
    
    public function afterFind($results, $primary = false)
    {
        if($this->swapKeys){
        //reset primary keys for all belongsTo association
        foreach($this->swapKeys as $key => $value)
           $this->{$key}->primaryKey = $value;
        unset($this->swapKeys);
        }
        return $results;
    }

    // obter todos os 'individuals' e suas localizações (com mudanças acima ..Este método se torna um pedaço do cake )
    // compará-lo com o getAllIndividual acima ( ) - este é muito mais elegante e simples
    //
    public function getAllAvatar(){
       $this->contain('Avatar');
       return  $this->find('all', array());
    }
        public function getAllIndividual(){
       $this->contain('Individual');
       return  $this->find('all', array());
    }
}