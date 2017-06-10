<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class Cadastro extends FormulariosAppModel
{
    public $name = 'Cadastro';
    public $useTable = 'cadastros';
    public $tablePrefix = 'cwcol_';

    public $validate = array(
                    		'nome' => array(
                                                'rule' => 'notEmpty', 
                                                'message' => "Digite seu nome",
                    					   ),
                    		'email' => array(
                                                'email'=>array(
                                                                'rule' => 'email', 
                                                                'message' => "Insira um email válido",
                                                                ),
                                                 'checkExistence' => array(
                                                                'rule' => 'checkExistence', 
                                                                'message' => "Esse e-mail já foi utilizado em outra solicitação.",
                                                                    ),
                                    
                                              'checkExistenceUser' => array(
                                                                'rule' => 'checkExistenceUser', 
                                                                'message' => "Esse e-mail já é utilizado por um usuário do sistema.",
                                                                    ),
                                    
                                    
                                                
                    						),                                        
	                         );
                             
    
    public function checkExistence(){
        $data = $this->data;
        $mail = trim($data['Cadastro']['email']);
        $count = $this->find('count', 
                array(
                    'conditions'=>array('Cadastro.email'=>$mail)));
        if($count>0){
            return false;
        }else{
            return true;
        }
    }
    
    public function checkExistenceUser(){
        $data = $this->data;
        $mail = trim($data['Cadastro']['email']);
        $params = "SELECT COUNT(users.username) AS numberUser FROM users WHERE users.username = '".$mail."'";
        $count = $this->query($params); 
        if($count[0][0]['numberUser'] > 0){
            return false;
        }else{
            return true;
        }
    }
    
    
    
    public $hasMany = array(
            'CadastrosCaderno' => array(
                    'className' => 'Formularios.CadastrosCaderno',
                    'foreignKey' => 'cadastro_id',
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
        
        
         'Alert' => array(
                    'className' => 'Formularios.Alert',
                    'foreignKey' => 'cadastro_id',
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
        
        
        
        );               
}