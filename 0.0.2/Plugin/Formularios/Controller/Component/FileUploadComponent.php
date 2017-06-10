<?php
class FileUploadComponent extends Component{
    private $fileUpload = null;
    private $saveFolder = null;
    private $nameFile = null;
    private $isValidation = true;
    
    /**
     * Método que inica o upload do arquivo
     */
    public function startUpload($fileUpload, $saveFolder, $nameFile){
        $this->cleanClass();
        $this->fileUpload = $fileUpload;
        $this->saveFolder = $saveFolder;
        $this->nameFile = $nameFile;
        $this->upload();
        return $this->isValidation;
    }
    
    /**
     * Método que faz o upload
     */
    private function upload()
    {
       try{
            $fileUpload = $this->saveFolder.$this->nameFile;
            $tmpUpload =  $this->fileUpload['tmp_name'];   
            
            if(is_uploaded_file($tmpUpload)){
                if(!move_uploaded_file($tmpUpload,$this->saveFolder.$this->nameFile)){
                    throw new Exception();
                }
            }else{
                throw new Exception();
            }
   
        }catch(Exception $e){
            $this->isValidation = false;
        }
    }
        
    private function cleanClass()
    {
        $this->fileUpload = null;
        $this->saveFolder = null;
        $this->isValidation = true;
        $this->nameFile = null;
    }      
}