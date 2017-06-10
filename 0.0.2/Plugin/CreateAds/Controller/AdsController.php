<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CreateAdsAppController', 'CreateAds.Controller');
class AdsController extends CreateAdsAppController{
        public $uses = array('Monetization.Ad', 'Monetization.AdType');
        public $components = array('UploadFile', 'CreateAds.TreatAd', 'CreateAds.ValidEditAd', 'ManagerAds.ReportAd');
        
        public function admin_index($caderno = null)
        {
        $this->ReportAd->start($caderno, 'createAd');       
              # pr('followme'); exit();
        $this->set('report', $this->ReportAd->report);

            $this->set('caderno', $caderno);
        } 
        
        
        public function admin_add($caderno = null)
        {
            if($this->request->is('post'))
            {
                  $data = $this->request->data;
          
                  if($this->TreatAd->start($data, $caderno))
                  {
                        $save = $this->TreatAd->save;
                        $save['Ad']['status'] = 'R';
                        
               
                        $datasource = $this->Ad->getDataSource();
                        try{
                            $datasource->begin();
                            $this->Ad->Behaviors->disable('Locale');
                            if(!$this->Ad->save($save)){
                                throw new Exception();	
                            }			

                            $datasource->commit();
                            $this->Session->setFlash(__('O anúncio foi criado com sucesso!'), 'default', array('class'=>'success'));
                            $this->redirect(array('action' => 'list', 'admin'=>TRUE, $caderno));
                        }catch(Exception $e){
                            $datasource->rollback();
                            $this->TreatAd->delAdImageError();
                            $this->Session->setFlash(__('O anúncio pode ser criado. Por favor, tente novamente!!'), 'default', array('class'=>'error'));
                        }
                  }else{
                      $this->request->data = $data;
                      $this->Session->setFlash(__($this->TreatAd->errors), 'default', array());
                  }
            }
            $listTypes = $this->AdType->find('list', 
                     array(
                             'conditions'=>array('AdType.isdeleted'=>'N', 'AdType.isactive'=>'Y'),
                             'fields'=>array('AdType.id', 'AdType.tipo'),
                             'order'=>array('AdType.tipo'=>'ASC')
                         ));  

            $this->set('listTypes', $listTypes);
            $this->set('caderno', $caderno);
        }
       
        
        public function admin_edit($caderno = null, $id = null)
        {
                if($this->ValidEditAd->start($id, $caderno, 'editAd'))
                {
                     $dataAd = $this->ValidEditAd->dataAd;
                     if($this->request->is('post') || $this->request->is('put'))
                     {
                            $dataSave = $this->request->data;
                            $dataSave['Ad']['id'] = $id;
                                    
                            $datasource = $this->Ad->getDataSource();
                            try{
                                    $datasource->begin();
                                    $this->Ad->Behaviors->disable('Locale');
                                    if(!$this->Ad->save($dataSave)){
                                            throw new Exception();				
                                    }                                                        
                                    $datasource->commit();
                                    $this->Session->setFlash(__('Anúncio atualizado com sucesso!'), 'default', array('class' => 'success'));
                                    $this->redirect(array('action'=>'view', $caderno, $id));
                            }catch(Exception $e){
                                    $datasource->rollback();
                                    $this->request->data = $dataSave;
                                    $this->Session->setFlash(__('Não foi possivel atualizar o anúncio. Por favor, tente novamente!'), 'default', array('class' => 'error'));
                            }
                     }else{
                         $this->request->data['Ad'] = $dataAd;
                     }
                }else{
                    $this->Session->setFlash(__($this->ValidEditAd->errors), 'default', array('class' => 'error'));
                    $this->redirect(array('action' => 'list', $caderno)); 
                }
                $listTypes = $this->AdType->find('list', 
                        array(
                                'conditions'=>array('AdType.isdeleted'=>'N', 'AdType.isactive'=>'Y'),
                                'fields'=>array('AdType.id', 'AdType.tipo'),
                                'order'=>array('AdType.tipo'=>'ASC')
                            ));   
   
                 $ValidEditAd = $this->ValidEditAd;
                
                $this->set('listTypes', $listTypes);
                $idAd = $id;
                $this->set(compact('caderno', 'idAd', 'ValidEditAd'));
        }    
       
        public function admin_list($caderno = null)
        {
           	$options = array(
                    'conditions' => array(
                                            'Ad.isdeleted' => 'N', 
                                            'Ad.user_id'=>$this->Session->read('Auth.User.id'),
                                            'Caderno.alias'=>$caderno
                                            ),
                    'order' => array('Ad.id' => 'DESC'),
		);
                $Ads = $this->Ad->find('all', $options);
                $this->set('Ads', $Ads);
                $this->set('caderno', $caderno);
        }
       
        public function admin_view($caderno = null, $idAd = null)
        {
                if($this->ValidEditAd->start($idAd, $caderno, 'viewAd'))
                {
                     $dataAd = $this->ValidEditAd->dataAd;
                     $ValidEditAd = $this->ValidEditAd;
                     
                     $this->set(compact('caderno', 'idAd', 'dataAd', 'ValidEditAd'));
                }else{
                    $this->Session->setFlash(__($this->ValidEditAd->errors), 'default', array('class' => 'error'));
                    $this->redirect(array('action' => 'list', $caderno));
                }
            
        }
          
        
       public function admin_delete($caderno = null, $idAd = null)
       {
           if($this->ValidEditAd->start($idAd, $caderno, 'deleteAd'))
            {
                    $ModelParaDel['Ad']['isdeleted']='Y';
                    $ModelParaDel['Ad']['id'] = $idAd;
                    $this->Ad->Behaviors->disable('Locale');
                    if($this->Ad->save($ModelParaDel))
                    {
                        $this->Session->setFlash(__('Anúncio apagado com sucesso!!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'list', $caderno));
                    }else{
                        $this->Session->setFlash(__('O anúncio não pode ser deletado. Por favor tente novamente'), 'default', array());
                        $$this->redirect(array('action' => 'view', $caderno, $idAd));
                    }
            }else{
                    $this->Session->setFlash(__($this->ValidEditAd->errors), 'default', array('class' => 'error'));
                    $this->redirect(array('action' => 'list', $caderno));
           } 
       } 
        
       public function admin_changeStatus($caderno = null, $idAd = null, $status = false)
       {
            if($this->ValidEditAd->start($idAd, $caderno, 'changeStatusCol', $status))
            {
                    $datasource = $this->Ad->getDataSource();
                    try{
                        $datasource->begin();
                        $this->Ad->Behaviors->disable('Locale');
                        $this->Ad->id = $idAd;
                        if(!$this->Ad->saveField('status', $status)){
                            throw new Exception();			
                        }

                        $datasource->commit();
                        $this->Session->setFlash(__('Status do anúncio alterado com sucesso!!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'view', $caderno, $idAd));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__('O status do anúncio não pode ser alterado. Por favor, tente novamente!'), 'default', array('class' => 'error'));
                        $this->redirect(array('action' => 'view', $caderno, $idAd));
                    }
            }else{
                    $this->Session->setFlash(__($this->ValidEditAd->errors), 'default', array('class' => 'error'));
                    $this->redirect(array('action' => 'view', $caderno, $idAd));
            } 
       }
        
        
        public function admin_newReview($caderno = null, $idAd = null)
        {
            
            if($this->ValidEditAd->start($idAd, $caderno, 'newReview'))
                {
                        $dataAd = $this->ValidEditAd->dataAd;
                        $save['Ad']['id'] = $idAd;
                        $save['Ad']['versao'] = $dataAd['versao']+1;
                        $save['Ad']['status'] = 'R';
                        $save['Ad']['disapprovedby'] = null;
                        $save['Ad']['approvedby'] = null;
                     
                        $datasource = $this->Ad->getDataSource();
                        try{
                            $datasource->begin();

                           $this->Ad->Behaviors->disable('Locale');
                            if(!$this->Ad->save($save, array('validates'=>false))){
                                throw new Exception();			
                            }

                            $datasource->commit();
                            $this->Session->setFlash(__('Nova revisão criada com sucesso!!'), 'default', array('class' => 'success'));
                            $this->redirect(array('action' => 'view', $caderno, $idAd));
                        }catch(Exception $e){
                            $datasource->rollback();
                            $this->Session->setFlash(__('A revisão não pode ser criada. Por favor, tente novamente!'), 'default', array('class' => 'error'));
                            $this->redirect(array('action' => 'view', $caderno, $idAd));
                        }
                }else{
                        $this->Session->setFlash(__($this->ValidEditAd->errors), 'default', array('class' => 'error'));
                        $this->redirect(array('action' => 'view', $caderno, $idAd));
                }     
            
            
            
            
        }
        
    
}