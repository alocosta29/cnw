<?php
App::uses('FormulariosAppModel', 'Formularios.Model');
class Alert extends FormulariosAppModel
{
    public $name = 'Alert';
    public $useTable = 'cwcol_alert_requests';
 

   public $belongsTo = array(
                                'Cadastro' => array(
                                          'className' => 'Formularios.Cadastro',
                                          'foreignKey' => 'cadastro_id',
                                          'conditions' => '',
                                          'fields' => '',
                                          'order' => ''
                                      ),
   
                             );
}