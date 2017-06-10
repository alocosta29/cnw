<?php
/* 
 *RESUMO GERAL DA PUBLICAÇÃO DE ARTIGOS
 * ADMINISTRADOR
 * Total de artigos autorizados
 * total de artigos publicados pelo administrador
 */
App::uses('Caderno', 'ConfigBook.Model');
class ReportArticleComponent extends Component{
    
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
        //pr($this->Session->read('Auth.User.id'));
        //pr($this->report);
        //exit(0);
        
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
            case 'admin':
                //seta o total geral de  artigos publicados no caderno
                $this->setAuthorizedItems();
                
                //seta o total de artigos autorizados pelo administrador logado
                $this->setAuthorizedByMe();
                
                //Seta o número de artigos aguardando autorização
                $this->setAwaitingAuthorization();
                
                //seta o total de arquivos enviados para revisão pelo administrador logado
                $this->setRejectArticlesByMe();
                
            break;
        
            case 'col':
                //seta qtdade de artigos publicados
                $this->setPublishArticles();
                
                //seta  qtdade de artigos em analise
                $this->setArticlesInAnalysis();
                
                //seta  qtdade de artigos reprovados
                $this->setRejectArticles();
                
                //seta  qtdade de artigos em rascunho
                $this->setDraftArticles();
            break;

            default:
                break;
        }
    }
    
    
    /**
          * Método que seta o total de artigos publicados no caderno
          */
    private function setAuthorizedItems(){
        if($this->isValidation)
        {
            $Artigo = new Artigo();
            $this->report['total_geral'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'P',
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.data_publicacao <= ' => date('Y-m-d H:i:s')
                                                )));    
        }
    }
    
    /**
        * Método que seta o total de artigos autorizados pelo administrador logado
        */
    private function setAuthorizedByMe(){
        if($this->isValidation)
        {
            $Artigo = new Artigo();
            $this->report['total_autorizados_por_mim'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'P',
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.authorizedby' => $this->Session->read('Auth.User.id'),
                                                )));   
        }
    }
    
    /**
            * Artigos aguardando autorização
            */
    private function setAwaitingAuthorization(){
        if($this->isValidation){
            
            $Artigo = new Artigo();
            $this->report['aguardando_autorizacao'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'A',
                                                    'Artigo.isdeleted' => 'N',
                                         
                                                )));  
        }
    }
    
   /**
        *  Método que seta o número de artigos publicados/autorizados pelo usuário no caderno
        */ 
   private function setPublishArticles(){
       if($this->isValidation){
            $Artigo = new Artigo();
            $this->report['publicados'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'P',
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.user_id' => $this->Session->read('Auth.User.id'),
                                                )));  
       }
   }
    
     /**
            *  Método que seta o número de artigos enviados para análise pelo usuário no caderno
            */ 
    private function setArticlesInAnalysis(){
        if($this->isValidation){
            $Artigo = new Artigo();
            $this->report['em_analise'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'A',
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.user_id' => $this->Session->read('Auth.User.id'),
                                                )));  
       }
    }
    
    /**
          * Método que seta o artigos rprovados
          */
    private function setRejectArticles(){
        if($this->isValidation)
        {
            $Artigo = new Artigo();
            $this->report['reprovados'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'N',
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.user_id' => $this->Session->read('Auth.User.id'),
                                                    'Artigo.versao_artigo' => 1,
                                                    'NOT' => array('Artigo.reprovedby' => null)
                                                )));
        }
    }
    
    private function setRejectArticlesByMe(){
        if($this->isValidation){
            $Artigo = new Artigo();
            $this->report['reprovados_por_mim'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'N',
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.reprovedby' => $this->Session->read('Auth.User.id'),
                                                    'Artigo.versao_artigo' => 1
                                                )));
        }
    }
    
    
    
    /**
          *  Método que seta os artigos em rascunho
          */
    private function setDraftArticles(){
        if($this->isValidation){
            $Artigo = new Artigo();
            $this->report['rascunho'] = $Artigo->find('count', 
                    array('conditions' => array(
                                                    'Artigo.caderno_id'=>$this->data['Caderno']['id'],
                                                    'Artigo.status' => 'R',
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.user_id' => $this->Session->read('Auth.User.id'),
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