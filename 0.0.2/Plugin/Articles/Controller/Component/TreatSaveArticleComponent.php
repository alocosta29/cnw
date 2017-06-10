<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Caderno', 'ConfigBook.Model');
App::uses('Artigo', 'Articles.Model');
class TreatSaveArticleComponent extends Component{
    
    private $data = null;
    private $caderno = null;
    private $dataCaderno = null;
    private $isValidation = true;
    public $save = null;
    public $errors = null;
    
    public $components = array('Session');
    
    public function start($data = null, $caderno = null){
        
        $this->data = $data;
        $this->caderno = $caderno;

        $this->setCaderno();
        $this->setFields();  
        $this->setCategorias();

        return $this->isValidation;
    }
    
    /**
     * seta o caderno na memoria da classe
     */
    private function setCaderno()
    {
      $Caderno = new Caderno();
      $find =  $Caderno->find('first', 
                      array('conditions'=>array(
                                            'Caderno.alias'=>$this->caderno, 
                                            'Caderno.isdeleted'=>'N')));
      if(!empty($find)){
          $this->dataCaderno = $find['Caderno'];
          
      }else{
          $this->setErrors('Caderno não localizado!');
      }
        
    }
    
    
    
    /**
     * Método que seta os campos
     */
    private function setFields(){
        if($this->isValidation){
            $this->save = $this->data;
            if(empty($this->data['Artigo']['id']))
            {
                    $this->save['Artigo']['user_id'] = $this->Session->read('Auth.User.id');
                    $this->save['Artigo']['person_id'] = $this->Session->read('Auth.User.person_id');
                    $this->save['Artigo']['caderno_id'] = $this->dataCaderno['id'];
                    $this->save['Artigo']['numero_artigo'] =$this->getNumberArticle();
                    $this->save['Artigo']['versao_artigo'] = 1;
                    $this->save['Artigo']['caderno_id'] = $this->dataCaderno['id'];
                    $this->save['Artigo']['status'] = 'R';
            }
        }
    }   


    private function setCategorias()
    {
        if(!empty($this->save['ArtigosCategoria']['categoria_id']))
        {
            $list = $this->save['ArtigosCategoria']['categoria_id'];
            unset($this->save['ArtigosCategoria']);
            $i=0;
            $totalSize = sizeof($list);
            while($i<$totalSize){
               $this->save['ArtigosCategoria'][$i]['categoria_id'] = $list[$i];
                $i++;
            }
        }else{
            unset($this->save['ArtigosCategoria']);
        }         
    }



    
    
    private function getNumberArticle(){
        $Artigo = new Artigo();
        $find = $Artigo->find('first', 
                array(
                    'conditions'=>array(
                                        'Artigo.isdeleted'=>'N',
                                        'Artigo.user_id'=>$this->Session->read('Auth.User.id'),
                                        'Artigo.caderno_id' => $this->dataCaderno['id'],
                                        ),
                    'order'=>array('Artigo.numero_artigo'=>'DESC')
                    ));
        
        if(!empty($find)){
           return $find['Artigo']['numero_artigo'] + 1;
        }else{
            return 1;
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
            $this->isValidation = true;
            $this->errors = null;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}
