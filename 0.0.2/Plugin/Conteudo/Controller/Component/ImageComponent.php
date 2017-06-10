<?php
App::import('Eduwork.Vendor','WideImage/lib/WideImage');
class ImageComponent extends Component{
    
    private $fileCheck= null;
    private $saveFolder = null;
    private $nameFileSave = null;
    private $nameFileSaveThumb = null;
    private $errors = null;
    private $isValidation = true;
    private $sizeImage = null;
    
    public $components = array('Eduwork.FileUpload');
    
    public function startImage($fileCheck, $saveFolder){
        $this->cleanClass();
        $this->fileCheck = $fileCheck;
        $this->saveFolder = $this->getSaveFolder($saveFolder);
        $this->checkEmpty();
        $this->checkErrors();
        $this->checkExtension();
        $this->checkSize();
        $this->setNameFile();
        $this->uploadFile();
        $this->uploadThumbsFile();
        $this->uploadThumbsColorFile();
        return $this->isValidation;
    }
    
    /**
     * M´wtodo que verifica a possível existencia de erros
     */
     private function checkErrors(){
           if($this->isValidation)
           {
               if($this->fileCheck['error']>0){
                   $this->isValidation = false;
                   $this->setErrors("Erro no upload de arquivo. Por favor, tente novamente!");
               }               
           }
     }
    
    private function uploadThumbsFile(){
           if($this->isValidation)
           {
                try{
                   if($this->sizeImage[1] > 60)
                   {
                                $fileSaved = $this->saveFolder.$this->nameFileSave;
                                $folderthumb = $this->getSaveFolder('clients_thumb').$this->nameFileSave;
                                $img = WideImage::load($fileSaved)->resize(148, 60)->asGrayscale()->saveToFile($folderthumb);
                       }else{
                                 $fileSaved = $this->saveFolder.$this->nameFileSave;
                                 $folderthumb = $this->getSaveFolder('clients_thumb').$this->nameFileSave;
                                 $img = WideImage::load($fileSaved)->asGrayscale()->saveToFile($folderthumb);
                        }
   
                    }catch(Exception $e){
                        $this->isValidation = false;
                        $this->setErrors("Erro na redução do arquivo de imagem. Por favor, tente novamente!");
                    }
           } 
    }
    
     private function uploadThumbsColorFile(){
           if($this->isValidation)
           {
                try{
                   if($this->sizeImage[1] > 60)
                   {
                                $fileSaved = $this->saveFolder.$this->nameFileSave;
                                $folderthumb = $this->getSaveFolder('clients_thumb_color').$this->nameFileSave;
                                $img = WideImage::load($fileSaved)->resize(148, 60)->saveToFile($folderthumb);
                       }else{
                                 $fileSaved = $this->saveFolder.$this->nameFileSave;
                                 $folderthumb = $this->getSaveFolder('clients_thumb_color').$this->nameFileSave;
                                 $img = WideImage::load($fileSaved)->saveToFile($folderthumb);
                        }
   
                    }catch(Exception $e){
                        $this->isValidation = false;
                        $this->setErrors("Erro na criação do arquivo destaque. Por favor, tente novamente!");
                    }
           } 
    }
     
    /**
      * Método que verifica se a extensão da imagem é uma extensão válida
      */
     private function checkExtension(){
            if($this->isValidation)
            {
                $type = explode('/', $this->fileCheck['type']);
                if(!empty($type[1]))
                {
                    $listImgs = array('jpeg', 'jpg', 'JPG', 'png', 'PNG', 'JPEG');
                   if(!in_array($type[1], $listImgs)){
                       $this->isValidation = false;
                       $this->setErrors("Formato de imagem inválido! Por favor, utilize apenas jpg ou png!");
                   }
                }else{
                    $this->isValidation = false;
                    $this->setErrors("Formato de imagem não identificado!");
                }
            }    
     }
        
    /**
     * Método que seta o nome do arquivo
     */
    private function setNameFile(){
       if($this->isValidation){
           $nameFile = date('dmY_His');
           $this->nameFileSave = $nameFile.$this->getExtension($this->fileCheck['type']); 
           $this->nameFileSaveThumb = $nameFile.'_thumb'.$this->getExtension($this->fileCheck['type']); 
       }     
    }
    
     /**
     * Método que retorna a pasta de gravação do arquivo
     */
     private function getSaveFolder($paste){
         
         switch ($paste) {
             case 'clients':
                 return WWW_ROOT.'img'.DS.'clients'.DS;
                 break;
                 
             case 'clients_thumb':
                 return WWW_ROOT.'img'.DS.'clients_thumb'.DS;
                 break;
                   
             case 'clients_thumb_color':
                 return WWW_ROOT.'img'.DS.'clients_thumb_color'.DS;
                 break;  
             
             default:
                 return WWW_ROOT.'img'.DS;
                 break;
         }
     }
    
    /**
     * Método que faz o upload
     */
     private function uploadFile(){
         if($this->isValidation){
             if(!$this->FileUpload->startUpload($this->fileCheck, $this->saveFolder, $this->nameFileSave)){
                 $this->isValidation = false;
                 $this->setErrors('Erro no upload de arquivo! Por favor, tente novamente!');
             }
         }
     }
    
    /**
     * Método que valida o tamanho da imagem
     */
    private function checkSize(){
        if($this->isValidation){
               $this->sizeImage = getimagesize($this->fileCheck['tmp_name']);        
               if($this->sizeImage[1] > 1500){
                  $this->isValidation = false;
                  $this->setErrors('Arquivo de imagem muito grande! Por favor, diminua o tamanho da imagem e tente novamente!');  
                }elseif($this->sizeImage[1] < 40){
                  $this->isValidation = false;
                  $this->setErrors('Resolução de imagem muito pequena! Por favor,  escolha uma imagem com resolução maior e tente novamente!');  
                }
           } 
    }
    
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
     * Método que verifica se o arquivo não está vazio
     */
    private function checkEmpty(){
        if(empty($this->fileCheck)){
            $this->isValidation = false;
            $this->setErrors("O campo imagem está vazio. Por favor, escolha uma imagem!");
        }
    }
    
    //private function checkSize(){}
    
    /**
     * Método que seta possíveis erros
     */
    private function setErrors($error){
        if(!empty($this->errors)){
            $this->errors = $this->errors .'<br>'.$error;
        }else{
            $this->errors = $error;
        }
    }
    
    /**
     * Método que retorna o nome do arquivo para gravaçãono bd
     */
     public function getFile(){
         return $this->nameFileSave;
     }
    
    /**
     * Método que retorn possíveis erros
     */
    public function getErrors(){
        return $this->errors;
    }
       
    private function cleanClass()
    {
        $this->fileCheck = null;
        $this->saveFolder = null;
        $this->errors = null;
        $this->nameFileSave = null;
        $this->isValidation = true;
        $this->nameFileSaveThumb = null;
        $this->sizeImage = null;
    }
    
    /**
     * Método que retorna os dados do arquivo gravado
     */
    public function delFileSaved()
    {
        if(!empty($this->nameFileSave))
        {    
                  try{
                        if(!unlink($this->saveFolder.$this->nameFileSave))
                        throw new Exception();
                        
                        if(!unlink($this->getSaveFolder('clients_thumb').$this->nameFileSave))
                        throw new Exception();
                        
                        if(!unlink($this->getSaveFolder('clients_thumb_color').$this->nameFileSave))
                        throw new Exception();
                         
                        return true;
                   }catch(Exception $e){
                        return false;
                   } 
        }
    }
    
}
