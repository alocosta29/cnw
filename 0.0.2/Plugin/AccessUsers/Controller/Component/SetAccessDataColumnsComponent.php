<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AccessUser', 'AccessUsers.Model');
App::uses('AccessCaderno', 'AccessUsers.Model');
App::uses('User', 'Manager.Model');
App::uses('Package', 'ManagerPackages.Model');
class SetAccessDataColumnsComponent extends Component{
    private $data = null;
    private $user_id = null;
    private $type = null;
    private $package = null;
    private $authorizedPackage = false;
    private $setAuthorizePackage = false;
    //lista de cadernos que foram selecionados no formulário
    private $listCadernosSelect = false;
    public $dataSave = null;
    private $userData = null;
    private $allowCadernos = array();
    private $setAllowCadernos = array();
    private $setDeleteCadernos = array();
    public $errors = null;
    private $isValidation = true;
    
    public $components = array('Session');
        
    public function start($data, $user_id, $type)
    {
        $this->cleanClass();
        $this->data = $data;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->setUser();        
        if($this->isValidation){   
            $this->setData();
        }
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
                        'conditons'=>array('User.id'=>$this->user_id)));
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
    
    
    private function setData()
    {
        if($this->data['AccessUser']['enabled'])
        {
           if(!empty($this->data['AccessCaderno']['caderno_id'])){
               $this->setAuthorizePackage = true;
           }else{
               $this->setErrors('Cadernos não selecionados! Para dar permissão você precisa selecionar um caderno!');
           }
        }
        if($this->isValidation){
            $packageAlias = array('adm'=>'gerenciamento-de-cadernos', 'col'=>'artigos', 'cad'=>'criar-anuncios', 'ads'=>'administracao-de-anuncios');
            $this->checkPackageColumn($packageAlias[$this->type]);   
            $this->setPackagePermission();
            $this->setCadernoPermission($this->type);
            $this->setCadernoSave();
            $this->setCadernoDelete();
        }
    }

   


    /**
     * Método que verifica se existe permissão para o pacote selecionado
     */
    private function checkPackageColumn($alias)
    {
        $this->setPackage($alias);
        if($this->isValidation)
        {
            $AccessUser = new AccessUser();
            $find = $AccessUser->find('count', 
                        array('conditions'=>array(
                            'AccessUser.package_id'=>$this->package['id'],
                            'AccessUser.user_id'=>$this->user_id,
                            'AccessUser.isactive'=>'Y'
                            )));
            if($find > 0){
                $this->authorizedPackage = true;
            }
            
        }
    }


private function setPackage($alias){
    $Package = new Package();
    $Package->recursive = -1;
    
    $find = $Package->find('first', array('conditions'=>array('Package.alias'=>$alias,
        'Package.isdeleted'=>'N', 'Package.isactive'=>'Y'
        )));
    if(!empty($find)){
        $this->package = $find['Package'];
        
    }else{
        $this->setErrors('Pacote não encontrado');
    }
}


    /**
     * Método que seta a permissão para o pacote
     */
    private function setPackagePermission()
    {
        if($this->isValidation)
        {
            if($this->authorizedPackage <> $this->setAuthorizePackage)
            {
                if(!$this->setAuthorizePackage)
                {
                    $this->dataSave['deleteAll']['AccessUser']['conditions']['user_id'] = $this->user_id;
                    $this->dataSave['deleteAll']['AccessUser']['conditions']['package_id'] = $this->package['id'];
                    $this->dataSave['deleteAll']['AccessUser']['set']['disabledby'] = $this->Session->read('Auth.User.id');
                    $this->dataSave['deleteAll']['AccessUser']['set']['date_disabled'] = date('Y-m-d');
                    $this->dataSave['deleteAll']['AccessUser']['set']['isactive'] = 'N';
                    
                    
                    $this->dataSave['deleteAll']['AccessCaderno']['conditions']['user_id'] = $this->user_id;
                    $this->dataSave['deleteAll']['AccessCaderno']['conditions']['type'] = $this->type;
                    $this->dataSave['deleteAll']['AccessCaderno']['set']['disabledby'] = $this->Session->read('Auth.User.id');
                    $this->dataSave['deleteAll']['AccessCaderno']['set']['date_disabled'] = date('Y-m-d');
                    $this->dataSave['deleteAll']['AccessCaderno']['set']['isactive'] = 'N';
                    
                }else{

                    $this->dataSave['save']['AccessUser']['user_id'] = $this->user_id;
                    $this->dataSave['save']['AccessUser']['package_id'] = $this->package['id'];
                    $this->dataSave['save']['AccessUser']['person_id'] = $this->userData['person_id'];
                    $this->dataSave['save']['AccessUser']['autorizeby'] = $this->Session->read('Auth.User.id');
                    $this->dataSave['save']['AccessUser']['date_active'] = date('Y-m-d');
                }
            }          
        }
    }

    /**
     * Método que seta cadernos que o usuário já possui permissão
     * @param type $type
     */
    private function setCadernoPermission($type)
    {
        $AccessCaderno = new AccessCaderno();
        $find = $AccessCaderno->find('list', array(
            'fields'=>array('AccessCaderno.caderno_id', 'AccessCaderno.caderno_id'),
            'conditions'=>
            array(
                'AccessCaderno.user_id'=>$this->user_id,
                'AccessCaderno.type'=>$type,
                'AccessCaderno.isactive'=>'Y'
                )));
        if(!empty($find)){
            sort($find);
            $this->allowCadernos = $find;
        }
    }
    
    /**
     * Método que seta os cadernos que deverão ser salvos
     */
    private function setCadernoSave(){
        if($this->setAuthorizePackage)
        {
            if(!empty($this->data['AccessCaderno']))
            {
                sort($this->data['AccessCaderno']['caderno_id']);
                $listCadernos = $this->data['AccessCaderno']['caderno_id'];
                $i=0;
                $totalSize = sizeof($listCadernos);
                while($i<$totalSize)
                {
                    $this->listCadernosSelect[$i] = $listCadernos[$i];
                    if(!in_array($listCadernos[$i], $this->allowCadernos))
                    {
                        $this->setDataSaveCadernos($listCadernos[$i]);
                    }else{
                        unset($this->data['AccessCaderno']['caderno_id'][$i]);
                    }
                    $i++;
                }   
            }                
        }
    }
    
    /**
     * Método que verifica se alguma permissão de caderno necessita de ser deletada
     */
    private function setCadernoDelete()
    {
        if($this->setAuthorizePackage and !empty($this->allowCadernos))
        {
            sort($this->listCadernosSelect);
            sort($this->allowCadernos);
            $i=0;
            $totalSize = sizeof($this->allowCadernos);
            while($i<$totalSize)
            {
                if(!in_array($this->allowCadernos[$i], $this->listCadernosSelect))
                {
                    $this->setDataDeleteCadernos($this->allowCadernos[$i]);
                }
                $i++;
            }
        }
    }
    
    /**
     * Método que seta cadernos para serem salvos
     */
    private function setDataSaveCadernos($caderno_id)
    {
        if(!empty($this->dataSave['save']['AccessCaderno']))
        {
            $totalSize = sizeof($this->dataSave['save']['AccessCaderno']);
            $this->dataSave['save']['AccessCaderno'][$totalSize]['caderno_id'] =  $caderno_id;
            $this->dataSave['save']['AccessCaderno'][$totalSize]['user_id'] =  $this->user_id;
            $this->dataSave['save']['AccessCaderno'][$totalSize]['type'] =  $this->type;
            $this->dataSave['save']['AccessCaderno'][$totalSize]['autorizeby'] =  $this->Session->read('Auth.User.id');
   
        }else{
            $this->dataSave['save']['AccessCaderno'][0]['caderno_id'] =  $caderno_id;
            $this->dataSave['save']['AccessCaderno'][0]['user_id'] =  $this->user_id;
            $this->dataSave['save']['AccessCaderno'][0]['type'] =  $this->type;
            $this->dataSave['save']['AccessCaderno'][0]['autorizeby'] =  $this->Session->read('Auth.User.id');
        }
    }
    
    /**
     * Método que seta as permissões de cadernos que necessitam de ser desativadas
     * @params $caderno_id
     */
    private function setDataDeleteCadernos($caderno_id)
    {
        if(!empty($this->dataSave['delete']['AccessCaderno']))
        {
            $totalSize = sizeof($this->dataSave['delete']['AccessCaderno']);
            $this->dataSave['delete']['AccessCaderno'][$totalSize]['conditions']['caderno_id'] =  $caderno_id;
            $this->dataSave['delete']['AccessCaderno'][$totalSize]['conditions']['user_id'] =  $this->user_id;
            $this->dataSave['delete']['AccessCaderno'][$totalSize]['conditions']['type'] =  $this->type;
            $this->dataSave['delete']['AccessCaderno'][$totalSize]['conditions']['isactive'] =  'Y';
            
            $this->dataSave['delete']['AccessCaderno'][$totalSize]['set']['disabledby'] =  $this->Session->read('Auth.User.id');
            $this->dataSave['delete']['AccessCaderno'][$totalSize]['set']['date_disabled'] =  date('Y-m-d');
            $this->dataSave['delete']['AccessCaderno'][$totalSize]['set']['isactive'] =  'N';
        }else{
            $this->dataSave['delete']['AccessCaderno'][0]['conditions']['caderno_id'] =  $caderno_id;
            $this->dataSave['delete']['AccessCaderno'][0]['conditions']['user_id'] =  $this->user_id;
            $this->dataSave['delete']['AccessCaderno'][0]['conditions']['type'] =  $this->type;
            $this->dataSave['delete']['AccessCaderno'][0]['conditions']['isactive'] =  'Y';
            
            $this->dataSave['delete']['AccessCaderno'][0]['set']['disabledby'] =  $this->Session->read('Auth.User.id');
            $this->dataSave['delete']['AccessCaderno'][0]['set']['date_disabled'] =  date('Y-m-d');
            $this->dataSave['delete']['AccessCaderno'][0]['set']['isactive'] =  'N';
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
        $this->data = null;
        $this->user_id = null;
        $this->type = null;
        $this->package = null;
        $this->authorizedPackage = false;
        $this->setAuthorizePackage = false;
        $this->listCadernosSelect = false;
        $this->dataSave = null;
        $this->userData = null;
        $this->allowCadernos = array();
        $this->setAllowCadernos = array();
        $this->setDeleteCadernos = array();
        $this->errors = null;
        $this->isValidation = true;
    } 
}