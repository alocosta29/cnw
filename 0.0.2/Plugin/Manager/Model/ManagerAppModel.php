<?php

//App::uses('AppModel', 'Model');
App::uses('Model', 'Model');



//class ManagerAppModel extends AppModel {
class ManagerAppModel extends Model {
	public $actsAs = array('Locale.Locale');
	public function save($data = null, $validate = true, $fieldList = array()) {
		/**
		 * Garantindo que os dados do usuario sera salvos na tabela, como:
		 * DataHoraDaAlteracaoInclusao: created, modified e updated
		 * IdDoUsuarioQueEfetuouAlteracaoInclusao: createdby, modifiedby e updatedby
		 */
		$this->set($data);
		if (isset($this->data[$this->alias]['modified'])) {
			unset($this->data[$this->alias]['modified']);
		}
		if (isset($this->data[$this->alias]['updated'])) {
			unset($this->data[$this->alias]['updated']);
		}
        if(!empty($_SESSION['Auth']['User']['id']))
        {
                $this->data[$this->alias]['modifiedby'] = $_SESSION['Auth']['User']['id'];
                $this->data[$this->alias]['updatedby'] = $_SESSION['Auth']['User']['id'];
                if (trim($this->id)==='') {
                    #Se novo registro
                    $this->data[$this->alias]['createdby'] = $_SESSION['Auth']['User']['id'];
                }
        }    
		return parent::save($this->data, $validate, $fieldList);
	}
	
   // public function save($data = null, $validate = true, $fieldList = array()) {
        /**
         * Garantindo que os dados do usuario sera salvos na tabela, como:
         * DataHoraDaAlteracaoInclusao: created, modified e updated
         * IdDoUsuarioQueEfetuouAlteracaoInclusao: createdby, modifiedby e updatedby
         */
     /*   $this->set($data);
        if (isset($this->data[$this->alias]['modified'])) {
            unset($this->data[$this->alias]['modified']);
        }
        if (isset($this->data[$this->alias]['updated'])) {
            unset($this->data[$this->alias]['updated']);
        }
       if(!empty($_SESSION['Auth']['User']['id'])){
         $this->data[$this->alias]['modifiedby'] = $_SESSION['Auth']['User']['id'];
         $this->data[$this->alias]['updatedby'] = $_SESSION['Auth']['User']['id'];  
       }
        
        
        if (trim($this->id)==='') { #Se novo registro
            $this->data[$this->alias]['createdby'] = $_SESSION['Auth']['User']['id'];
        }
            
        return parent::save($this->data, $validate, $fieldList);
    }*/
    
    
       
    
    
    private function getExtension($type){
        switch ($type) {
            case 'image/jpeg':
                return '.jpg';
                break;
            
            case 'image/png':
                return '.png';
                break;
            
            default:
                return '.txt';
                break;
        }
        
    }
    
    
    
    
    
    
    /**
     * Método que checa erros do arquivo
     */
    public function checkErrors($file, $field){
            
            
        if($file[$field]['error'] > 0){
 
            return false;
        }else{
            return true;
        }
    }
      
    
    
    /**
     * Método que valida o tipo de arquivo
     */
     
     public function checkExtension($file, $type){
         switch ($type) {
             case 'image':
                 return $this->checkImage($file['imagem']);
                 break;
             
             default:
                 
                 break;
         }
         
     }
     
     /**
      * Método que verifica se a extensão da imagem é uma extensão válida
      */
     private function checkImage($imagem){
        $type = explode('/', $imagem['type']);
        if(!empty($type[1]))
        {
            $listImgs = array('jpeg', 'jpg', 'JPG', 'png', 'PNG', 'JPEG');
            return in_array($type[1], $listImgs);
            
        }else{
            return false;
        }
         
     }
    
    
    /**
     * Método que elimina espaçosem branco
     */
     private function delSpace($data){
         return str_replace(" ","", $data);
     }
    
    
    
    
}

