<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('User', 'Manager.Model');
App::uses('Package', 'ManagerPackages.Model');
App::uses('AccessUser', 'AccessUsers.Model');
App::uses('AccessCaderno', 'AccessUsers.Model');
class PermissionsReportComponent extends Component{

    public $errors = null;
    public $userData = null;
    private $user_id = null;
    private $isValidation = true;
    public $components = array('AccessUsers.GetPermissionColumns');
    
    
    public function start($user_id)
    {
        $this->cleanClass();
        $this->user_id = $user_id;
        $this->checkUser();
        $this->setPackages();
     //   pr($this->userData); exit();
        return $this->isValidation;
    }
    
    /**
     * Verifica se o usuário existe
     */
    private function checkUser()
    {
        $User = new User();
        $User->recursive = 0;
        $find = $User->findById($this->user_id);
        if(!empty($find)){
            $this->userData['id'] = $find['User']['id'];
            $this->userData['username'] = $find['User']['username'];
            $this->userData['nome'] = $find['Individual']['nome'];
            $this->userData['person_id'] = $find['User']['person_id'];
            $this->userData['isactive'] = $find['User']['isactive'];
        }else{
            $this->setErrors('Usuário não localizado!');
        }
    }
        
    /**
     * Método que seta os pacotes existentes no sistema
     */
    private function setPackages()
    {
        if($this->isValidation)
        {
            $Package = new Package();
            $Package->recursive = -1;
            $find = $Package->find('all', array(
                                                'conditions'=>array(
                                                                    'Package.isdeleted'=>'N',
                                                                    'Package.isactive'=>'Y'
                                                                    ),
                                                'order'=>array('Package.nome'=>'ASC')                               
                ));
            if(!empty($find))
            {
                $i=0;
               // pr($find); exit();
                $totalSize = sizeof($find);
                while($i<$totalSize){
                    $this->userData['packages'][$i]['id'] = $find[$i]['Package']['id'];
                    $this->userData['packages'][$i]['plugin'] = $find[$i]['Package']['plugin'];
                    $this->userData['packages'][$i]['alias'] = $find[$i]['Package']['alias'];
                    $this->userData['packages'][$i]['nome'] = $find[$i]['Package']['nome'];
                    $this->userData['packages'][$i]['descricao'] = $find[$i]['Package']['descricao'];
                    $this->userData['packages'][$i]['permission'] = $this->checkPermission($find[$i]['Package']['id']);
                    $this->userData['packages'][$i]['detalhes'] = $this->getPermissionsDetails($find[$i]['Package']['alias']);
                    $this->userData['packages'][$i]['link'] = $this->getLinkPermissions($find[$i]['Package']['alias']);
                    $i++;
                }
                
            }else{
                $this->setErrors('Nenhum pacote foi localizado!');
            }
            
        }    
    }
   
    /**
     * Metpdp que retorna os datelhes da permissão
     * @param type $alias
     */
    private function getPermissionsDetails($alias)
    {
       
        switch ($alias)
        {
            case 'gerenciamento-de-cadernos':
               $return = null;
                if($this->GetPermissionColumns->start($this->user_id, 'adm')){
                    return $this->GetPermissionColumns->descListCadernos;
                }
               return $return;
               break; 
            
            
               case 'artigos':
               $return = null;
                if($this->GetPermissionColumns->start($this->user_id, 'col')){
                    return $this->GetPermissionColumns->descListCadernos;
                }
               return $return;
               break; 
            
                 
               case 'criar-anuncios':
               $return = null;
                   
                if($this->GetPermissionColumns->start($this->user_id, 'cad')){
                    return $this->GetPermissionColumns->descListCadernos;
                }
               return $return;
               break; 
               
               
               
               case 'administracao-de-anuncios':
               $return = null;
                   
                if($this->GetPermissionColumns->start($this->user_id, 'ads')){
                    return $this->GetPermissionColumns->descListCadernos;
                }
               return $return;
               break; 
               
               
               
               
               
               
            default:
 
                return false;
        }
    }
    

  /*  private function getCadernosAdmin(){
        $AccessCaderno = new AccessCaderno();
        $AccessCaderno->recursive = 1;
        $find = $AccessCaderno->find('all', array('conditions'=>array('AccessCaderno.user_id'=>$this->user_id)));
        $return = null;
        if(!empty($find)){
            $i=0;
            $totalSize = sizeof($find);
            while($i<$totalSize){
                $return .= $find[$i]['Caderno']['nome'].'; ';
                $i++;
            } 
        }     
        return $return;   
        
    }*/
    
    private function getLinkPermissions($alias){
      switch ($alias)
      {
            case 'gerenciamento-de-cadernos':
                return array('plugin'=>'access_users', 'controller'=>'AccessColumns', 'action'=>'enableDisabledAdmColum', 'admin'=>true, $this->user_id);
                
            break; 
            
            
            case 'artigos':
                return array('plugin'=>'access_users', 'controller'=>'AccessColumns', 'action'=>'enableDisabledColumnist', 'admin'=>true, $this->user_id);
            break; 
        
        
         case 'criar-anuncios':
                return array('plugin'=>'access_users', 'controller'=>'AccessAds', 'action'=>'enableDisabledCreateAds', 'admin'=>true, $this->user_id);
            break; 
        
        
        
        
        
         case 'administracao-de-anuncios':
              return array('plugin'=>'access_users', 'controller'=>'AccessAds', 'action'=>'enableDisabledAdminAds', 'admin'=>true, $this->user_id);
            break; 
        
            default:
                return false;
       }   
    }
    
    /**
     * Método que verifica a permissão do usuário ao pacote selecionado
     */
    private function checkPermission($package_id)
    {
        $AcessUser = new AccessUser();
        $AcessUser->recursive = -1;
        $find = $AcessUser->find('first', array(
                                    'conditions'=>array(
                                                        'AccessUser.user_id'=>$this->user_id,
                                                        'AccessUser.package_id'=>$package_id,
                                                        'AccessUser.isactive'=>'Y'  
                                        )));
        if(!empty($find))
        {
            return 'Y';
        }else{
            return 'N';
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
        $this->isValidation = true;
    } 
}