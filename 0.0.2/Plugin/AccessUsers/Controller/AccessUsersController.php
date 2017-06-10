<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AccessUsers.AccessUsersAppController', 'Controller');

class AccessUsersController extends AccessUsersAppController{
    public $uses = array('AccessUsers.AccessUser', 'Manager.User', 'ManagerPackages.Package');
    public $components = array('Manager.UserPermissions', 'AccessUsers.PermissionsReport');
    
   /* public function admin_designatePermission($id = null)
    {
        $this->User->recursive = 1;
        $dataUser =  $this->User->find('first', array(
            'conditions'=>array('User.id'=>$id),
            'fields'=>array(
                            'Individual.nome', 'User.username', 'User.status',
                            'User.id', 'User.person_id'
                            ),
        ));
       # pr($dataUser); exit(0);
        
        $packages = $this->Package->find('list', 
                 array(
                     'fields'=>array('Package.id', 'Package.nome'),
                     'conditions'=>array('Package.isdeleted'=>'N')  
                     ));
        
        
        if(!empty($dataUser))
        {
            if($this->request->is('post') || $this->request->is('put'))
            {
                    if($this->UserPermissions->start($id, $dataUser['User']['person_id'], $this->request->data['Package']['id']))
                    {
                                $dataSave = $this->UserPermissions->savePackages;
                          
                                
                              #  pr($dataSave); exit(0);
                                $datasource = $this->AccessUser->getDataSource();
                                 try{
                                         $datasource->begin();


                                         if(!$this->AccessUser->saveMany($dataSave))
                                           { throw new Exception(); }



                                         $datasource->commit();
                                         $this->Session->setFlash(__('Sucesso!!!'), 'default', array('class' => 'error'));
                                        #$this->redirect(array('plugin'=>'manager', 'controller'=>'users', 'action' => 'index'));
                                     }catch(Exception $e){
                                         $datasource->rollback();
                                                                     
                                         $this->Session->setFlash(__($this->Mensagens->registroInvalido), 'default', array('class' => 'error'));
                                     }	
                    }else{
                        $this->Session->setFlash(__($this->UserPermissions->errors), 'default', array('class' => 'error'));

                    }
            }
            $packagesUser = $this->AccessUser->find('list', array(
                'fields'=>array('AccessUser.package_id', 'AccessUser.package_id'),
                'conditions'=>array('AccessUser.user_id'=>$id, 'AccessUser.isactive'=>'Y')));
            $options['Pacotes'] = $packages;
         #  pr($packagesUser); exit(0);
          sort($packagesUser);
            $this->set('packagesUser', $packagesUser);
            $this->set('options', $options);
            $this->set('id', $id);
            $this->request->data = $dataUser;
        }else{
            $this->Session->setFlash(__($this->Mensagens->registroInvalido), 'default', array('class' => 'error'));
            $this->redirect(array('plugin'=>'manager', 'controller'=>'users', 'action' => 'index'));
        }
    }*/
    
    
    public function admin_designatePermission($id = null)
    {
        
        if($this->PermissionsReport->start($id))
        {
           # pr($this->PermissionsReport->userData);             
            #exit(0);
            $this->set('permissions', $this->PermissionsReport->userData);
  
            
           
        }else{
            $this->Session->setFlash(__($this->PermissionsReport->errors), 'default', array());
			$this->redirect(array('plugin'=>'manager', 'controller'=>'users', 'action'=>'index'));
        }
    }
    
    

    
    
    
    
    
   
    
    
    
    
    
    
    
    
    
    
    
    
    
}