<?php

class FileManagerComponent extends component{
    
    private $fileUpload = null;
    private $saveFolder = null;
    private $nameFolder = 'upload_files';
    private $nameFile = null;
    private $isValidation = true;
    private $extension = null;
   
    private $maxWidth = false;
    private $minWidth = false;
    private $maxHeight = false;
    private $minHeight = false;
    private $imgWidth = null;
    private $imgHeight = null;
    
    private $typeFile = null;
    private $isUpload = true;
    
    private $errors = 'Erro ao gravar o arquivo! ';
    
    public $components = array('Formularios.FileUpload');
    
    
    public function startUpload($fileUpload){
        $this->cleanClass();
        $this->fileUpload = $fileUpload;
        $this->checkEmpty();
        $this->checkErrors();
        $this->checkExtension();
              
        if($this->isValidation)
        {
              $this->setExtension();
              $this->setFolder();  
              $this->setNameFile(); 
              $this->upload();  
        }
        return $this->isValidation;
    }
       
    public function startImageUpload($fileUpload, $maxWidth = false, $minWidth = false, $maxHeight = false, $minHeight = false, $folder = false, $listExtension = false){
        $this->cleanClass();
        $this->fileUpload = $fileUpload;
        $this->maxWidth = $maxWidth;
        $this->minWidth = $minWidth;
        $this->maxHeight = $maxHeight;
        $this->minHeight = $minHeight;
        $this->checkEmpty();
        $this->checkErrors();
        $this->checkImageExtension($listExtension);
        $this->validImage();
        
        if($this->isValidation)
        {
              $this->setExtension();
              $this->setImgFolder($folder);  
              $this->setNameFile(); 
              $this->upload();  
        }

        return $this->isValidation;
    }
    
    /**
     *  Método que valida a imagem
     */        
    private function validImage()
    {
         if($this->isValidation)
         {
             $imgParams = getimagesize($this->fileUpload['tmp_name']);
             $this->imgWidth = $imgParams[0];
             $this->imgHeight = $imgParams[1];
             $this->validImgWidth();  
             $this->validImgHeight();   
         }     
    }
    
    /**
     * Método que verifica se a largura da imagem está no tamanho adequado
     */
    private function validImgWidth()
    {
        if($this->maxWidth){
            if($this->imgWidth > $this->maxWidth){
                $this->setErrors('Imagem muito grande. Por favor utilize imagens com no máximo '.$this->maxWidth.'px de largura!');
            }
        }
        if($this->minWidth and $this->isValidation){
             if($this->imgWidth < $this->minWidth){
                $this->setErrors('Imagem muito pequena. Por favor utilize imagens com no mínimo '.$this->minWidth.'px de largura!');
            }
        }
    }
        
    /**
     * Método que verifica se a altura da imagem está no tamanho adequado
     */
    private function validImgHeight()
    {    
        if($this->maxHeight and $this->isValidation)
        {
            if($this->imgHeight > $this->maxHeight){
                $this->setErrors('Imagem muito grande. Por favor utilize imagens com no máximo '.$this->maxHeight.'px de altura!');
            }
        }
        if($this->minHeight and $this->isValidation)
        {
                 if($this->imgHeight < $this->minHeight){
                    $this->setErrors('Imagem muito pequena. Por favor utilize imagens com no mínimo '.$this->minHeight.'px de altura!');
                 }
        }
    }
    
  /** 
   * Método que define a extensão real do arquivo
   */
    private function setExtension()
    {
        switch ($this->typeFile)
        {
            case 'pdf':
                $this->extension = 'pdf';
                break;
            
            case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
                $this->extension = 'docx';
                break;
            
            case 'msword':
                $this->extension = 'doc';
                break;
                  
            case 'jpeg':
                $this->extension = 'jpg';
                break;
            
            case 'png':
                $this->extension = 'png';
                break;
            
            case 'jpg':
                $this->extension = 'jpg';
                break;
        }
    }
    
    private function upload(){
         if(!$this->FileUpload->startUpload($this->fileUpload, $this->saveFolder, $this->nameFile)){
                 $this->isUpload = false;
                 $this->setErrors('Erro no upload de arquivo! Por favor, tente novamente!');
             }else{
                    $this->setFilePermissions($this->saveFolder.$this->nameFile);    
             }
    }
    
   /**
    *Método que seta as permissões para o arquivo gravado
    */
    private function setFilePermissions($fileSelect){
             if(file_exists($fileSelect)) { chmod($fileSelect, 0777); }                
        
    }
    
    private function setNameFile(){
        $this->nameFile = date('Ymd_His').'.'.$this->extension;
    }    
     /**
      * Método que verifica se a extensão é uma extensão válida
      */
     private function checkImageExtension($listExtensions = false){
            if($this->isValidation)
            {
                $type = explode('/', $this->fileUpload['type']);
                if(!empty($type[1]))
                {
                   if(!$listExtensions){
                        $listExtensions = array(
                                    'png', 
                                    'jpg',
                                    'jpeg'
                                 );
                   }                  
                   $this->typeFile = strtolower($type[1]);              
                   if(!in_array($this->typeFile, $listExtensions)){
                       $this->setErrors("Formato de arquivo inválido! Por favor, verifique a extensão do arquivo!");
                   }
                }else{
                    $this->setErrors("Formato de arquivo não identificado ou não permitido!");
                }
            }    
     }
    
    
     /**
      * Método que verifica se a extensão é uma extensão válida
      */
     private function checkExtension(){
            if($this->isValidation)
            {
                $type = explode('/', $this->fileUpload['type']);
                if(!empty($type[1]))
                {
                   $listExtensions = array(
                                    'pdf', 
                                    'vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    'msword'
                                 );
                   $this->typeFile = strtolower($type[1]);              
                   if(!in_array($this->typeFile, $listExtensions)){
                       $this->setErrors("Formato de arquivo inválido! Por favor, utilize apenas arquivos do Microsoft Word ou PDF!");
                   }
                }else{
                    $this->setErrors("Formato de arquivo não identificado ou não permitido!");
                }
            }    
     }
       
    /**
     * Método que verifica a possível existencia de erros
     */
     private function checkErrors()
     {
           if($this->isValidation)
           {
               if($this->fileUpload['error']>0){
                   $this->setErrors("Erro no upload de arquivo. Por favor, tente novamente!");
               }                   
           }
     }
        
    /**
     * Método que verifica se o arquivo não está vazio
     */
    private function checkEmpty(){
        if(empty($this->fileUpload['name'])){
            $this->isUpload = false;
            $this->setErrors("O campo arquivo está vazio. Por favor, escolha um arquivo!");
        }
    }
    
    /**
     * Método que seta possíveis erros
     */
    private function setErrors($error){
        $this->isValidation = false;
        if(!empty($this->errors)){
            $this->errors = $this->errors .'<br>'.$error;
        }else{
            $this->errors = $error;
        }
    }
    
    private function setFolder(){
        $this->saveFolder = WWW_ROOT.'files'.DS.'upload_files'.DS;
    }
    
    
    private function setImgFolder($folder){
       if(!$folder){
            $this->saveFolder = IMAGES;
       }else{
            $this->saveFolder = IMAGES.$folder.DS;
       }
       
    }
    
    public function delFileSaved(){
        $file =  $this->saveFolder.$this->nameFile;   
        if($this->isUpload and !empty($file)){
           unlink($this->saveFolder.$this->nameFile); 
        }
    }
        
    public function getErrors(){
        return $this->errors;    
    }
    
    public function getFile(){
        return $this->nameFile;
    }
    
    
   /**
    *@return string
    *Método que retorna o nome do arquivo
    */
    public function getSaveFile(){
    	return $this->saveFolder.$this->nameFile;
    	
    	
    }
    
    
    private function cleanClass()
    {
        $this->fileUpload = null;
        $this->saveFolder = null;
        $this->isValidation = true;
        $this->nameFile = null;
        $this->nameFolder = null;
        $this->errors = 'Erro ao gravar o arquivo! ';
        $this->extension = null;
        $this->isUpload = true;
        $this->typeFile = null;
        $this->maxWidth = false;
        $this->minWidth = false;
        $this->maxHeight = false;
        $this->minHeight = false;
        $this->imgWidth = null;
        $this->imgHeight = null;
    }
}