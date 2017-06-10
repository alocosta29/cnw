<?php
App::uses('AppController', 'Controller');
/**
 * Systemsreleases Controller
 *
 * @property Systemsrelease $Systemsrelease
 */
class SystemsreleasesController extends AppController {
/**
	public function index() {
		$this->Systemsrelease->recursive = 0;
		$this->set('systemsreleases', $this->paginate());
	}

	public function view($id = null) {
		if (!$this->Systemsrelease->exists($id)) {
			throw new NotFoundException(__('Invalid systemsrelease'));
		}
		$options = array('conditions' => array('Systemsrelease.' . $this->Systemsrelease->primaryKey => $id));
		$this->set('systemsrelease', $this->Systemsrelease->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Systemsrelease->create();
			if ($this->Systemsrelease->save($this->request->data)) {
				$this->Session->setFlash(__('The systemsrelease has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The systemsrelease could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		if (!$this->Systemsrelease->exists($id)) {
			throw new NotFoundException(__('Invalid systemsrelease'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Systemsrelease->save($this->request->data)) {
				$this->Session->setFlash(__('The systemsrelease has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The systemsrelease could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Systemsrelease.' . $this->Systemsrelease->primaryKey => $id));
			$this->request->data = $this->Systemsrelease->find('first', $options);
		}
	}

	public function delete($id = null) {
		$this->Systemsrelease->id = $id;
		if (!$this->Systemsrelease->exists()) {
			throw new NotFoundException(__('Invalid systemsrelease'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Systemsrelease->delete()) {
			$this->Session->setFlash(__('Systemsrelease deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Systemsrelease was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function admin_index() {
		$this->Systemsrelease->recursive = 0;
		$this->set('systemsreleases', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$this->Systemsrelease->exists($id)) {
			throw new NotFoundException(__('Invalid systemsrelease'));
		}
		$options = array('conditions' => array('Systemsrelease.' . $this->Systemsrelease->primaryKey => $id));
		$this->set('systemsrelease', $this->Systemsrelease->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Systemsrelease->create();
			if ($this->Systemsrelease->save($this->request->data)) {
				$this->Session->setFlash(__('The systemsrelease has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The systemsrelease could not be saved. Please, try again.'));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$this->Systemsrelease->exists($id)) {
			throw new NotFoundException(__('Invalid systemsrelease'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Systemsrelease->save($this->request->data)) {
				$this->Session->setFlash(__('The systemsrelease has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The systemsrelease could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Systemsrelease.' . $this->Systemsrelease->primaryKey => $id));
			$this->request->data = $this->Systemsrelease->find('first', $options);
		}
	}

	public function admin_delete($id = null) {
		$this->Systemsrelease->id = $id;
		if (!$this->Systemsrelease->exists()) {
			throw new NotFoundException(__('Invalid systemsrelease'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Systemsrelease->delete()) {
			$this->Session->setFlash(__('Systemsrelease deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Systemsrelease was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
 **/   
}
