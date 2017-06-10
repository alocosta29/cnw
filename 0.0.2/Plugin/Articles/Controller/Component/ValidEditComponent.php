<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Artigo', 'Articles.Model');
App::uses('Extra', 'Articles.Model');
App::uses('ArtigosCategoria', 'Articles.Model');
class ValidEditComponent extends Component{
    
    private $id = null;
    private $valid = null;
    public $artigoData = null;
    public $postCategories = false;
    public $nameCategories = null;
    private $status = false;
    public $newVersionData = null;
    public $attachedFiles = null;
    
    private $isValidation = true;
    public $errors = null;
    
    public $components = array('Session');
    
    public function start($id = null, $typeValid = null, $status = false)
    {
        $this->cleanClass();        
        $this->id = $id;
        $this->valid = $typeValid;
        $this->status = $status;
         // pr($id); 
      //  pr($typeValid);pr($status);
       // exit();
        $this->valid();  
        return $this->isValidation;
    }
    
    private function valid()
    {
        switch ($this->valid)
        {
                case 'summary':
                     $this->setData(true);     
                     $this->checkStatus('R'); 
                break;

                case 'edit':
                     $this->setData(true);     
                     $this->checkStatus('R'); 
                     $this->setCategoria();
                break; 

              case 'editKeyWords':
                     $this->setData(true);     
                     $this->checkStatus('R'); 
                    
                break; 
            
            
                case 'editDate':
                    // pr('hdsgfhdgf'); exit();
                     $this->setData(true);   
                     $this->checkProperty();
                     $this->checkListStatus(array('P', 'R', 'A')); 
                     //$this->setCategoria();
                break; 
            
                case 'view':
                     $this->setData(); 
                     $this->setDataCategoria();
                     $this->treatCategorie();
                     $this->setAttachedFiles();
                break; 
            
                case 'view_col':
                     $this->setData(true); 
                     $this->setDataCategoria();
                     $this->treatCategorie();
                     $this->setAttachedFiles();
                break;
            
                case 'send_analysis':
                     $this->setData(true);  
                     $this->checkProperty();
                     $this->checkChangeStatus();
                     $this->checkSummary();
                     $this->checkDestakImage();
                break;
                
                case 'return_draft':
                     $this->setData(true);  
                     $this->checkProperty();
                     $this->checkChangeStatus();
                break;
            
                case 'publish':
                     $this->setData();  
                     $this->checkChangeStatus();
                     $this->checkData();
                break;
                        
                case 'reprove':
                     $this->setData();  
                     $this->checkChangeStatus();
                break;
                
                case 'reverseApproval':
                     $this->setData();  
                     $this->checkStatusForReverse();
                break;
            
                case 'new_version':
                     $this->setData(true);
                     $this->setCategoria();
                     $this->checkChangeStatus();
                     $this->checkVersions();
                     $this->setNewVersionData();
                     $this->setAttachedFiles();
                break;
            
                case 'featuredImage':
                     $this->setData(); 
                     $this->checkStatusImage();
                      $this->setDataCategoria();
                     $this->treatCategorie();
                    // $this->checkChangeStatus();
                break;          
            
                case 'delete':
                     $this->setData(true);
                     $this->checkDeleteStatus();
                break;
            
                 case 'addExtra':
                     $this->setData(true);
                     $this->checkListStatus(array('R'));
                 break;
            
            
            
                 default:
                     break;
        }
    }

    /**
     * Método que verifica se tem imagem destacada cadastrada para o artigo
     */
    private function checkDestakImage()
    {
        if($this->isValidation)
        {
            if(empty($this->artigoData['imagem'])){
                $this->setErrors('Antes de enviar para análise, associe uma imagem de destaque!');
            }
        }
    }
    
    /**
     * Método que verifica se o resumo está preenchido
     */
    private function checkSummary(){
        if($this->isValidation){
            if(empty($this->artigoData['resumo'])){
                $this->setErrors('Antes de enviar para aprovação, escreva o resumo do artigo!');
            }
        }
    }  
    
    /**
     * Método que checa o status para a alteração da imagem
     */
    private function checkStatusImage(){
        if($this->isValidation){
            if($this->artigoData['status'] <> 'R'){
                $this->setErrors('A imagem do artigo só pode ser alterada quando o mesmo está no modo rascunho!');
            }
        }
    }
    
    /**
     * Método que trata as categorias dos artigos
     */
    private function treatCategorie(){
        if($this->isValidation){
            $this->artigoData['categorias'] = null;
            if(!empty($this->nameCategories)){
                $i=0;
                $totalSize = sizeof($this->nameCategories);
                while($i<$totalSize){
                    $this->artigoData['categorias'] .= $this->nameCategories[$i].', ';
                    $i++;
                }
            }
        }
    }

    
    /**
     * Valida se o post está em uma status ideal para ser deletado
     */
    private function checkDeleteStatus(){
        if($this->isValidation){
            if(!in_array($this->artigoData['status'], array('R', 'A', 'N'))){
                 $this->setErrors('O status do artigo não permite que o mesmo seja deletado!');
            }
            
        }
    }
    
    /**
     * Verifica se é necessário reverter o artigo
     */
    private function checkStatusForReverse(){
        if($this->isValidation){
            if($this->artigoData['status'] <> 'P'){
                $this->setErrors('O artigo não está aprovado. Não é necessário fazer a reversão!');
            }            
        }
    }
    
    /**
           * Seta os dados para gravaão de uma nova versão
           */
    private function setNewVersionData()
    {
        if($this->isValidation){
            $this->newVersionData['Artigo'] = $this->artigoData;
            
            
            
            unset($this->newVersionData['Artigo']['id']);
            unset($this->newVersionData['Artigo']['created']);
            unset($this->newVersionData['Artigo']['modified']);
            unset($this->newVersionData['Artigo']['modifiedby']);
            unset($this->newVersionData['Artigo']['isdeleted']);
            unset($this->newVersionData['Artigo']['page_views']);
            unset($this->newVersionData['Artigo']['authorizedby']);
            unset($this->newVersionData['Artigo']['date_authorization']);
            unset($this->newVersionData['Artigo']['comments']);
            unset($this->newVersionData['Artigo']['reprovedby']);
            unset($this->newVersionData['Artigo']['reprobation_date']);
            $this->newVersionData['Artigo']['status'] = 'R'; 
            $this->newVersionData['Artigo']['versao_artigo'] = $this->getVersionArtigo(); 
            
            if(!empty($this->postCategories)){
                $i=0;
                $totalSize = sizeof($this->postCategories);
                while($i<$totalSize){
                    $this->newVersionData['ArtigosCategoria'][$i]['categoria_id'] = $this->postCategories[$i];
                    $i++;
                }
            }    
        }
    }
            
    /**
     * Retorna o número da próxima revisão do artido
     * @return type
     */
    private function getVersionArtigo(){
        $return = 2;
        $Artigo = new Artigo();
        $Artigo->recursive = -1;
        $find = $Artigo->find('first', array(
                    'conditions'=>array(
                                         'Artigo.user_id' => $this->Session->read('Auth.User.id'),
                                         'Artigo.numero_artigo' => $this->artigoData['numero_artigo']
                                        ),
            
                    'order'=>array('Artigo.versao_artigo'=>'DESC')
                    ));
       if(!empty($find)){
           $return = $find['Artigo']['versao_artigo'] + 1;
       }
       return $return;
    } 
    
    /**
     * Verifica se não existe versão do mesmo artigo em rascunho ou publicada
     */
    private function checkVersions(){
        if($this->isValidation)
        {
            $Artigo = new Artigo();
            $find = $Artigo->find('first', array(
                    'conditions'=>array(
                                         'Artigo.isdeleted'=>'N',
                                         'Artigo.status'=>array('R', 'A', 'P'),   
                                         'Artigo.user_id' => $this->Session->read('Auth.User.id'),
                                         'Artigo.numero_artigo' => $this->artigoData['numero_artigo']
                                        )));
            if(!empty($find)){
                 $arrayStatus = array('P'=>'APROVADO', 'A'=>'EM ANÁLISE', 'R'=>'RASCUNHO');   
                 $error = "Não é possível criar uma nova versão deste artigo. Já existe uma versão no status ".$arrayStatus[$find['Artigo']['status']].' deste mesmo artigo!';
                 $this->setErrors($error);
            }
        }
    }
    
    /**
     * Método que checa a propriedade do artigo
     */
    private function checkProperty(){
        if($this->isValidation){
            if($this->Session->read('Auth.User.id') <> $this->artigoData['user_id']){
                $this->setErrors('Não é permitido alterar o status deste artigo. Ele foi escrito por outro colunista!');
            }
        }
    }
    
    /**
     * Valida se eh possível a alteração de status
     */
    private function checkChangeStatus(){
        if($this->isValidation){
            switch ($this->status){
                case 'A':
                     if($this->artigoData['status'] <> 'R'){
                         $this->setErrors('Não é possível enviar o arquivo para análise. Apenas artigos no status RASCUNHO podem ser enviados!');
                     }   
                break;
                    
               case 'P':
                     if($this->artigoData['status'] <> 'A'){
                         $this->setErrors('Não é possível publicar o artigo. Apenas artigos no status EM ANÁLISE podem ser publicados!');
                     }   
               break;
                              
               case 'N':
                     if($this->artigoData['status'] <> 'A'){
                         $this->setErrors('Não é possível reprovar o artigo. Apenas artigos no status EM ANÁLISE podem ser reprovados!');
                     }   
               break;
               
               case 'R':
                     if(!in_array($this->artigoData['status'], array('N', 'A', 'P'))){
                         $this->setErrors('O status atual do artigo não permite completar esta operação!');
                     }   
               break;
               
               
                default:
                    break;
            }
        }
    }
    
    
    /**
     * Método qu seta categoria 
     */
    private function setDataCategoria()
    {
        if($this->isValidation)
        {
                $ArtigosCategoria = new ArtigosCategoria();
                $ArtigosCategoria->recursive = 1;
                $find = $ArtigosCategoria->find('list', 
                        array(
                            'fields'=>array('ArtigosCategoria.categoria_id', 'CategoriaJoin.nome'),
                            'joins'=>array(
                                           array(
                                                   'table' => 'cwcol_categorias',
                                                   'alias' => 'CategoriaJoin',
                                                   'type' => 'LEFT',
                                                   'conditions' => array(
                                                       'CategoriaJoin.id = ArtigosCategoria.categoria_id'
                                                   )
                                           )    
                            ),
                            'conditions'=>array('ArtigosCategoria.artigo_id'=>$this->id)));
               if(!empty($find))
               {
                   sort($find);
                   $this->nameCategories = $find;
               }
        }
    }
    
    
      /**
     * Método qu seta categoria 
     */
    private function setCategoria()
    {
        if($this->isValidation)
        {
             $ArtigosCategoria = new ArtigosCategoria();
             $find = $ArtigosCategoria->find('list', 
                     array(
                         'fields'=>array('ArtigosCategoria.categoria_id', 'ArtigosCategoria.categoria_id'),
                         'conditions'=>array('ArtigosCategoria.artigo_id'=>$this->id)));
             if(!empty($find)){
                sort($find);
                $this->postCategories = $find;
                $this->artigoData['categorias'] = $find;
             }
        }
    }
    
    /**
           * Método que seta os dados do registro na memória
           */
    private function setData($user_id = false)
    {
        if($this->isValidation)
        {
            $Artigo = new Artigo();
            $Artigo->recursive = 1;
            $options = array(
                    'conditions'=>array(
                                         'Artigo.isdeleted'=>'N',
                                         'Artigo.id'=>$this->id,
                                        ));        
            if($user_id){
                $options['conditions']['Artigo.user_id'] = $this->Session->read('Auth.User.id');
            }

            $find = $Artigo->find('first', $options);
      
            if(!empty($find)){              
                $this->artigoData = $find['Artigo'];
            }else{
                $this->setErrors('Artigo não localizado');
            }
        }
    }
        
    private function checkStatus($status){
        if($this->isValidation){
            if($this->artigoData['status'] <> $status){
                $statusdesc = array('R'=>'RASCUNHO', 'P'=>'PUBLICADO/PROGRAMADO', 'A'=>'EM ANÁLISE', 'N'=>'REPROVADO');
                $this->setErrors('Esta operação só é permitida quando o registro de ecnontra no status '.$statusdesc[$status]);
            }
        }
    }
    
    /**
     * Método que verifica se o artigo possui os requisitos para a publicação!
     */
    private function checkData(){
        if($this->isValidation){
            if(empty($this->artigoData['resumo'])){
                $this->setErrors('Não é permitido aprovar artigos sem resumo!');
            }
             if(empty($this->artigoData['imagem'])){
                $this->setErrors('Não é permitido aprovar artigos sem imagem destaque!');
            }
        }
    }
    
    /**
            * Método que verifica se o status permite a continuidade da operação
            * @param type $listStatus
            */
    private function checkListStatus($listStatus){
        if($this->isValidation){
            if(!in_array($this->artigoData['status'], $listStatus)){
                $this->setErrors('O status atual do artigo não permite esta operação!');
            }
        }
    }
    
private function setAttachedFiles(){
    if($this->isValidation){
           
        $Extra = new Extra();
        $Extra->recursive = -1;
        $find = $Extra->find('all', 
                array(
                    'fields'=>array('Extra.id','Extra.nome','Extra.descricao','Extra.arquivo',
                                    'Extra.tipo_arquivo','Extra.artigo_id','Extra.caderno_id','Extra.user_id', 'Extra.person_id'
                        ),
                    'conditions'=>array(
                    'Extra.artigo_id'=>$this->artigoData['id'],
                    'Extra.isdeleted'=>'N'
                    )));
        if(!empty($find)){
            $this->attachedFiles = $find;
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
            $this->id = null;
            $this->isValidation = true;
            $this->errors = null;
            $this->postCategories = false;
            $this->status = false;
            $this->nameCategories = null;
            $this->newVersionData = null;
            $this->attachedFiles = null;
    }
    
    
}