<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class StatusTerm extends FormulariosAppModel
{
    public $name = 'StatusTerm';
	public $useTable = 'status_terms';
    public $tablePrefix = 'cwcol_';
    
    
   public $hasOne = array(
                                'Cadastro' => array(
                                          'className' => 'Formularios.Cadastro',
                                          'foreignKey' => 'cadastro_id',
                                          'conditions' => '',
                                          'fields' => '',
                                          'order' => ''
                                      ),
                                'Term' => array(
                                          'className' => 'Formularios.Term',
                                          'foreignKey' => 'term_id',
                                          'conditions' => '',
                                          'fields' => '',
                                          'order' => ''
                                      ),
                             );
    
    
    
    
}
