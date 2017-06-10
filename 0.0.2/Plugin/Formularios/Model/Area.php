<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class Area extends FormulariosAppModel
{
    public $name = 'Area';
    public $useTable = 'areas';
    public $tablePrefix = 'cw_';

   /* public $validate = array(
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
                             );*/
}
