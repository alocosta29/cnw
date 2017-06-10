<?php
App::uses('AccessUser', 'Manager.Model');
App::uses('Package', 'ManagerPackages.Model');

/**
 * setar variaveis 
 * 
 * 
 * 
 */
class UserPermissionsComponent extends Component 
{
    private $user_id = null;
    private $person_id = null;
    private $data = null;
    private $newPackages = array();
    private $deletePackages = array();
    public $savePackages = array();

    private $isValidation = false;
    public $components = array('Session');
    
    public function start($user_id, $person_id, $data = null)
    {
        $this->cleanClass();
        $this->user_id = $user_id;
        $this->person_id = $person_id;
        $this->data = $data;
        $this->setDeletePackages();
        $this->setNewPackages();
        $this->setFormatSaves();
        $this->setSavedPackages();
      # pr($this->savePackages); exit(0);
        return $this->isValidation;
    }
    
    /**
     * Método que seta os pacotes que serão deletados
     */
    private function setDeletePackages()
    {
        //if(!empty($this->data))
        //{
               $packagesSelected = $this->data;
               $AccessUser= new AccessUser();
               $AccessUser->recursive = -1;
               $find = $AccessUser->find('all', array(
               'conditions'=>array(
                   'AccessUser.user_id'=>$this->user_id,
                   'AccessUser.isactive'=>'Y',
                   'NOT'=>array('AccessUser.package_id'=>$packagesSelected)
               )));
               if(!empty($find)){
                   $this->isValidation = true;
                   $this->setFormatDelSaves($find);
               }
       // }
    }
    
    /**
     * Método que seta as permissões que serão deletadas
     * @param type $del
     */
    private function setFormatDelSaves($del){
        $i=0;
        $totalSize = sizeof($del);
        $this->isValidation = true;
        while($i<$totalSize){
            $this->deletePackages[$i]['AccessUser']['id'] = $del[$i]['AccessUser']['id'];
            $this->deletePackages[$i]['AccessUser']['date_disabled'] = date('Y-m-d H:i:s');
            $this->deletePackages[$i]['AccessUser']['disabledby'] = $this->Session->read('Auth.User.id');
            $this->deletePackages[$i]['AccessUser']['isactive'] = 'N';
            $i++;
        }
    }
    
    /**
     * Método que seta novos pacotes permitidos
     */
    private function setNewPackages()
    {
      if(!empty($this->data))
      {
          $i=0;
          $totalSize = sizeof($this->data);
          while($i<$totalSize){
              if(!$this->existPermission($this->data[$i])){
                  $this->isValidation = true;
                  $this->newPackages[] = $this->data[$i];
              }
              $i++;
          }
      }
    }
  
    
    /**
    * Método que verifica se a permissão para o pacotes já existe. Caso exista, o sistema não gravará novamente
    */
    private function existPermission($package_id)
    {
        $return  = false;
        $AccessUser = new AccessUser(); 
        $AccessUser->recursive = -1;
        $find = $AccessUser->find('first', array(
            'conditions'=>array(
                                'AccessUser.user_id'=>$this->user_id,
                                'AccessUser.package_id'=>$package_id, 
                                'AccessUser.isactive'=>'Y', 
                )));
        if(!empty($find)){  
            $return = true;  
        }
        return $return;
    }
    
    
    /**
     * Método que formata os novos pacotes para gravação
     */
    private function setFormatSaves(){
        $i=0;
        $totalSize = sizeof($this->newPackages);  
       
        $this->isValidation = true;
        while($i<$totalSize){
            $this->savePackages[$i]['AccessUser']['user_id'] = $this->user_id;
            $this->savePackages[$i]['AccessUser']['person_id'] = $this->person_id;
            $this->savePackages[$i]['AccessUser']['package_id'] = $this->newPackages[$i];
            $this->savePackages[$i]['AccessUser']['date_active'] = date('Y-m-d H:i:s');
            $this->savePackages[$i]['AccessUser']['autorizeby'] = $this->Session->read('Auth.User.id');
            
            $i++;
        }  
    }

    /**
     * Método que seta os dados de gravação
     */
    private function setSavedPackages(){
        if($this->isValidation){
            $this->savePackages = array_merge($this->savePackages, $this->deletePackages);
        }
    }

    private function cleanClass(){
        $this->user_id = null;
        $this->person_id = null;
        $this->data = null;
        $this->newPackages = array();
        $this->deletePackages = array();
        $this->savePackages = array();
        $this->isValidation = false;
    }

}