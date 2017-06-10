<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Ad', 'Monetization.Model');
class ValidEditAdComponent extends Component{
    
    private $id = null;
    private $typeValid = null;
    private $status = null;
    private $caderno = null;
    public $dataAd = null;
    private $completeDataAd = null;
    
    private $isValidation = true;
    public $errors = null;
    
    public $components = array('Session');
    
    public function start($id = null, $caderno = null, $typeValid = null, $status = false)
    {
        $this->cleanClass();        
        $this->id = $id;
        $this->typeValid = $typeValid;
        $this->caderno = $caderno;
        $this->status = $status;
        
        $this->valid(); 
      /*  pr($this->dataAd); 
        pr($this->completeDataAd);
        exit(0);*/
       return $this->isValidation; 
    }
    
    
    private function valid()
    {
        switch ($this->typeValid)
        {
            case 'editAd';
                $this->setData(true);
                $this->checkStatus(array('R'));
            break;    
            
            case 'viewAd';
                $this->setData(true);
                $this->setParametersAd();
            break;
        
            case 'deleteAd';
                   $this->setData(true);
            break;
            
            case 'changeStatusCol';
                $this->setData(true);
                $this->checkPermissionChangeStatus(array('R', 'A'));
                $this->checkChangeStatus();
            break;
           
            case 'newReview';
                $this->setData(true);
                $this->checkStatus(array('N'));
             break;
        
        
            default:
                $this->setErrors('Não foram localizados parâmetros para validação. Procure o desenvolvedor!');
            break;
        }
    }
    
    
    private function checkChangeStatus()
    {
        if($this->isValidation)
        {
            if($this->status == 'A'){ 
                $this->checkStatus(array('R'));
            }
            if($this->status == 'R'){ 
                $this->checkStatus(array('A', 'P'));
            }
            if($this->status == 'P'){ 
                $this->checkStatus(array('A'));
            }
        }
    }
    
    private function checkPermissionChangeStatus($listStatus = array())
    {
        if($this->isValidation)
        {            
           if(!empty($this->status) and $this->status<>$this->completeDataAd['Ad']['status'])
           {
                if(!in_array($this->status, $listStatus)){
                    $this->setErrors('Você não possui permissão para concluir esta operação!');
                }
           }else{
                $this->setErrors('Ação inválida!');
           }
        }
    }
    
    private function setData($userId = false)
    {
        if($this->isValidation)
        {
                $options = array(
                    'conditions' => array('Ad.id'=>$this->id, 'Ad.isdeleted'=>'N', 'Caderno.alias'=>$this->caderno),
                );
                if($userId){
                    $options['conditions']['Ad.user_id'] = $this->Session->read('Auth.User.id');
                }
                $Ad = new Ad();
                $Ad->recursive = 0;
                $find = $Ad->find('first', $options);
                
                if(!empty($find['Ad']))
                {
                    $this->dataAd = $find['Ad'];
                    $this->completeDataAd = $find;
                }else{
                    $this->setErrors('Registro não localizado!');
                }
        }  
    }
    
    private function checkStatus($status = array())
    {
        if($this->isValidation)
        {
            if(!in_array($this->dataAd['status'], $status))
            {
                $this->setErrors('O status do anúncio não permite esta operação!');
            }
        }
    }
    
    private function setParametersAd(){
        if($this->isValidation)
        {
            $this->dataAd['tipo'] = $this->completeDataAd['AdType']['tipo'];
            $this->dataAd['caderno'] = $this->completeDataAd['Caderno']['nome'];
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
            $this->typeValid = null;
            $this->status = null;
            $this->dataAd = null;
            $this->completeDataAd = null;
            $this->caderno = null;
            $this->isValidation = true;
            $this->errors = null;
    }  
}
