<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Controller', 'Controller');
class ArticlesAppController extends AppController{
    public $helpers = array('Cms.Cms', 'Articles.Article', 'Avatar.Avatar');
    
    public $components = array('Articles.CheckDataColunista');
    
    public function beforeFilter()
	{
		parent::beforeFilter();
        if(($this->request['controller'] <> 'profiles')){
                    $colData = $this->Session->read('Auth.User.person_id');
                    if(!$this->CheckDataColunista->start($this->Session->read('Auth.User.person_id'), $this->action, $this->params['pass'][0])){
                       $this->Session->setFlash(__($this->CheckDataColunista->errors), 'default', array('class' => 'error')); 
                       $this->redirect($this->CheckDataColunista->url);
                    }
        }
	}

    
}
