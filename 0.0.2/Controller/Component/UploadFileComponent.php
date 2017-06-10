<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AdType', 'Monetization.Model');
class UploadFileComponent extends Component{
    
    private $validParams = null;
    private $folder = null;
    public $nameFile = null;
    private $type = null;
    private $fileSelect = null;
    private $oldFile = null;
    private $typeAd = null;
    private $paramsAd = null;
    public $delFailOperation = null;
    public $extension = null;

    private $isValidation = true;
    public $errors = null;
    public $components = array('Session');
    
    public function start($fileSelect = null, $type = null, $params = array('folder'=>null, 'name'=>null, 'oldFile' => null, 'typeAd'=>null))
    {
        $this->cleanClass();
        $this->fileSelect = $fileSelect;
        $this->type = $type;
        $this->setParams($params);
        $this->setAdParams();
        
        $this->setValidParams();
        
       
        $this->checkFile();  
        $this->checkExtension();
        $this->specificValid();
        $this->createFolder();
        $this->deleteOld();
        $this->setSaveFile();
        $this->moveFile();
         // pr($this->isValidation); exit(0);     
        return $this->isValidation;
    }
    
    /**
     * Seta os parâmetros
     * @param type $params
     */
    private function setParams($params){
        if(!empty($params['folder'])){
            $this->folder = $params['folder'];  
        }
        if(!empty($params['name'])){
            $this->nameFile = $params['name'];
        }
         if(!empty($params['oldFile'])){
            $this->oldFile = $params['oldFile'];
        }
         if(!empty($params['typeAd'])){
            $this->typeAd = $params['typeAd'];
        }
    }
    
    
    /**
        * Setará os parâmetros da imagem, quando a imagem for de um anuncio
        */
    private function setAdParams(){
        if($this->type == 'ad-image')
        {
            if(!empty($this->typeAd))
            {
                $AdType = new AdType();
                $find = $AdType->find('first', array('conditions'=>array('AdType.id'=>$this->typeAd)));
                if(!empty($find['AdType'])){
                    $this->paramsAd = $find['AdType'];
                }else{
                    $this->setErrors('Os parâmetros para cadastro deste tipo de anúncio não foram localizados no sistema!');
                }
            }else{
                $this->setErrors('Parâmetros de tipo de anúncio não enviados!');
            }
        }
    }
    
    
 /**
     * Método que faz  validações específicas 
     */
    private function specificValid(){
        switch ($this->type) {
            #Validação na tela de cadastro de imagem destacada de arquivo
            case 'featuredImage':
                    $this->checkImageDimensions();
                break;
            
               case 'ad-image':
                   $this->checkImageAdDimensions();
                break;
            
            
            
            default:
               // $this->setErrors('Parâmetros incompletos! procure o desenvolvedor do sistema!');
            break;
        }
    }
    
  /**
        * Verifica se o arquivo contém algum erro
        */  
  private function checkFile()
  {
        if($this->isValidation)
        {
            if(!empty($this->fileSelect['name']) and $this->fileSelect['error'] < 1)
            {
                $size = $this->fileSelect['size'];
                $size = (($size/1024)/1024);                
                if($size > $this->validParams['maxsize']){
                   $this->setErrors('Erro. O arquivo excede o limite de '.$this->fileSelect['size'].'M !');
                }
            }else{
                $this->setErrors('Arquivo incorreto. Por favor tente novamente!');
            }  
        }  
  }   

    /**
          *  Método qie seta os parâmetros de validação
          */
    private function setValidParams()
    {
        
        if($this->isValidation)
        {

                    $params = array(
                    'featuredImage' => array(
                                                'ext' => array('image/jpeg', 'image/gif', 'image/png'),
                                                'setExt' => array('image/jpeg' => 'jpg', 'image/gif'=>'gif', 'image/png' => 'png'),
                                                'saveExt' => array('jpg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png'),
                                                'listExt' => array('jpg', 'gif', 'png'),
                                                'msgExt' => 'JPEG, PNG e GIF',
                                                'maxsize' =>  1.5 ,
                                                'dimensions' => array('W'=>500, 'H'=>413),
                                                'msgDimensions' => 'largura 500px e altura 413px',
                                                'folder' => IMAGES.'img_destak'.DS.$this->folder,
                                                'deleteOld' => true,
                                            ),
                        'extras' => array(
                                                'ext' => array( 'image/jpeg', 'image/gif', 'image/png', 'application/pdf', 
                                                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                                'application/vnd.ms-excel', 'application/msword',
                                                                'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
                                                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                                                'application/vnd.ms-powerpoint','application/vnd.ms-powerpoint'


                                                                ),
                                                'setExt' => array(  'image/jpeg' => 'jpg', 'image/gif'=>'gif', 'image/png' => 'png', 'application/pdf'=>'pdf', 
                                                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=>'docx',
                                                                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=>'xlsx',
                                                                    'application/vnd.ms-excel'=>'xls', 'application/msword'=>'doc',
                                                                    'application/vnd.openxmlformats-officedocument.presentationml.slideshow'=>'ppsx',
                                                                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'=>'pptx',
                                                                    'application/vnd.ms-powerpoint'=>'ppt','application/vnd.ms-powerpoint'=>'pps'


                                                                    ),
                                                'saveExt' => array( 'jpg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png', 'pdf'=>'application/pdf', 
                                                                    'docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                                    'xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                                    'xls'=>'application/vnd.ms-excel', 'doc'=>'application/msword',    
                                                                    'ppsx'=>'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
                                                                    'pptx'=>'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                                                    'ppt'=>'application/vnd.ms-powerpoint','pps'=>'application/vnd.ms-powerpoint'
                                                    
                                                    
                                                                    ),
                                                'listExt' => array('jpg', 'gif', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'xls', 'ppsx', 'pptx', 'pps'),
                                                'msgExt' => 'JPEG, PNG, GIF, PDF, DOC, DOCX, XLS, XLSX, PPSX, PPTX, PPS',
                                                'maxsize' =>  1.5 ,
                                                'folder' => WWW_ROOT.'files'.DS.$this->folder,
                                                'deleteOld' => false,
                            
                            
                        )
                        

                    );
                    if(!empty($this->paramsAd))
                    {
                        $params['ad-image'] = array(
                                    'ext' => array('image/jpeg', 'image/gif', 'image/png'),
                                    'setExt' => array('image/jpeg' => 'jpg', 'image/gif'=>'gif', 'image/png' => 'png'),
                                    'saveExt' => array('jpg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png'),
                                    'listExt' => array('jpg', 'gif', 'png'),
                                    'msgExt' => 'JPEG, PNG e GIF',
                                    'maxsize' =>  1.5 ,
                                    'dimensions' => array(
                                        'max-width'=>$this->paramsAd['max_width'], 
                                        'min-width'=>$this->paramsAd['min_width'], 
                                        'max-height'=>$this->paramsAd['max_height'], 
                                        'min-height'=>$this->paramsAd['min_height'], 
                                        ),
                                    'msgDimensions' => 'largura máxima '.$this->paramsAd['max_width'].'px e largura mínima '.$this->paramsAd['min_width'].'px, altura máxima '.$this->paramsAd['max_height'].'px e altura mínima '.$this->paramsAd['min_height'].'px',
                                    'folder' => IMAGES.'img_ads'.DS.$this->folder,
                                    'deleteOld' => false,
                                );
                        
                    }                    
                    if(!empty($params[$this->type])){
                        $this->validParams = $params[$this->type];
                    }else{
                        $this->setErrors('Parâmetros de validação não localizados. Por favor, entre em contato com o desenvolvedor do sistema!');
                    }    
        }
    }

    /**
          *  Método que verifica a extensão do arquivo
          */
    private function checkExtension(){
        if($this->isValidation)
        {
            $extensions = $this->validParams['ext'];
            if(!in_array($this->fileSelect['type'], $extensions)){
                $this->setErrors('Extensão incorreta! Envie arquivos somente com extensão '.$this->validParams['msgExt'].'!');
            }
        }
    }
    
    
    private function deleteOld(){
        if($this->isValidation and $this->validParams['deleteOld'] and !empty($this->oldFile)){
            $fileSelect = $this->validParams['folder'].$this->oldFile;
            if (file_exists($fileSelect)) {
			    if(!unlink($fileSelect)){
                    $this->setErrors('O arquivo obsoleto não pode ser apagado. Por favor, tente novamente ou procure o desenvolvedor do sistema!');
                }
			} 
        }
    }
    
    /**
     * Apaga o arquivo de erro
     * @param type $fileSelect
     * @return boolean
     */
    public function delErrorFile($fileSelect = null){
        if(file_exists($fileSelect)) 
        {
            try{
                unlink($fileSelect);
                return true;
            }catch(Exception $exc){
                return false;
            }
		} 
    }
    
    
    
    
    
     /**
          * Método que verifica as dimensões da imagem de um anuncio
          */
    private function checkImageAdDimensions(){
        if($this->isValidation){
            $tamanho = getimagesize($this->fileSelect["tmp_name"]);
            $W = $tamanho[0]; $H = $tamanho[1];
            if($W > $this->validParams['dimensions']['max-width'] or $W < $this->validParams['dimensions']['min-width']){
                $this->setErrors('Verifique as dimensões da largura da imagem. As dimensões permitidas são: '.$this->validParams['msgDimensions'].'!');
            }elseif($H > $this->validParams['dimensions']['max-height'] or $H < $this->validParams['dimensions']['min-height']){
                $this->setErrors('Verifique as dimensões da altura da imagem. As dimensões permitidas são: '.$this->validParams['msgDimensions'].'!');
                 
            }
        }
    } 
    
    /**
          * Método que verifica as dimensões da imagem
          */
    private function checkImageDimensions(){
        if($this->isValidation){
            $tamanho = getimagesize($this->fileSelect["tmp_name"]);
            $W = $tamanho[0]; $H = $tamanho[1];
            if($W <> $this->validParams['dimensions']['W'] or $H <> $this->validParams['dimensions']['H']){
                $this->setErrors('Verifique as dimensões da imagem. As dimensões permitidas são: '.$this->validParams['msgDimensions'].'!');
            }
        }
    }
    
    
    
    /**
     * Cria a pasta destino
     * @throws Exception
     */
    private function createFolder()
    {
        if($this->isValidation){
            $folder = $this->validParams['folder'];
            try {
                 if(!is_dir($folder)) {
                    if(!mkdir($folder, 0777)){
                        throw new Exception();
                    }
                }
            }catch(Exception $e) {
              $this->setErrors('Erro ao criar a pasta destino! Verifique as permissões!');
            }
        }
    }
    
    /**
     * Seta a o nome do arquivo que será salvo
     */
    private function setSaveFile(){
        if($this->isValidation){
            if(!empty($this->validParams['setExt'][$this->fileSelect['type']])){
                $extension = $this->validParams['setExt'][$this->fileSelect['type']];
                $this->extension = $extension;
                $this->nameFile = $this->nameFile.'.'.$extension;
            }else{
                $this->setErrors('Extensão do arquivo enviado não localizada!');
            }   
        }
    }
    
    /**
     * Método que garva o arquivo
     */
    private function moveFile(){
        if($this->isValidation){
          $fileDest = $this->validParams['folder'].$this->nameFile;
          $this->delFailOperation = $fileDest;
          if(!move_uploaded_file($this->fileSelect['tmp_name'], $fileDest)){
              $this->setErrors('Erro ao gravar o arquivo');
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
        $this->validParams = null;
        $this->folder = null;
        $this->type = null;
        $this->fileSelect = null;
        $this->typeAd = null;
        $this->paramsAd = null;
        $this->delFailOperation = null;
        $this->isValidation = true;
        $this->errors = null;
        $this->extension = null;
    }
}