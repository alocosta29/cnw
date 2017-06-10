<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class Rh extends FormulariosAppModel
{
    public $name = 'Rh';
	public $useTable = 'curriculos';
     public $tablePrefix = 'cw_';

    public $validate = array(
                    		'nome' => array('rule' => 'notEmpty', 
                    						'message' => "Digite seu nome",
                    						),
                   
                    		'email' => array('rule' => 'email', 
                    						'message' => "Insira um email válido",
                    						),
                    						
                            'telefone' => array('rule' => 'notEmpty', 
                                            'message' => "Por favor, insira um telefone de contato!",
                                            ),
                                            
                            'arquivo_anexo' => array('rule' => 'notEmpty', 
                                            'message' => "Por favor, anexe seu currículo!",
                                            ),          
                                        
	                         );
                             
     public $belongsTo = array(
        'Area' => array(
            'className' => 'Formularios.Area',
            'foreignKey' => 'area_id',
            //'dependent' => TRUE,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ));                  
}