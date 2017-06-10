<?php

App::uses('Ad', 'Monetization.Model');
App::uses('Individual', 'Manager.Model');
class ValidManagerAdComponent extends Component{
    
    private $id = null;
    private $caderno = null;
    private $typeValid = null; 
    public $dataAd = null;
    private $completeDataAd = null;
    
    private $isValidation = true;
    public $errors = null;
    
    public function start($id = null, $caderno = null, $typeValid = null)
    {
        $this->cleanClass();
        $this->id = $id;
        $this->caderno = $caderno;
        $this->typeValid = $typeValid;
         $this->valid(); 
        
        return $this->isValidation;
    }
    
    private function valid()
    {
        switch ($this->typeValid)
        {
            case 'viewAd';
                $this->setData(array('Ad.status'=>array('A', 'P', 'N')));
                $this->setParametersAd();
            break;    
        
            case 'publish';
               $this->setData(array('Ad.status'=>array('A')));
            break;
           
           case 'reprove';
                $this->setData(array('Ad.status'=>array('A', 'P')));
                $this->setParametersAd();
                $this->setParametersComments();
            break;
        
        
        
        
           
            default:
                $this->setErrors('Não foram localizados parâmetros para validação. Procure o desenvolvedor!');
            break;
        }
    }
    
    
    private function setParametersComments(){
        if($this->isValidation){
            if($this->dataAd['versao'] == 1){
               $this->dataAd['new_comments'] =  "-------------------- REPROVAÇÃO - VERSAO 01 --------------------<br>";
            }else{
                $versao = $this->dataAd['versao'];
                $this->dataAd['new_comments'] = $this->dataAd['comments']."<br>------------------------------------------------------------"
                        . "<br><br>-------------------- REPROVAÇÃO - VERSAO {$versao} --------------------<br>";  
            }
        }
    }
    
    
    
     private function setData($conditions = false)
    {
        if($this->isValidation)
        {
                $options = array(
                    'conditions' => array(
                                            'Ad.id'=>$this->id, 
                                            'Ad.isdeleted'=>'N', 
                                            'Caderno.alias'=>$this->caderno),
                );
                if(!empty($conditions)){
                   $options['conditions'] = array_merge($options['conditions'], $conditions);
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
    
     private function setParametersAd(){
        if($this->isValidation)
        {
            $this->dataAd['tipo'] = $this->completeDataAd['AdType']['tipo'];
            $this->dataAd['caderno'] = $this->completeDataAd['Caderno']['nome'];
            $this->setNameAuthor($this->completeDataAd['User']['person_id']);
        } 
        
     }
     
     private function setNameAuthor($person_id = null){
         $this->dataAd['criado_por'] = 'Autor desconhecido';
         $this->dataAd['mail_criador'] = false;
         $this->dataAd['name_criador'] = false;
         
         $Individual = new Individual();
         $Individual->recursive - 0;
         $find = $Individual->find('first', array('conditions'=>array('Individual.person_id'=>$person_id)));
         if(!empty($find)){
            $this->dataAd['criado_por'] = $find['Individual']['nome'].' ('.$find['User']['username'].')';
            $this->dataAd['mail_criador'] = $find['User']['username'];
            $this->dataAd['name_criador'] = $find['Individual']['nome'];  
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
            $this->caderno = null;
            $this->typeValid = null;
            $this->dataAd = null;
            $this->completeDataAd = null;
            $this->isValidation = true;
            $this->errors = null;
    }
    
    
    
}