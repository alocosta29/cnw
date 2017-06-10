<?php
/**
 *  
 */
App::uses('User', 'Manager.Model');
App::uses('RolesUser', 'Manager.Model');
App::uses('ConfigBook', 'Manager.Model');
App::uses('AccessUser', 'AccessUsers.Model');
App::uses('AccessCaderno', 'AccessUsers.Model');
class AllowDenyBookComponent extends Component{
    private $id = null;
    private $type = null;
    private $caderno = null;
    private $cadernoData = null;
    public $dataSave = null;
    private $dataUser = null;
    private $package = null;
    
    //informa se existem outras permissões de cadernos
    private $otherPermissionBook = false;
    
    
    private $isValidation = true;
    public $errors = null;
    
    public $components = array('Session');
    
    public function start($caderno = false, $type = false, $id=false, $permission = true)
    {
        $this->cleanClass();
        $this->setParameters($caderno, $type, $id);
        $this->id = $id;
        $this->checkUser(); 
        $this->setPackage();
        
        $this->setDataCaderno();
         
        if($permission){
            $this->setPermissions();
        }else{
            $this->checkAdm();
            $this->setDeny();
        }
        
        return $this->isValidation;
    }
    
    private function setParameters($caderno, $type, $id)
    {
        if(!empty($caderno) and !empty($type) and !empty($id))
        {
            $this->id = $id;
            $this->type = $type;
            $this->caderno = $caderno;
        }else{
            $this->setErrors('Parâmetros incompletos');
        }
    }
    
    private function checkUser(){
        if($this->isValidation)
        {
            $User = new User();
            $User->recursive = 0;
            $find = $User->find('first', array('conditions'=>array('User.id'=>$this->id)));     
            if(!empty($find)){
                $this->dataUser = $find['User'];
            }else{
                $this->setErrors('Usuario não localizado!');
            }
        }
    } 
  
    private function setPackage()
    {
        if($this->isValidation)
        {
            $package = false;
            if($this->type == 'adm')
            {
                    $Package  = new Package();
                    $Package->recursive = -1;
                    $find = $Package->find('first', 
                                        array(
                                                'conditions'=>array(
                                                                        'Package.alias'=>'gerenciamento-de-cadernos',
                                                                        'Package.isdeleted'=>'N'
                                                                    )));
                    $package = $find['Package'];
            }elseif($this->type == 'col')
            {
                    $Package  = new Package();
                    $Package->recursive = -1;
                    $find = $Package->find('first', 
                                        array(
                                                'conditions'=>array(
                                                                        'Package.alias'=>'artigos',
                                                                        'Package.isdeleted'=>'N'
                                                                    )));
                    $package = $find['Package'];
            }
            if(!empty($package))
            {
                    $this->package = $package;
            }else{
                    $this->setErrors('Pacote não localizado!');
            }
        }
    }    
    
    /**
     * Método que seta o id do caderno
     */
    private function setDataCaderno()
    {
        if($this->isValidation)
        {
            $Caderno = new Caderno();
            $find =  $Caderno->find('first', 
                      array('conditions'=>array(
                                                  'Caderno.alias'=>$this->caderno, 
                                                  'Caderno.isdeleted'=>'N')));
            if(!empty($find)){
                $this->cadernoData = $find['Caderno'];
            }else{
                $this->setErrors('Caderno não encontrado!');
            }
        }
    }  
    
    /*
     *Método que verifica se o ususário possui tb permissão de moderador.
     * Caso possua, não será permitido retirar sua permissão de colunista 
     */
    private function checkAdm(){
        if($this->isValidation and $this->type == 'col')
        {
            $AccessCaderno = new AccessCaderno();
            $AccessCaderno->recusive = -1;
            $find = $AccessCaderno->find('first', 
                    array(
                        'conditions'=>array(
                                            'AccessCaderno.caderno_id' => $this->cadernoData['id'],
                                            'AccessCaderno.type' => 'adm',
                                            'AccessCaderno.user_id' => $this->dataUser['id'],
                                            'AccessCaderno.isactive' => 'Y'
                            )));
            if(!empty($find)){
              $this->setErrors('O usuário possui permissão de moderador do mesmo caderno. Não é possível retirar a permisão de colunista');  
            }
        }
    }
    
    
    private function setPermissions()
    {
        if($this->isValidation)
        {
            #verifica se o colaborador está ativo
            $this->checkActiveUser();
            
            #verifica se o colaborador possui acesso ao sistema
            $this->checkGroupSystem();
            
            #checa a permissão de pacote
            $this->checkPackagePermission();
            
            //designa permissão para no cadenro selecionado
            $this->checkCadernoPermission();
        }
    }
    
    private function checkActiveUser()
    {
        if($this->dataUser['status'] < 1)
        {
            $this->dataSave['User']['id'] = $this->dataUser['id'];
            $this->dataSave['User']['status'] = 1;
            $this->dataSave['User']['isactive'] = 'Y';
        }
    }
    
    private function checkGroupSystem()
    {
        $RolesUser = new RolesUser();
        $find = $RolesUser->find('first', 
                  array(
                      'conditions'=>array(
                                              'RolesUser.user_id'=>$this->dataUser['id'],
                                              'RolesUser.isdeleted'=>'N',
                                              'RolesUser.isactive'=>'Y'
                                          )));
        if(empty($find)){
            $this->dataSave['RolesUser']['user_id'] = $this->dataUser['id'];
            $this->dataSave['RolesUser']['role_id'] = 6;
        }
    }
    
    /**
     * Método que designa permissão para o pacote
     */
    private function checkPackagePermission()
    {
        if($this->isValidation)
        {
                $AccessUser = new AccessUser();
                $find = $AccessUser->find('first', 
                        array(
                            'conditions'=>array(
                                                'AccessUser.package_id' => $this->package['id'],
                                                'AccessUser.user_id' => $this->dataUser['id'],
                                                'AccessUser.isactive' => 'Y'
                                            )));
               if(empty($find))
               {
                   $this->dataSave['AccessUser']['package_id'] = $this->package['id'];
                   $this->dataSave['AccessUser']['user_id'] = $this->dataUser['id'];
                   $this->dataSave['AccessUser']['person_id'] = $this->dataUser['person_id'];
                   $this->dataSave['AccessUser']['autorizeby'] = $this->Session->read('Auth.User.id');
                   $this->dataSave['AccessUser']['date_active'] = date('Y-m-d H:i:s');
               }
        }
    }
        
    
    /**
     * Método que designa permissão específica para o caderno
     */
    private function checkCadernoPermission()
    {
        if($this->isValidation){
            $AccessCaderno = new AccessCaderno();
            $find = $AccessCaderno->find('first', 
                    array(
                        'conditions'=>array(
                                            'AccessCaderno.caderno_id' => $this->cadernoData['id'],
                                            'AccessCaderno.type' => $this->type,
                                            'AccessCaderno.user_id' => $this->dataUser['id'],
                                            'AccessCaderno.isactive' => 'Y'
                            )));
            
            
            if(empty($find)){
                   $this->dataSave['AccessCaderno']['type'] = $this->type;
                   $this->dataSave['AccessCaderno']['user_id'] = $this->dataUser['id'];
                   $this->dataSave['AccessCaderno']['caderno_id'] = $this->cadernoData['id'];
                   $this->dataSave['AccessCaderno']['autorizeby'] = $this->Session->read('Auth.User.id');
                   $this->dataSave['AccessCaderno']['isactive'] = 'Y';
            }
        }
    }
    
    
    /**
     * Método que retirará as permissões de caderno
     */
    private function setDeny()
    {
        if($this->isValidation)
        {
                if($this->type == 'adm' and $this->Session->read('Auth.User.role_id') > 2)
                {
                    $this->setErrors('Você não possui permissão para retirar o acesso de um moderador! ');
                }else{
                                #retirar permissão de caderno
                                $this->setCadernoDeny();

                                #seta se existem outras permissões de outros cadernos para o usuário selecionado 
                                $this->setOtherPermissionBook();

                                #seta a esclusão de permissão do pacote
                                $this->setPackageDeny();

                                #seta as exclusões de permissão de usuário
                                $this->setDenyUser();
                }
        }
    }
    
    /*
     * seta oos parametros para update que retira permissão ds cadernos
     */
    private function setCadernoDeny()
    {
        $this->dataSave['AccessCaderno']['conditions'] = array(
                                                                'AccessCaderno.caderno_id' => $this->cadernoData['id'],
                                                                'AccessCaderno.user_id' => $this->dataUser['id'],
                                                                'AccessCaderno.isactive' => 'Y',
                                                                'AccessCaderno.type' => $this->type,
                                                               );
        $this->dataSave['AccessCaderno']['set'] = array(
                                                        'AccessCaderno.isactive' => "'N'",
                                                        'AccessCaderno.disabledby' => $this->Session->read('Auth.User.id'),
                                                        'AccessCaderno.date_disabled' =>"'".date('Y-m-d H:i:s')."'"
                                                        );    
    }
    
    /**
     * seta os parametros para update que retira permissão ds cadernos
     */
    private function setOtherPermissionBook()
    {
            $AccessCaderno = new AccessCaderno();
            $AccessCaderno->recursive = -1;
            $find = $AccessCaderno->find('first', 
                    array(
                        'conditions'=>array(
                                           'NOT'=>array(   
                                                        'AND'=>array(
                                                                        'AccessCaderno.caderno_id' => $this->cadernoData['id'],
                                                                        'AccessCaderno.type' => $this->type)),
                                            'AccessCaderno.user_id' => $this->dataUser['id'],
                                            'AccessCaderno.isactive' => 'Y',
                                            'AccessCaderno.type' => $this->type
                            )));

            if(!empty($find)){
                  $this->otherPermissionBook = true;
            }
    }
    
   /**
    * Método que seta a esclusão de permissão do pacote
    */ 
    private function setPackageDeny()
    {
        if(!$this->otherPermissionBook){
            $this->dataSave['AccessUser']['conditions']['AccessUser.package_id'] = $this->package['id'];
            $this->dataSave['AccessUser']['conditions']['AccessUser.user_id'] = $this->dataUser['id'];
            $this->dataSave['AccessUser']['conditions']['AccessUser.isactive'] = 'Y';
            $this->dataSave['AccessUser']['set']['AccessUser.isactive'] = "'N'";
            $this->dataSave['AccessUser']['set']['AccessUser.disabledby'] = $this->Session->read('Auth.User.id');
            $this->dataSave['AccessUser']['set']['AccessUser.date_disabled'] = "'".date('Y-m-d H:i:s')."'"; 
        }
    }
    
    /**
     * Método que seta os parâmetros para deletar as permissões de usuário
     */
    private function setDenyUser(){
        if(!$this->otherPermissionBook)
        {
                $RolesUser = new RolesUser();
                $RolesUser->recursive = -1;
                $find = $RolesUser->find('first', 
                          array(
                              'conditions'=>array(
                                                    'RolesUser.user_id'=>$this->dataUser['id'],
                                                    'RolesUser.isdeleted'=>'N',
                                                    'RolesUser.isactive'=>'Y'
                                                  )));
                if(!empty($find) and $find['RolesUser']['role_id'] == 6)
                {
                    $this->dataSave['User']['id'] = $this->dataUser['id'];
                    $this->dataSave['User']['status'] = 0;
                    $this->dataSave['User']['isactive'] = 'N';
                    $this->dataSave['RolesUser']['id'] = $find['RolesUser']['id'];
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
        $this->type = null;
        $this->caderno = null;
        $this->cadernoData = null;
        $this->dataSave = null;
        $this->dataUser = null;
        $this->package = null;
        $this->isValidation = true;
        $this->errors = null;
        $this->otherPermissionBook = false;
        
    }
}