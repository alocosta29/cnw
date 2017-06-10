<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AccessUser', 'AccessUsers.Model');
App::uses('AccessCaderno', 'AccessUsers.Model');
App::uses('User', 'Manager.Model');
class GetPermissionColumnsComponent extends Component
{    
    public $errors = null;
    public $userData = null;
    private $user_id = null;
    public $listCadernos = false;
    public $listIdCadernos = false;
    public $descListCadernos = null;
    private $type = null;
    public $authorizedPackage = false;
    private $isValidation = true;
    
    public function start($user_id, $type)
    {
        $this->cleanClass();
        $this->user_id = $user_id;
        $this->type = $type;
        $this->setUser();
        if($this->isValidation){
            $this->checkPermissions();
           
        }
        #pr($this->userData); exit(0);
        return $this->isValidation;
    }
        
    /**
     * Método que irá verificar se o usuário existe
     */
    private function setUser()
    {
        $User = new User();
        $find = $User->find('first', 
                    array(
                        'fields'=>array('User.id', 'User.username', 'User.person_id', 'User.status', 'Individual.nome'),    
                        'conditions'=>array('User.id'=>$this->user_id)));
        if(!empty($find))
        {
           $this->userData['id'] = $find['User']['id']; 
           $this->userData['person_id'] = $find['User']['person_id']; 
           $this->userData['nome'] = $find['Individual']['nome']; 
           $this->userData['status'] = $find['User']['status']; 
           $this->userData['username'] = $find['User']['username']; 
        }else{
            $this->setErrors('Usuário não localizado!');
        }
    }
        
    /**
     * Método que verificará se o usuário possui permissão de colunista/administrador de colunas
     */
    private function checkPermissions()
    {
        switch($this->type)
        {
            case 'adm':
                $this->checkPackage('gerenciamento-de-cadernos');
                $this->checkPermissionCadernos();
                #$this->setDetailsPermissions();
            break;    
                        
            case 'col':
                $this->checkPackage('artigos');
                $this->checkPermissionCadernos();
            break;   
                       
            case 'cad':
                $this->checkPackage('criar-anuncios');
                $this->checkPermissionCadernos();
            break; 
        
        
          case 'ads':
                $this->checkPackage('administracao-de-anuncios');
                $this->checkPermissionCadernos();
          break; 
              
        
            default:
            $this->setErrors('Tipo de permissão buscada não localizada. escolha colunista ou administrador de coluna');       
        }
    }
        
    /**
     * Método que verifica se existe permissão de administrador de coluna
     */
    private function checkPackage($alias)
    {
        $AccessUser = new AccessUser();
        $find = $AccessUser->find('first', 
                array('conditions'=>array(
                                            'AccessUser.user_id' => $this->user_id, 
                                            'AccessUser.isactive' => 'Y', 
                                            'Package.alias' => $alias,
                                            'Package.isdeleted' => 'N'
                    )));
        if(!empty($find)){
            $this->authorizedPackage = true;
        }
    }
    
    /**
     * Método que verifica a autorizaçao dos cadernos
     */
    private function checkPermissionCadernos()
    {
        if($this->authorizedPackage)
        {
           $AccessCaderno = new AccessCaderno();
           $AccessCaderno->recursive = 1;
           $findPermissions = $AccessCaderno->find('all', array(
                                'conditions'=>array(
                                            'AccessCaderno.user_id'=>$this->user_id,
                                            'AccessCaderno.type'=>$this->type,
                                            'AccessCaderno.isactive'=>'Y',
                                           // 'AccessCaderno.user_id'=>$this->user_id,
                                    )));
           if(!empty($findPermissions))
           {
               $i=0;
               $totalSize = sizeof($findPermissions);
               while ($i<$totalSize){
                    $this->listIdCadernos[$i] = $findPermissions[$i]['Caderno']['id'];
                    
                    $this->descListCadernos .= $findPermissions[$i]['Caderno']['nome'].'; ';
                    
                    $this->listCadernos[$i]['caderno_id'] = $findPermissions[$i]['Caderno']['id'];
                    $this->listCadernos[$i]['caderno'] = $findPermissions[$i]['Caderno']['nome'];
                    $this->listCadernos[$i]['type'] = $findPermissions[$i]['AccessCaderno']['type'];
                    $this->listCadernos[$i]['alias'] = $findPermissions[$i]['Caderno']['alias'];
                    $this->listCadernos[$i]['descricao'] = $findPermissions[$i]['Caderno']['descricao'];
                    $this->listCadernos[$i]['cor'] = $findPermissions[$i]['Caderno']['cor'];
                    $this->listCadernos[$i]['autorizeby'] = $findPermissions[$i]['AccessCaderno']['autorizeby'];
                    $this->listCadernos[$i]['autorizeby_username'] = $findPermissions[$i]['User']['username'];
                    
                    $i++;
               }
           } 
        }
    }
    
     /**
     * Método que seta os erros encontrados
     * @param type $error
     */
    private function setErrors($error = null){
       $this->isValidation = false;
       if(!empty($this->errors)){
           $this->errors = $this->errors.'<br>'.$error;
       }else{
           $this->errors = $error;
       } 
    }
    
    private function cleanClass()
    {
        $this->errors = null;
        $this->userData = null;
        $this->user_id = null;
        $this->listCadernos = false;
        $this->listIdCadernos = false;
        $this->descListCadernos = null;
        $this->type = null;
        $this->authorizedPackage = false;
        $this->isValidation = true;
    } 
}