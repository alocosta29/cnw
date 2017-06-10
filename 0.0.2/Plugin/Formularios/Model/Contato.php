<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class Contato extends FormulariosAppModel
{
    public $name = 'Contato';
	public $useTable = 'contatos';
	public $tablePrefix = 'cw_';
	
    public $validate = array(
                    		'nome' => array('rule' => 'notEmpty', 
                    						'message' => "Digite seu nome",
                    						),
                    		'assunto' => array('rule' => 'notEmpty', 
                    						'message' => "Can't be empty the field message",
                    						),
                    		'email' => array('rule' => 'email', 
                    						'message' => "Insira um email válido",
                    						),
                    		'mensagem' => array('rule' => 'notEmpty', 
                    						'message' => "Descreva sua solicitação na mensagem",
                    						),
	                         );
                             
                             
                                  public $belongsTo = array(
        'Formulario' => array(
            'className' => 'Formularios.Formulario',
            'foreignKey' => 'formulario_id',
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