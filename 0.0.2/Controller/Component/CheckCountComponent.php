<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Countview', 'Articles.Model');
App::uses('Artigo', 'Articles.Model');
class CheckCountComponent extends Component{
    
    private $idArtigo = null;
    private $caderno = null;
    private $action = null;
    private $params = null;
    private $isValidation = true;
    
    public $components = array('Session', 'Articles.ArticleStats');
    
    public function start($params = array('action' => null, 'idArtigo' => null, 'caderno' => null))
    {
        $this->cleanClass();   
        $this->setParams($params);
        $this->setCount();
        
        return $this->isValidation;
    }
    
    
    private function setParams($params){
        $this->params = $params;
        if(!empty($this->params['action'])){
            $this->action = $this->params['action'];
        }else{
            $this->isValidation = false;
        }
        if(!empty($this->params['caderno'])){
            $this->caderno = $this->params['caderno'];
        }else{
            $this->isValidation = false;
        }
        if(!empty($this->params['idArtigo'])){
            $this->idArtigo = $this->params['idArtigo'];
        }
    }
    
    
    private function setCount(){
        switch($this->action){
            case 'ver_artigo':
                if(empty($this->idArtigo))
                { $this->isValidation = false; }
                    $this->checkSession();
                    #$this->checkLog();
                    $this->saveView();
                break;
            
            default:
                $this->isValidation = false;
                break;
        }
    }
    
    
    /**
            * Só validará se o usuário não for coklunista nem moderador
            */
    private function checkSession(){
        if($this->isValidation){
            if($this->Session->read('Auth.User.specialAccess.book_adm') or $this->Session->read('Auth.User.specialAccess.book_col')){
                $this->isValidation = false;
            }
        }
    }
    
    
    private function saveView(){
        if($this->isValidation)
        {
            $save['Countview']['artigo_id'] = $this->idArtigo;
            $save['Countview']['caderno_id'] = $this->caderno;
            $save['Countview']['ip'] = $_SERVER["REMOTE_ADDR"];
            $Countview = new Countview();
            $datasource = $Countview->getDataSource();
				try{
                   $datasource->begin(); 
                   if(!$Countview->save($save)){
                       throw new Exception();
                   }
                   if($this->ArticleStats->start($this->idArtigo)){
                       $uniqueViews = $this->ArticleStats->uniqueViews;
                       if($uniqueViews > 0){
                           $Artigo = new Artigo();
                           $Artigo->id = $this->idArtigo;
                           if(!$Artigo->saveField('page_views', $uniqueViews)){
                               throw new Exception();
                           }
                       }
                   }
                    $datasource->commit(); 
                } catch (Exception $ex) {
                    $datasource->rollback();
                }
        }
    }
    
    
    /**
     * Método que limpa a classe
     */
    private function cleanClass()
    {
        $this->idArtigo = null;
        $this->caderno = null;
        $this->action = null;
        $this->params = null;
        $this->isValidation = true;
    }
    
    
}