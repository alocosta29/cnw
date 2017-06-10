<?php
/* 
 *RESUMO GERAL DA PUBLICAÇÃO DE ARTIGOS
 * ADMINISTRADOR
 * Total de artigos autorizados
 * total de artigos publicados pelo administrador
 */
App::uses('Caderno', 'ConfigBook.Model');
App::uses('Ad', 'Monetization.Model');
class ReportAdComponent  extends Component{
    
    private $caderno= null;
    private $type = null;
    public $data = null;
    public $report = null;
    private $isValidation = true;
    public $errors = null;
    
    public $components = array('Session');
    
    public function start($caderno, $type){
        $this->cleanClass();
        $this->caderno = $caderno;
        $this->type = $type;
        $this->checkParameters();
        $this->setContent();
        return $this->isValidation;
    }
        
    private function checkParameters(){
        $Caderno = new Caderno();
        $find = $Caderno->find('first', 
                array(
                        'conditions'=>array(
                                                'Caderno.isdeleted' => 'N',
                                                'Caderno.alias' => $this->caderno
                            )));
        if(!empty($find)){
            $this->data['Caderno'] = $find['Caderno'];
        }else{
            $this->setErrors('O caderno não foi localizado!');
        }
    }

    private function setContent()
    {    
        
        switch($this->type)
        {
            case 'adm':
                //seta o total geral de  anuncios publicados no caderno
                $this->setAuthorizedItems();
                
                //seta o total de artigos autorizados pelo administrador logado
                $this->setAuthorizedByMe();
                
                //Seta o número de artigos aguardando autorização
                $this->setAwaitingAuthorization();
                
                             
            break;
        
            case 'createAd':
                //seta qtdade de artigos publicados
                $this->setPublishAds();
                
                //seta  qtdade de artigos em analise
                $this->setAdsInAnalysis();
                
                //seta  qtdade de artigos reprovados
                $this->setAdsReproved();
                
                //seta  qtdade de artigos em rascunho
                $this->setAdDraft();
            break;

            default:
                break;
        }
    }
    
    
    /**
          * Método que seta o total de anuncios publicados no caderno
          */
    private function setAuthorizedItems(){
        if($this->isValidation)
        {
            $Ad = new Ad();
            $this->report['total_geral'] = $Ad->find('count', 
                    array('conditions' => array(
                                                    'Ad.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Ad.status' => 'P',
                                                    'Ad.isdeleted' => 'N',
                                                    'Ad.data_inicio <= ' => date('Y-m-d H:i:s')
                                                )));    
        }
    }
    
    /**
        * Método que seta o total de artigos autorizados pelo administrador logado
        */
    private function setAuthorizedByMe(){
        if($this->isValidation)
        {
            $Ad = new Ad();
            $this->report['total_autorizados_por_mim'] = $Ad->find('count', 
                    array('conditions' => array(
                                                    'Ad.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Ad.status' => 'P',
                                                    'Ad.isdeleted' => 'N',
                                                    'Ad.approvedby' => $this->Session->read('Auth.User.id'),
                                                )));   
        }
    }
    
    /**
            * Ads aguardando autorização
            */
    private function setAwaitingAuthorization(){
        if($this->isValidation){
            
            $Ad = new Ad();
            $this->report['aguardando_autorizacao'] = $Ad->find('count', 
                    array('conditions' => array(
                                                    'Ad.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Ad.status' => 'A',
                                                    'Ad.isdeleted' => 'N',
                                         
                                                )));  
        }
    }
    
   /**
        *  Método que seta o número de artigos publicados/autorizados pelo usuário no caderno
        */ 
   private function setPublishAds(){
       if($this->isValidation){
            $Ad = new Ad();
            $this->report['publicados'] = $Ad->find('count', 
                    array('conditions' => array(
                                                    'Ad.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Ad.status' => 'P',
                                                    'Ad.isdeleted' => 'N',
                                                    'Ad.user_id' => $this->Session->read('Auth.User.id'),
                                                )));  
       }
   }
    
     /**
            *  Método que seta o número de artigos enviados para análise pelo usuário no caderno
            */ 
    private function setAdsInAnalysis(){
        if($this->isValidation){
            $Ad = new Ad();
            $this->report['em_analise'] = $Ad->find('count', 
                    array('conditions' => array(
                                                    'Ad.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Ad.status' => 'A',
                                                    'Ad.isdeleted' => 'N',
                                                    'Ad.user_id' => $this->Session->read('Auth.User.id'),
                                                )));  
       }
    }
    
    /**
          * Método que seta o artigos rprovados
          */
    private function setAdsReproved(){
        if($this->isValidation)
        {
            $Ad = new Ad();
            $this->report['reprovados'] = $Ad->find('count', 
                    array('conditions' => array(
                                                    'Ad.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Ad.user_id' => $this->Session->read('Auth.User.id'),
                                                    'Ad.status' => 'N',
                                                    'Ad.isdeleted' => 'N',
                                                )));
        }
    }
    
    
    
    
    /**
          *  Método que seta os artigos em rascunho
          */
    private function setAdDraft(){
        if($this->isValidation){
            $Ad = new Ad();
            $this->report['rascunho'] = $Ad->find('count', 
                    array('conditions' => array(
                                                    'Ad.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Ad.status' => 'R',
                                                    'Ad.isdeleted' => 'N',
                                                    'Ad.user_id' => $this->Session->read('Auth.User.id'),
                                                ))); 
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
            $this->caderno= null;
            $this->type = null;
            $this->data = null;
            $this->report = null;
            $this->isValidation = true;
            $this->errors = null;
    }
}