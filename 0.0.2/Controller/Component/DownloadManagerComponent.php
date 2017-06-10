<?php
App::uses('Rh', 'Formularios.Model');
class DownloadManagerComponent extends Component{
    private $cryptId = null;
    private $id = null;
    private $categorieData = null;
    private $url = null;
    private $folder = null;
    private $tempFolder = null;
    private $selectFile = null;
    private $downloadPath = null;
    private $errors = null;
    private $isValidation = true;
    public $components = array('Session');
    
    public function startCvDownload($id)
    {
        $this->cleanClass();
        $this->id = $id;
        $this->url = array('plugin'=>'formularios', 'controller'=>'messages', 'action'=>'listCvs', 'admin'=>true);
        $this->setFolders();
        $this->setCvFile();
        return $this->isValidation;
    }
    
    private function setFolders(){
        $this->folder = WWW_ROOT.'files'.DS.'upload_files'.DS;
        //$dateparam = date('Ymd');
        //$this->tempFolder = WWW_ROOT.'files'.DS.'temp_files'.DS;
        //$this->downloadPath = HOST_REAL.'files/'.$dateparam.'/';
    }
    
    /**
     * Método que seta o currículo na memória da classe
     */
     private function setCvFile(){
      $Rh = new Rh();
      $find =   $Rh->findById($this->id);
      if(!empty($find))
      {
          $this->selectFile = $find['Rh']['arquivo_anexo'];
          $this->setFileParams();
      }else{
          $this->setErrors('Arquivo não encontrado');
      } 
    }        
        
    private function setFileParams(){
        $this->downloadPath['id'] = $this->selectFile;
        $this->downloadPath['name'] = date('Ymd_His');
        $this->downloadPath['download'] = true;
        $this->downloadPath['extension'] = $this->getExtension();
        //$this->downloadPath['path'] = $this->tempFolder;
        $this->downloadPath['path'] = $this->folder;  
    }
        
    public function getDownloadParams(){
        return $this->downloadPath;
    }

    private function getExtension(){
        $fileSelect = explode('.', $this->selectFile);
        return end($fileSelect);
    }
    
    public function cryptDecrypt($termo, $crypt = false)
    {
              $retorno = "";
              $chave = "vt2014development29051981";
              if($crypt)
              {
                    $string = $termo;
                    $i = strlen($string)-1;
                    $j = strlen($chave);
                    do
                    {
                      $retorno .= ($string{$i} ^ $chave{$i % $j});
                    }while ($i--);
                
                    $retorno = strrev($retorno);
                    $retorno = base64_encode($retorno);
              }else{
                    $string = base64_decode($termo);
                    $i = strlen($string)-1;
                    $j = strlen($chave);
                    do
                    {
                      $retorno .= ($string{$i} ^ $chave{$i % $j});
                    }while ($i--);
         
                    $retorno = strrev($retorno);
              }
              return $retorno;
    }
    
    private function cleanClass()
    {
        $this->cryptId = null;
        $this->id = null;
        $this->categorieData = null;
        $this->url = null;
        $this->errors = null;
        $this->isValidation = true;
        $this->folder = null;
        $this->tempFolder = null;
        $this->selectFile = null;
        $this->downloadPath = null;
    }
    
    public function getErrors(){
        return $this->errors;
    }
         
    public function getUrl(){
         return $this->url;
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
}