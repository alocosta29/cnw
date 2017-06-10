<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('ManagerAdsAppController', 'ManagerAds.Controller');
class ManagerAdsController extends ManagerAdsAppController{
    public $uses = array('Monetization.Ad', 'Monetization.AdType', 'Monetization.AdCategorie');
    public $components = array('ManagerAds.ValidManagerAd', 'ManagerAds.ReportAd');
          
    /**
           * Método que é a página inicial dos colunistas
           */
    public function admin_index($caderno = null)
    {

        $this->ReportAd->start($caderno, 'adm');       
       # pr('followme'); exit();
        $this->set('report', $this->ReportAd->report);
        
        #pr($this->plugin); exit(0);
        
        $this->set('caderno', $caderno);
    }
    

    public function admin_pendingAds($caderno = null)
    {
        $options = array(
            'conditions' => array(
                                    'Ad.isdeleted' => 'N', 
                                    'Ad.status'=>'A',
                                    'Caderno.alias'=>$caderno
                                    ),
            'order' => array('Ad.id' => 'DESC'),
        );
        $Ads = $this->Ad->find('all', $options);
        $this->set('Ads', $Ads);
        $this->set('caderno', $caderno);
        $this->set('caderno', $caderno); 
    }
    
    /**
     * Anúncios autorizados
     * @param type $caderno
     */
    public function admin_authorizedAds($caderno = null)
    {
        $options = array(
                    'conditions' => array(
                                            'Ad.isdeleted' => 'N', 
                                            'Ad.status'=>'P',
                                            'Ad.approvedby'=>$this->Session->read('Auth.User.id'),
                                            'Caderno.alias'=>$caderno
                                            ),
                    'order' => array('Ad.id' => 'DESC'),
		);
        $Ads = $this->Ad->find('all', $options);
        $this->set('Ads', $Ads);  
        $this->set('caderno', $caderno); 
    }
    
    /**
     * Anúncios reprovados 
     * @param type $caderno
     */
    public function admin_reprovedAds($caderno = null)
    {
        $options = array(
             'conditions' => array(
                                     'Ad.isdeleted' => 'N', 
                                     'Ad.status'=>'N',
                                     'Ad.disapprovedby'=>$this->Session->read('Auth.User.id'),
                                     'Caderno.alias'=>$caderno
                                     ),
             'order' => array('Ad.id' => 'DESC'),
         );
         $Ads = $this->Ad->find('all', $options);
         $this->set('Ads', $Ads);  
         $this->set('caderno', $caderno);
    }
    
    
    
    public function admin_details($caderno = null, $idAd = null)
    {
       if($this->ValidManagerAd->start($idAd, $caderno, 'viewAd'))
       {
                $dataAd = $this->ValidManagerAd->dataAd;
                $ValidManagerAd = $this->ValidManagerAd;
                $this->set(compact('caderno', 'idAd', 'dataAd', 'ValidManagerAd'));
       }else{
            $this->Session->setFlash(__($this->ValidManagerAd->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'list', $caderno)); 
        }
    }
    
    public function admin_publish($caderno = null, $idAd = null)
    {
       if($this->ValidManagerAd->start($idAd, $caderno, 'publish'))
       {
            $saveAd['Ad']['id'] = $idAd;
            $saveAd['Ad']['status'] = 'P';
            $saveAd['Ad']['approvedby'] = $this->Session->read('Auth.User.id');
            $saveAd['Ad']['disapprovedby'] = null;
            
            $datasource = $this->Ad->getDataSource();
            try{
                    $datasource->begin();
                    $this->Ad->Behaviors->disable('Locale');
                    if(!$this->Ad->save($saveAd, array('validates' => false))){
                            throw new Exception();				
                    }

                    $datasource->commit();
                    $this->Session->setFlash(__('Anúncio aprovado!'), 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'details', $caderno, $idAd)); 
            }catch(Exception $e){
                    $datasource->rollback();
                    $this->Session->setFlash(__('Não foi possível aprovar o anúncio. Por favor, tente novamente!'), 'default', array('class' => 'error'));
                    $this->redirect(array('action' => 'details', $caderno, $idAd)); 
            }
       }else{
            $this->Session->setFlash(__($this->ValidManagerAd->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'list', $caderno)); 
        }   
    }
    
    
    /**
     * Método que reprova postagens
     * @param type $caderno
     * @param type $id
     */
    public function admin_reproveAds($caderno = null, $idAd = null)
    {
       
        if($this->ValidManagerAd->start($idAd, $caderno, 'reprove'))
        {
            $dataAd = $this->ValidManagerAd->dataAd;
            
            if($this->request->is('post') and !empty($this->request->data['Ad']['comments']))
            {
             
                $save['Ad']['id'] = $idAd;
                $save['Ad']['status'] = 'N';
                $save['Ad']['comments'] = $dataAd['new_comments'].$this->request->data['Ad']['comments'];
                $save['Ad']['approvedby'] = null;
                $save['Ad']['disapprovedby'] =  $this->Session->read('Auth.User.id');
       # pr($save); exit();
                $datasource = $this->Ad->getDataSource();
                try{
                        $datasource->begin();
                        
                        $this->Ad->Behaviors->disable('Locale');
                        if(!$this->Ad->save($save)){
                                throw new Exception();				
                        }                        
                        
                        $datasource->commit();
                        $this->Session->setFlash(__('O anúncio foi enviado para revisão com sucesso!!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'details', $caderno, $idAd));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__('O anúncio não pode ser enviado para revisão. Por favor tente novamente'), 'default', array());
                        
                    }
            }          
                $ValidManagerAd = $this->ValidManagerAd;
                $this->set(compact('caderno', 'idAd', 'dataAd', 'ValidManagerAd'));
        }else{
            $this->Session->setFlash(__($this->ValidManagerAd->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'details', $caderno, $idAd));
        }
    } 
    
    
    
    
    
}