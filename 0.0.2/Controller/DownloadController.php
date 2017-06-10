<?php
App::uses('AppController', 'Controller');
class DownloadController extends AppController {
    public $components = array('DownloadManager');
      public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow(array('get'));
        if($this->Session->read('Auth.User.username'))
        {
           $this->Auth->allow(array('get', 'getCv')); 
        }else{
           $this->Auth->allow(array('get'));  
        }
        
        
    }   
        
    public function get($id = null) {
       
        if($this->DownloadManager->startDownload($id))
        {
            $this->viewClass= 'Media';
            // Download app/outside_webroot_dir/example.zip
          /*  $params = array(
                'id'        => 'folder.pdf', 'contrato.pdf',
                'name'      => 'folder', 'contrato',
                'download'  => true,
                'extension' => 'pdf',
                'path'      => APP . '/webroot/'.'download/'.DS
                //'path'      => APP . '/download/'.DS
            );*/
           // pr($this->DownloadManager->getDownloadParams());
            //exit(0);
            
            $this->set($this->DownloadManager->getDownloadParams());
           // $this->DownloadManager->delFile();
        }else{
           $this->Session->setFlash(__($this->DownloadManager->getErrors()), 'default', array());
           $this->redirect($this->DownloadManager->getUrl());
        }
        
        
        
    }
    
    public function getCv($id= null)
    {

    if($this->DownloadManager->startCvDownload($id))
        {
            $this->viewClass= 'Media';
            // Download app/outside_webroot_dir/example.zip
          /*  $params = array(
                'id'        => 'folder.pdf', 'contrato.pdf',
                'name'      => 'folder', 'contrato',
                'download'  => true,
                'extension' => 'pdf',
                'path'      => APP . '/webroot/'.'download/'.DS
                //'path'      => APP . '/download/'.DS
            );*/
           // pr($this->DownloadManager->getDownloadParams());
            //exit(0);
            $this->set($this->DownloadManager->getDownloadParams());
           // $this->DownloadManager->delFile();
        }else{
           $this->Session->setFlash(__($this->DownloadManager->getErrors()), 'default', array());
           $this->redirect($this->DownloadManager->getUrl());
        }
        
        
    }
    
    
    
    
    
    

}