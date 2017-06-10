<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class Formulario extends FormulariosAppModel
{
    public $name = 'Formulario';
    public $useTable = 'formularios';

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
