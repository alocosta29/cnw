<?php
/* *
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AccessUsersAppController', 'AccessUsers.Controller');

class AccessAdsController extends AccessUsersAppController{
    public $uses = array('AccessUsers.AccessCaderno', 'ConfigBook.Caderno', 'AccessUsers.AccessUser');
    public $components = array('AccessUsers.GetPermissionColumns', 'AccessUsers.SetAccessDataColumns');
    
    public function admin_enableDisabledCreateAds($user_id)
    {
       if($this->GetPermissionColumns->start($user_id, 'cad'))
       {
                 if($this->request->is('post') || $this->request->is('put'))
                 {
                     $data = $this->request->data; 
                     if($this->SetAccessDataColumns->start($data, $user_id, 'cad'))
                     {
                        $dataSave = $this->SetAccessDataColumns->dataSave;   
                        $datasource = $this->AccessUser->getDataSource();
                         try{
                                 $datasource->begin();
                                 if(!empty($dataSave['save']['AccessUser'])){
                                     if(!$this->AccessUser->save($dataSave['save']['AccessUser']))
                                        { throw new Exception(); }
                                 }                                 
                                 if(!empty($dataSave['save']['AccessCaderno'])){
                                     if(!$this->AccessCaderno->saveMany($dataSave['save']['AccessCaderno']))
                                        { throw new Exception(); }
                                 }                                 
                                 if(!empty($dataSave['deleteAll']['AccessUser']))
                                 {
                                      if(!$this->AccessUser->updateAll(
                                                array(
                                                            'AccessUser.disabledby' => $dataSave['deleteAll']['AccessUser']['set']['disabledby'],
                                                            'AccessUser.date_disabled' =>   "'".$dataSave['deleteAll']['AccessUser']['set']['date_disabled']. "'",
                                                            'AccessUser.isactive' =>  "'".$dataSave['deleteAll']['AccessUser']['set']['isactive']. "'"
                                                    ),
                                                array(
                                                            'AccessUser.package_id' => $dataSave['deleteAll']['AccessUser']['conditions']['package_id'],
                                                            'AccessUser.user_id' => $dataSave['deleteAll']['AccessUser']['conditions']['user_id'],
                                                      )
                                            )){ throw new Exception();  }	
                                 }
                                 if(!empty($dataSave['deleteAll']['AccessCaderno']))
                                 {
                                      if(!$this->AccessCaderno->updateAll(
                                                array(
                                                            'AccessCaderno.disabledby' => $dataSave['deleteAll']['AccessCaderno']['set']['disabledby'],
                                                            'AccessCaderno.date_disabled' =>   "'".$dataSave['deleteAll']['AccessCaderno']['set']['date_disabled']. "'",
                                                            'AccessCaderno.isactive' =>  "'".$dataSave['deleteAll']['AccessCaderno']['set']['isactive']. "'"
                                                    ),
                                                array(
                                                            'AccessCaderno.type' => $dataSave['deleteAll']['AccessCaderno']['conditions']['type'],
                                                            'AccessCaderno.user_id' => $dataSave['deleteAll']['AccessCaderno']['conditions']['user_id'],
                                                      )
                                            )){ throw new Exception();  }	
                                 }
                                 if(!empty($dataSave['delete']['AccessCaderno']))
                                 {
                                     $updateInactives = $dataSave['delete']['AccessCaderno'];
                                     $totalSize = sizeof($updateInactives);
                                     $i=0;
                                  
                                     while($i<$totalSize)
                                     {                                        
                                            if(!$this->AccessCaderno->updateAll(
                                                    array(
                                                                'AccessCaderno.disabledby' => $updateInactives[$i]['set']['disabledby'],
                                                                'AccessCaderno.date_disabled' =>  "'".$updateInactives[$i]['set']['date_disabled']."'",
                                                                'AccessCaderno.isactive' =>  "'".$updateInactives[$i]['set']['isactive']."'"                                                    
                                                        ),
                                                    array(
                                                                'AccessCaderno.caderno_id' => $updateInactives[$i]['conditions']['caderno_id'],
                                                                'AccessCaderno.user_id' => $updateInactives[$i]['conditions']['user_id'],
                                                                'AccessCaderno.type' => $updateInactives[$i]['conditions']['type'],
                                                                'AccessCaderno.isactive' => $updateInactives[$i]['conditions']['isactive']
                                                          )
                                                )){ throw new Exception();  }	
                                             $i++;
                                     }
                                 }
                                 $datasource->commit();
                                 $this->Session->setFlash(__('Sucesso!!!'), 'default', array('class' => 'success'));
                                $this->redirect(array('action' => 'enableDisabledCreateAds', $user_id));
                             }catch(Exception $e){
                                 $datasource->rollback();
   
                                 $this->Session->setFlash(__('As atualizações não puderam ser completadas...'), 'default', array('class' => 'error'));
                                 $this->redirect(array('action' => 'enableDisabledCreateAds', $user_id));
                             }	

                     }else{
                        $this->Session->setFlash(__($this->SetAccessDataColumns->errors), 'default', array('class' => 'error'));
                        $this->redirect(array('action' => 'enableDisabledCreateAds', $user_id));
                     }

                 }
                 $listCadernos = $this->Caderno->find('list', 
                 array(
                     'fields'=>array('Caderno.id', 'Caderno.nome'),
                     'conditions'=>array('Caderno.isdeleted'=>'N', 'Caderno.isactive'=>'Y'))); 
                $list['Cadernos'] = $listCadernos;
                $this->set('list', $list);
                $this->set('checkCadernos', $this->GetPermissionColumns->listIdCadernos);
                $this->set('authorizedPackage', $this->GetPermissionColumns->authorizedPackage);
        }else{
           $this->Session->setFlash(__($this->GetPermissionColumns->errors), 'default', array('class' => 'error'));
           $this->redirect(array('plugin'=>'manager', 'controller'=>'profileUsers', 'action' => 'consultaUsuarios'));
        }   
    }
    
    public function admin_enableDisabledAdminAds($user_id)
    {
       if($this->GetPermissionColumns->start($user_id, 'ads'))
       {
                 if($this->request->is('post') || $this->request->is('put'))
                 {
                     $data = $this->request->data; 
                     if($this->SetAccessDataColumns->start($data, $user_id, 'ads'))
                     {
                        $dataSave = $this->SetAccessDataColumns->dataSave;   
                        $datasource = $this->AccessUser->getDataSource();
                         try{
                                 $datasource->begin();
                                 if(!empty($dataSave['save']['AccessUser'])){
                                     if(!$this->AccessUser->save($dataSave['save']['AccessUser']))
                                        { throw new Exception(); }
                                 }                                 
                                 if(!empty($dataSave['save']['AccessCaderno'])){
                                     if(!$this->AccessCaderno->saveMany($dataSave['save']['AccessCaderno']))
                                        { throw new Exception(); }
                                 }                                 
                                 if(!empty($dataSave['deleteAll']['AccessUser']))
                                 {
                                      if(!$this->AccessUser->updateAll(
                                                array(
                                                            'AccessUser.disabledby' => $dataSave['deleteAll']['AccessUser']['set']['disabledby'],
                                                            'AccessUser.date_disabled' =>   "'".$dataSave['deleteAll']['AccessUser']['set']['date_disabled']. "'",
                                                            'AccessUser.isactive' =>  "'".$dataSave['deleteAll']['AccessUser']['set']['isactive']. "'"
                                                    ),
                                                array(
                                                            'AccessUser.package_id' => $dataSave['deleteAll']['AccessUser']['conditions']['package_id'],
                                                            'AccessUser.user_id' => $dataSave['deleteAll']['AccessUser']['conditions']['user_id'],
                                                      )
                                            )){ throw new Exception();  }	
                                 }
                                 if(!empty($dataSave['deleteAll']['AccessCaderno']))
                                 {
                                      if(!$this->AccessCaderno->updateAll(
                                                array(
                                                            'AccessCaderno.disabledby' => $dataSave['deleteAll']['AccessCaderno']['set']['disabledby'],
                                                            'AccessCaderno.date_disabled' =>   "'".$dataSave['deleteAll']['AccessCaderno']['set']['date_disabled']. "'",
                                                            'AccessCaderno.isactive' =>  "'".$dataSave['deleteAll']['AccessCaderno']['set']['isactive']. "'"
                                                    ),
                                                array(
                                                            'AccessCaderno.type' => $dataSave['deleteAll']['AccessCaderno']['conditions']['type'],
                                                            'AccessCaderno.user_id' => $dataSave['deleteAll']['AccessCaderno']['conditions']['user_id'],
                                                      )
                                            )){ throw new Exception();  }	
                                 }
                                 if(!empty($dataSave['delete']['AccessCaderno']))
                                 {
                                     $updateInactives = $dataSave['delete']['AccessCaderno'];
                                     $totalSize = sizeof($updateInactives);
                                     $i=0;
                                  
                                     while($i<$totalSize)
                                     {                                        
                                            if(!$this->AccessCaderno->updateAll(
                                                    array(
                                                                'AccessCaderno.disabledby' => $updateInactives[$i]['set']['disabledby'],
                                                                'AccessCaderno.date_disabled' =>  "'".$updateInactives[$i]['set']['date_disabled']."'",
                                                                'AccessCaderno.isactive' =>  "'".$updateInactives[$i]['set']['isactive']."'"                                                    
                                                        ),
                                                    array(
                                                                'AccessCaderno.caderno_id' => $updateInactives[$i]['conditions']['caderno_id'],
                                                                'AccessCaderno.user_id' => $updateInactives[$i]['conditions']['user_id'],
                                                                'AccessCaderno.type' => $updateInactives[$i]['conditions']['type'],
                                                                'AccessCaderno.isactive' => $updateInactives[$i]['conditions']['isactive']
                                                          )
                                                )){ throw new Exception();  }	
                                             $i++;
                                     }
                                 }
                                 $datasource->commit();
                                 $this->Session->setFlash(__('Sucesso!!!'), 'default', array('class' => 'success'));
                                $this->redirect(array('action' => 'enableDisabledAdminAds', $user_id));
                             }catch(Exception $e){
                                 $datasource->rollback();
   
                                 $this->Session->setFlash(__('As atualizações não puderam ser completadas...'), 'default', array('class' => 'error'));
                                 $this->redirect(array('action' => 'enableDisabledAdminAds', $user_id));
                             }	

                     }else{
                        $this->Session->setFlash(__($this->SetAccessDataColumns->errors), 'default', array('class' => 'error'));
                        $this->redirect(array('action' => 'enableDisabledAdminAds', $user_id));
                     }

                 }
                 $listCadernos = $this->Caderno->find('list', 
                 array(
                     'fields'=>array('Caderno.id', 'Caderno.nome'),
                     'conditions'=>array('Caderno.isdeleted'=>'N', 'Caderno.isactive'=>'Y'))); 
                $list['Cadernos'] = $listCadernos;
                $this->set('list', $list);
                $this->set('checkCadernos', $this->GetPermissionColumns->listIdCadernos);
                $this->set('authorizedPackage', $this->GetPermissionColumns->authorizedPackage);
        }else{
           $this->Session->setFlash(__($this->GetPermissionColumns->errors), 'default', array('class' => 'error'));
           $this->redirect(array('plugin'=>'manager', 'controller'=>'profileUsers', 'action' => 'consultaUsuarios'));
        }    
    }
}