<?php
App::uses('ManagerAppController', 'Manager.Controller');

class MenuController extends ManagerAppController{
	public $uses = array('Manager.Menugroup');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		if($this->Session->read('Auth.User.id')){
			$this->Auth->allow('admin_menu');
		}else{
		    $this->redirect(array('plugin'=>'manager', 'controller'=>'users', 'action'=>'login', 'admin'=>true));
            
		}
	} 		
		
	public function admin_menu($id = null)
	{	
		$this->Menugroup->id = $id;
		if (!$this->Menugroup->exists()) 
		{
			$this->redirect(array('plugin'=>'manager', 'controller'=>'users', 'action'=>'index'));
		}
		
		$options = array(
						'fields'=>array('Menugroup.id', 'Menugroup.grupo'),
						'order'=>array('Menugroup.ordem'=>'ASC'),
						'conditions'=>array('Menugroup.isdeleted'=>'N', 'Menugroup.parent_id'=>$id)
		);				
		//$menu = $this->Menugroup->find('list', $options);
		
		$this->set('menu', $id);
	}

}