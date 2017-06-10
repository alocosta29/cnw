<?php
App::uses('AppController', 'Controller');
class HelpController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        if ($this->Session->read('Auth.User')) {
            $this->Auth->allow('admin_index');
        }    
    }
    
     public function admin_index(){
        if ( (1==$this->Session->read('Auth.User.role_id')) ) {
           $dbMysql = ClassRegistry::init('ConfigBook.Caderno');
           $rsMysql =  $dbMysql->query('SELECT VERSION() as mysql');        
     
            $database = array(
                 'default('.ConnectionManager::getDataSource('default')->config['database'].')' => 'MySql '.substr($rsMysql[0][0]['mysql'],0,strpos($rsMysql[0][0]['mysql'],'-',1)).' via '.ConnectionManager::getDataSource('default')->config['host']
            );
            $this->set(compact('database'));
        }    
     }
}