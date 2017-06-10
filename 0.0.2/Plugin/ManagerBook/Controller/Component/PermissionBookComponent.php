<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Person', 'Manager.Model');
App::uses('User', 'Manager.Model');
App::uses('Caderno', 'ConfigBook.Model');
App::uses('AccessUser', 'AccessUsers.Model');
App::uses('AccessCaderno', 'AccessUsers.Model');
App::uses('Individual', 'Manager.Model');
class PermissionBookComponent extends Component{
    
    private $person_id  = null;
    private $caderno  = null;
    private $cadernoData = null;
    public $dataUser = null;
    public $errors = null;
    private $isValidation = true;
    
    
    public function start($person_id = null, $caderno = null)
    {
        $this->cleanClass();
        $this->person_id = $person_id;
        $this->caderno = $caderno;
        $this->setCaderno();
        $this->setDataPerson();
        $this->setUser();
        $this->setPermission('col');
        $this->setPermission('adm');
        
        #pr($this->dataUser); exit(0);
        
        return $this->isValidation;
    }
    
    /**
     * Método que seta os dados do caderno
     */
    private function setCaderno(){
       $Caderno = new Caderno(); 
       $find = $Caderno->find('first', 
               array(
                   'conditions'=>array(
                       'Caderno.alias'=>$this->caderno, 
                       'Caderno.isdeleted'=>'N'
                       ))); 
        if(!empty($find)){
            $this->cadernoData = $find['Caderno'];
        }else{
            $this->setErrors('Caderno não localizado!');
        }
    }
    
    /**
     * Método que seta os dados na memória da classe
     */
    private function setDataPerson(){
        $Individual = new Individual();
        $Individual->recursive = -1;
        $find = $Individual->findByPersonId($this->person_id);
        if(!empty($find)){
            $this->dataUser['nome'] = $find['Individual']['nome'];
            $this->dataUser['sexo'] = $find['Individual']['sexo'];
            $this->dataUser['cpf'] = $find['Individual']['cpf'];
            $this->dataUser['data_nascimento'] = $find['Individual']['data_nascimento'];
        }else{
            $this->setErrors('Usuário não encontrado!');
        }
    }
    
    /**
     * Método que seta os dados do usuário
     */
    private function setUser()
    {
       if($this->isValidation)
       {
           $this->dataUser['username'] = NULL;
           $this->dataUser['caderno'] = $this->cadernoData['nome'];
           $this->dataUser['status'] = NULL;
           $this->dataUser['statusDescription']  = NULL;
           $this->dataUser['recent_register'] = NULL;
           $this->dataUser['pass_register'] = NULL;
           $this->dataUser['person_id'] = NULL;
           $this->dataUser['apelido'] =  null;
           $this->dataUser['foto'] =  null;
           $this->dataUser['is_user'] = false; 
           $User = new User();
           $User->recursive = 1;
           #$find = $User->findByPersonId($this->person_id);
           $find = $User->find('first', array('conditions'=>array('User.person_id'=>$this->person_id)));
         
           if(!empty($find))
           {
              $this->dataUser['is_user'] = true; 
              $this->dataUser['user_id'] = $find['User']['id'];
              $this->dataUser['username'] = $find['User']['username'];
              $this->dataUser['status'] = $find['User']['status'];
              $this->dataUser['createdby'] = $this->getLoginNameUser($find['User']['createdby']);
              $this->dataUser['created'] = $find['User']['created'];
              
              if($this->dataUser['status'] > 0){
                  $this->dataUser['statusDescription']  = 'Usuário ativo';
              }else{
                  $this->dataUser['statusDescription']  = 'Usuário inativo';
              }
              $this->dataUser['recent_register'] = $find['User']['recent_register'];
              $this->dataUser['pass_register'] = $find['User']['pass_register'];
              $this->dataUser['person_id'] = $find['User']['person_id'];
              $this->dataUser['apelido'] =  null;
              $this->dataUser['foto'] =  null;
              if(!empty($find['Colunista']))
              {
                   $this->dataUser['apelido'] =  $find['Colunista']['apelido'];
              }
              if(!empty($find['Avatar']['avatar'])){
                  $this->dataUser['foto'] =  $find['Avatar']['avatar'];
              }
              
           }
       } 
    }
        
    /**
     * Método que seta as permissoes do usuário no caderno selecionado
     */
    private function setPermission($type)
    {
       if($this->isValidation)
       {
            $ind = 'permission_'.$type;
            $this->dataUser[$ind]['permission'] = false;
            if($this->dataUser['is_user'])
            {
                $AccessCaderno = new AccessCaderno();
                $AccessCaderno->recursive = -1;
                $find = $AccessCaderno->find('first', 
                                        array('conditions'=>array(
                                                                    'AccessCaderno.user_id'=>$this->dataUser['user_id'], 
                                                                    'AccessCaderno.caderno_id'=>$this->cadernoData['id'],
                                                                    'AccessCaderno.type'=>$type,
                                                                    'AccessCaderno.isactive'=>'Y'
                                            )));
               if(!empty($find)){
                   $this->dataUser[$ind]['permission'] = true;
                   $this->dataUser[$ind]['autorizeby'] = $find['AccessCaderno']['autorizeby'];
                   $this->dataUser[$ind]['created'] = $find['AccessCaderno']['created'];
               }
            }
       }
    }
    
    /**
     * Método que retorna o login do usuário
     * @param type $user_id
     */
    private function getLoginNameUser($user_id){
        $User = new User();
        $find = $User->find('first', array('conditions'=>array('User.id'=>$user_id)));
        if(!empty($find['Individual']['nome'])){
            return $find['Individual']['nome'].' (Login: '.$find['User']['username'].')';
        }elseif(!empty($find['User']['username'])){
            return $find['User']['username'];
        }else{
            return 'Não localizado';
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
    
    private function cleanClass(){
            $this->person_id  = null;
            $this->caderno  = null;
            $this->cadernoData = null;
            $this->dataUser = null;
            $this->errors = null;
            $this->isValidation = true;
    }
} 