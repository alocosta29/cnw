<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('MktAppController', 'Mkt.Controller');
class ReportsController extends MktAppController{
    public $uses = array('Articles.Artigo');
    
    
    public function admin_maisVisitados(){
        $options = array(
			'conditions' => array('Artigo.isdeleted' => 'N',  'Artigo.status' => 'P', 'Artigo.data_publicacao <='=> date('Y-m-d H:i:s')),
			'order' => array('Artigo.page_views' => 'DESC'),
			//'limit' => 20
		);
		//$this->paginate = $options;
		//$Models = $this->paginate('Artigo');
        #pr($Models); exit();
        $Models = $this->Artigo->find('all', $options);
		$this->set('Artigos', $Models);
        
        
    }
    
   public function admin_programados(){
             $options = array(
			'conditions' => array('Artigo.isdeleted' => 'N',  'Artigo.status' => 'P', 'Artigo.data_publicacao >'=> date('Y-m-d H:i:s')),
			'order' => array('Artigo.page_views' => 'DESC'),
			//'limit' => 20
		);
		//$this->paginate = $options;
		//$Models = $this->paginate('Artigo');
        #pr($Models); exit();
        $Models = $this->Artigo->find('all', $options);
		$this->set('Artigos', $Models);   
        
        
    }  
    
    
    
    
    
    
    
    
}