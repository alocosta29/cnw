<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('Artigo', 'Articles.Model');
App::uses('Countview', 'Articles.Model');
class ArticleStatsComponent extends Component{
    
    private $id = null;
    private $dataArticle = null; 
    public $totalViews = 0;
    public $uniqueViews = 0;
    private $isValidation = true;
	public $errors = null;
   
    
    public function start($id = null){
        $this->cleanClass();
        $this->id = $id;
        $this->setArticle(); 
        $this->setTotalViews();
        $this->setTotalUniqueViews(); 

        return $this->isValidation;
    }
    
    
    private function setArticle(){
        $Artigo = new Artigo();
        $Artigo->recursive = -1;
        $find = $Artigo -> find('first', array(
                        'conditions'=>array('Artigo.id'=>$this->id,
                            'Artigo.isdeleted'=>'N',
                            'Artigo.status'=>'P',
                            'Artigo.data_publicacao <= '=> date('Y-m-d H:i')
                            )));
     if(!empty($find)){
         $this->dataArticle['artigo'] = $find['Artigo'];
     }else{
         $this->setErrors('Artigo não localizado');
     }
        
    }
    
    private function setTotalViews(){
        if($this->isValidation){
            $Countview = new Countview();
            $find = $Countview->find('count', array('conditions'=>array('Countview.artigo_id'=>$this->id)));
            if($find > 0){
                $this->totalViews = $find;
            }
        }

    }
    
    private function setTotalUniqueViews(){
        if($this->isValidation){
            $Countview = new Countview();
            $find = $Countview->find('all', 
                    array(
                        'fields' => 'DISTINCT Countview.ip',
                        'conditions'=>array(
                        'Countview.artigo_id'=>$this->id,
                        
                        )));
     
            if(!empty($find)){
                $this->uniqueViews = sizeof($find);
            }
        }

    }
    
    
    
       /**
        * Método que seta os erros encontrados
        * @param type $error
        */
       private function setErrors($error = null)
       {
            $this->isValidation = false;
            if(!empty($this->errors)){
                $this->errors = $this->errors.'<br>'.$error;
            }else{
                $this->errors = $error;
            }
       }
    
    /**
     * Método que limpa a classe
     */
    private function cleanClass()
    {
          $this->id = null;
          $this->dataArticle = null; 
          $this->totalViews = 0;
          $this->uniqueViews = 0;
          $this->isValidation = true;
          $this->errors = null;
    }
    
    
}