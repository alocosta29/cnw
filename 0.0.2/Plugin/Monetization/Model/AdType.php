<?php
App::uses('MonetizationAppModel', 'Monetization.Model');
class AdType extends MonetizationAppModel{
	//public $displayField = 'nome';
	public $name = 'AdType';
	public $useTable = 'types';
	public $tablePrefix = 'ads_';

        public $validate = array
	(
                'tipo' => array(
                                'notempty' => array(
                                                'rule' => array('notempty'),
                                                'message' => 'Campo obrigatório'
                                )),
            

                  'alias' => array(
                                     'notempty' => array(
                                                     'rule' => array('notempty'),
                                                     'message' => 'Campo obrigatório'
                                     )),
                  'max_width' => array(
                                     'notempty' => array(
                                                     'rule' => array('notempty'),
                                                     'message' => 'Campo obrigatório'
                                     )),
            
            
                'min_width' => array(
                                        'notempty' => array(
                                                        'rule' => array('notempty'),
                                                        'message' => 'Campo obrigatório'
                                        )),

                  'max_height' => array(
                                     'notempty' => array(
                                                     'rule' => array('notempty'),
                                                     'message' => 'Campo obrigatório'
                                     )),
                  'min_height' => array(
                                     'notempty' => array(
                                                     'rule' => array('notempty'),
                                                     'message' => 'Campo obrigatório'
                                     )),
        );
}