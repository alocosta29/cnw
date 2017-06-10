<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('NameModel', 'PluginName.Model');
class DefaultComponent extends Component{
    
    private $id = null;
    private $isValidation = true;
	public $errors = null;
    
    public function start($id = null){
        $this->cleanClass();
        $this->id = $id;
          
        
        return $this->isValidation;
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