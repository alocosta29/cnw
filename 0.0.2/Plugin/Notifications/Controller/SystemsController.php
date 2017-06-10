<?php
App::uses('AppController', 'Controller');
/**
 * Systems Controller
 *
 * @property System $System
 */
class SystemsController extends AppController {
/**
	public function index() {
		$this->System->recursive = 0;
		$this->set('systems', $this->paginate());
	}

	public function view($id = null) {
		if (!$this->System->exists($id)) {
			throw new NotFoundException(__('Invalid system'));
		}
		$options = array('conditions' => array('System.' . $this->System->primaryKey => $id));
		$this->set('system', $this->System->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->System->create();
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		if (!$this->System->exists($id)) {
			throw new NotFoundException(__('Invalid system'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('System.' . $this->System->primaryKey => $id));
			$this->request->data = $this->System->find('first', $options);
		}
	}

	public function delete($id = null) {
		$this->System->id = $id;
		if (!$this->System->exists()) {
			throw new NotFoundException(__('Invalid system'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->System->delete()) {
			$this->Session->setFlash(__('System deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('System was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function admin_index() {
		$this->System->recursive = 0;
		$this->set('systems', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$this->System->exists($id)) {
			throw new NotFoundException(__('Invalid system'));
		}
		$options = array('conditions' => array('System.' . $this->System->primaryKey => $id));
		$this->set('system', $this->System->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->System->create();
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$this->System->exists($id)) {
			throw new NotFoundException(__('Invalid system'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('System.' . $this->System->primaryKey => $id));
			$this->request->data = $this->System->find('first', $options);
		}
	}

	public function admin_delete($id = null) {
		$this->System->id = $id;
		if (!$this->System->exists()) {
			throw new NotFoundException(__('Invalid system'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->System->delete()) {
			$this->Session->setFlash(__('System deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('System was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
**/    
}
