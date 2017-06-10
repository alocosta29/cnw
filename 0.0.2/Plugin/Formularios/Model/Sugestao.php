<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class Sugestao extends FormulariosAppModel
{
    public $name = 'Sugestao';
    public $useTable = 'sugestaos';
     public $tablePrefix = 'cw_';

    public $validate = array(
                            'mensagem' => array('rule' => 'notEmpty', 
                                            'message' => "Descreva sua crítica ou sugestão na mensagem",
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
