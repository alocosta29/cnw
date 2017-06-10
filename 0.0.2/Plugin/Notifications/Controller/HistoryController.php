<?php
App::uses('AppController', 'Controller');
/**
 * Notifications Controller
 *
 * @property Notification $Notification
 */
class HistoryController extends AppController {
	public $uses = array('Notifications.Notification','Manager.User');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Notification->recursive = 0;
		$usuarioId = AuthComponent::user('id');
		$this->paginate = array('order'=>'Notification.created desc','conditions' => array('Notification.to_user_id' => $usuarioId, 'Notification.isdeleted' => 'N') );
		$this->set('notifications', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$usuarioId = AuthComponent::user('id');
		$optionsHasAny = array('Notification.to_user_id' => $usuarioId, 'Notification.isdeleted' => 'N','Notification.' . $this->Notification->primaryKey => $id);
		if (!$this->Notification->hasAny($optionsHasAny)) {
			throw new NotFoundException(__('Notificação inválida'));
		}
		$this->_markAsRead($id);
  		$options = array('conditions' => array('Notification.isdeleted' => 'N','Notification.' . $this->Notification->primaryKey => $id));
		$this->set('notification', $this->Notification->find('first', $options));
	}
	
/**
 * 
 * Enter description here ...
 * @param string $id
 * @throws NotFoundException
 */
	public function _markAsRead($id = null){
		if (!$this->Notification->exists($id)) {
			throw new NotFoundException(__('Notificação inválida'));
		}
		$this->Notification->read(null,$id);
		if( strlen(trim($this->Notification->data['Notification']['visualized'])) <=0 ){
			$dateTime = new DateTime();
			$this->Notification->data['Notification']['visualized'] = $dateTime->format( "Y-m-d H:i:s" );
			$this->Notification->save();
		}
	}
	

/**
* delete method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
	public function delete($id = null) {
		$usuarioId = AuthComponent::user('id');
		$optionsHasAny = array('Notification.isdeleted' => 'N','Notification.to_user_id' => $usuarioId,'Notification.' . $this->Notification->primaryKey => $id);
		if (!$this->Notification->hasAny($optionsHasAny)) {
			throw new NotFoundException(__('Notificação invalida'));
		}
		$this->Notification->id = $id;
		$this->request->onlyAllow('post', 'delete');
		if ($this->Notification->saveField('isdeleted', 'Y', array($validate = false))) {
   	 		$this->Session->setFlash(__('Notificação deletada!'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Notiticação não deletada'));
		$this->redirect(array('action' => 'index'));
	}
 
}
