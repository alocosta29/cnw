<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class CadastrosCaderno extends FormulariosAppModel
{
    public $name = 'CadastrosCaderno';
    public $useTable = 'cwcol_cadastros_cadernos';
 

   public $belongsTo = array(
                                'Cadastro' => array(
                                          'className' => 'Formularios.Cadastro',
                                          'foreignKey' => 'cadastro_id',
                                          'conditions' => '',
                                          'fields' => '',
                                          'order' => ''
                                      ),
                                'Caderno' => array(
                                          'className' => 'ConfigBook.Caderno',
                                          'foreignKey' => 'caderno_id',
                                          'conditions' => '',
                                          'fields' => '',
                                          'order' => ''
                                      ),
                             );
}