<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Countview', 'Articles.Model');
App::uses('Artigo', 'Articles.Model');
class PopComponent extends Component{
    
    
    public function __construct(ComponentCollection $collection, $settings = array()) {

            parent::__construct($collection, $settings);
            pr($settings); 
            pr('akii');
            exit();
    }
    
}