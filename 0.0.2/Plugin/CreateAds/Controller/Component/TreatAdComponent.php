<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Caderno', 'ConfigBook.Model');
class TreatAdComponent extends Component{
    
    private $data = null;
    public $save = null;
    private $caderno = null;
    private $dataCaderno = null;
    private $fileErrorDel = null;
    
    private $isValidation = true;
    public $errors = null;
    
    public $components = array('Session', 'UploadFile');
    
    public function start($data = null, $caderno = null)
    {
        $this->cleanClass();
        $this->data = $data;
        $this->caderno = $caderno;
        $this->setCaderno();
        $this->setFields();
        $this->setImage();
  
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

   
    private function setFields(){
        if($this->isValidation){
            $this->save = $this->data;
            $this->save['Ad']['caderno_id'] = $this->dataCaderno['id'];
            $this->save['Ad']['user_id'] = $this->Session->read('Auth.User.id');
        }
    }
      
    
    private function setImage(){
        if($this->isValidation){
            $fileSelect = $this->data['Ad']['imagem'];
            $folder = $this->save['Ad']['user_id'].DS;
            $nameFile = $this->save['Ad']['user_id'].'_'.date('dmYHis');
                
            
            if(!$this->UploadFile->start($fileSelect, 'ad-image', array('folder'=>$folder, 'name'=>$nameFile, 'typeAd'=>$this->data['Ad']['type_id'])))
            {
                $this->setErrors($this->UploadFile->errors);
                $this->fileErrorDel = $this->UploadFile->delFailOperation;
                $this->delAdImageError();
            }else{
                $this->fileErrorDel = $this->UploadFile->delFailOperation;
                $this->save['Ad']['imagem'] =  $this->UploadFile->nameFile;
               // pr('deu certo'); exit();
            }
        }
    }
     
    public function delAdImageError(){
      $this->UploadFile->delErrorFile($this->fileErrorDel);
    }    
    
    /**
              * Método que seta os erros encontrados
              *  @param type $error
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
        $this->data = null;
        $this->save = null;
        $this->caderno = null;
        $this->dataCaderno = null;
        $this->isValidation = true;
        $this->errors = null;
        $this->fileErrorDel = null;
    }
}
