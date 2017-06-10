<?php
class PackagesController extends ManagerPackagesAppController {
	//public $name = 'Packages';
	public $uses=array('ManagerPackages.Package');
	
	public function admin_add()
	{
		if($this->request->is('post'))
		{
			$this->Package->create();
			if ($this->Package->save($this->request->data)) {
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array());
			}
		}
		$this->set('title_for_layout', 'Cadastro de pacotes');
	}	
	
	public function admin_ativa($id = null)
    {
            $this->Package->id = $id;
            if(!$this->Package->exists()) 
            {
                throw new NotFoundException(__($this->Mensagens->registroInvalido));
            }               
            $ModelParaAtivar['Package']['isactive']='Y';
            $ModelParaAtivar['Package']['id'] = $id;
            if($this->Package->saveAll($ModelParaAtivar))
            {
                $this->Session->setFlash(__($this->Mensagens->ativaSucesso), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index', 'admin'=>TRUE));
            }
            $this->Session->setFlash(__($this->Mensagens->falhaAtiva), 'default', array());
            $this->redirect(array('action' => 'index', 'admin'=>TRUE));
    }

    public function admin_desativa($id = null)
    {
            $this->Package->id = $id;
            if (!$this->Package->exists()) 
            {
                throw new NotFoundException(__($this->Mensagens->registroInvalido));
            }               
            $ModelParaDesativar['Package']['isactive']='N';
            $ModelParaDesativar['Package']['id'] = $id;
            if($this->Package->saveAll($ModelParaDesativar))
            {
                $this->Session->setFlash(__($this->Mensagens->desativaSucesso), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index', 'admin'=>TRUE));
            }
            $this->Session->setFlash(__($this->Mensagens->falhaDesativa), 'default', array());
            $this->redirect(array('action' => 'index', 'admin'=>TRUE));
    }
    public function admin_edit($id = null) 
    {
		if (!$this->Package->exists($id)) {
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    $data = $this->request->data;
                    $data['Package']['id'] = $id;
			if ($this->Package->save($data)) {
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Package.' . $this->Package->primaryKey => $id));
			$this->request->data = $this->Package->find('first', $options);
                                     
		}
		$this->set('title_for_layout', 'Edição de pacotes');
	}
	
	
	public function admin_index()
	{
		    $options = array(
					
						'conditions' => array('Package.isdeleted' => 'N'),
						'order' => array('Package.id' => 'DESC'),
						'limit' => 10
			);
			$this->paginate = $options;
			// Roda a consulta, já trazendo os resultados paginados
			$packages = $this->paginate('Package');
			// Envia os dados pra view
			$this->set('packages', $packages);
			$this->set('title_for_layout', 'Listagem de pacotes cadastrados');
	}	
	
	
	public function admin_delete($id = null) {
		$this->Package->id = $id;
		if (!$this->Package->exists()) {
			throw new NotFoundException(__('Invalid gp function'));
		}
			$PackageParaDeletar = $this->Package->read(null, $id);
			$PackageParaDeletar['Package']['isdeleted']='Y';
		if($this->Package->saveAll($PackageParaDeletar))
		{
			$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

	
}