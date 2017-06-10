<?php
App::uses('AppController', 'Controller');
/**
 * Menugroups Controller
 * @property Menugroup $Menugroup
 */
class MenugroupsController extends AppController {
	public function admin_index()
	{
		$this->Menugroup->recursive = 0;
		$options = array(
			'conditions' => array('Menugroup.isdeleted' => 'N'),
			'order' => array('Menugroup.ordem' => 'ASC'),
			'limit' => 20
		);
		$this->paginate = $options;
		$menugroups = $this->paginate('Menugroup');
		$this->set('menugroups', $menugroups);
	}

	/**
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Menugroup->exists($id)) {
			throw new NotFoundException(__('Invalid menugroup'));
		}
		$options = array('conditions' => array('Menugroup.' . $this->Menugroup->primaryKey => $id));
		$this->set('menugroup', $this->Menugroup->find('first', $options));
	}
	
	/**
	 * admin_add method
	 * @return void
	 */
	public function admin_add() 
	{
		if ($this->request->is('post')) {
			$this->Menugroup->create();
			$data = $this->request->data;
			if($data['Menugroup']['parent_id'] < 1){
				$data['Menugroup']['parent_id'] = null;	
			}
			if ($this->Menugroup->save($data)) {
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array());
			}
		}
		$parent_id = $this->Menugroup->find('list', array(
		'fields'=>array('Menugroup.id', 'Menugroup.grupo'),
		'order'=>array('Menugroup.grupo'=>'ASC'),
		'conditions'=>array('Menugroup.isdeleted'=>'N')));
		$parent_id[0] = 'Nenhum';
		$this->set('parent_id', $parent_id);
	}

	/**
	 * admin_edit method
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null){
		if (!$this->Menugroup->exists($id)){
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$data['Menugroup']['id'] = $id;
			if($data['Menugroup']['parent_id'] < 1){
				$data['Menugroup']['parent_id'] = null;	
			}
			if ($this->Menugroup->save($data)) {
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaEdit));
			}
		} else {
			$options = array('conditions' => array('Menugroup.' . $this->Menugroup->primaryKey => $id));
			$this->request->data = $this->Menugroup->find('first', $options);
		}
			$parent_id = $this->Menugroup->find('list', array(
		'fields'=>array('Menugroup.id', 'Menugroup.grupo'),
		'order'=>array('Menugroup.grupo'=>'ASC'),
		'conditions'=>array('Menugroup.isdeleted'=>'N',
		'NOT'=>array('Menugroup.id'=>$id))));
		$parent_id[0] = 'Nenhum';
		$this->set('parent_id', $parent_id);
	}

	/**
	 * admin_delete method
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Menugroup->id = $id;
		if (!$this->Menugroup->exists()) {
			throw new NotFoundException(__('Grupo de menu inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Menugroup->delete()) {
			$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * Método que deverá servir de base para configuração do menu
	 */
	public function admin_configMenu()
	{
		$this->loadModel('Manager.Module');
		$this->loadModel('Manager.Aco');
		$this->Module->recursive = -1;
		$this->Aco->recursive = -1;
		
		$modulos = $this->Module->find('all', array(
							'fields'=>array('Module.id', 'Module.nome', 'Module.alias'),
							'conditions'=>array(
							'Module.isdeleted'=>'N'),
							'order'=>array('Module.nome'=>'ASC')));	
		
		$options['fields'] = array(
									'Aco.aliasMenu',
									'Aco.descricao',
									'Aco.id',
									'Aco.menugroup_id',
									'Aco.module_id'
									);				
		$options['conditions']['NOT']['Aco.module_id < '] = 1;
		if($this->Session->read('Auth.User.role_id') <> 1){
			$options['conditions']['Aco.restrito'] = 'N';	
		}
		$acos = $this->Aco->find('all', $options);
		$this->set('modulos', $modulos);
		$this->set('acos', $acos);
	}
	

	/**
	 * tela de edição para o administrador.
	 * Através dela, ele poderá configurar nome do item de menu, descrição, 
	 */
	public function admin_editItemMenu($id = null)
	{
		$this->loadModel('Manager.Aco');
		if (!$this->Aco->exists($id)) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		$this->Aco->recursive = -1;
		$data = $this->Aco->findById($id);
                
		if($this->request->is('post') || $this->request->is('put'))
		{
			$data = $this->request->data;
			$data['Aco']['id'] = $id;
                        if($data['Aco']['menuEsquerdo'] == 'Y'){
                          $data['Aco']['menuEsquerdo'] = 1; 
                        }elseif($data['Aco']['menuEsquerdo'] == 'N'){
                           $data['Aco']['menuEsquerdo'] = 0;  
                        }
                        
			if ($this->Aco->save($data)) 
			{
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('plugin'=>'manager', 'controller'=>'menugroups', 'action' => 'configMenu', 'admin'=>true));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Aco.' . $this->Aco->primaryKey => $id));
			$this->request->data = $this->Aco->find('first', $options);
		}
		$listmenu = $this->Menugroup->find('list', array(
		'fields'=>array('Menugroup.id', 'Menugroup.grupo'),
		'order'=>array('Menugroup.grupo'=>'asc')));
		$this->set('listmenu', $listmenu);	
	}
}