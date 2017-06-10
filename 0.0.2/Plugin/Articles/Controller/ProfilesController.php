<?php
App::uses('ArticlesAppController', 'Articles.Controller');
class ProfilesController extends ArticlesAppController{
    public $uses = array('ManagerBook.Colunista');
    public $components = array('Articles.Profile');
    
    
    /**
     * Método que edita as informações de colunista
     * @param type $caderno
     */
    public function admin_edit($caderno = null)
    {        
        
        $profile = $this->Colunista->find('first', 
                array(
                    'conditions'=>array('Colunista.person_id'=>$this->Session->read('Auth.User.person_id'))));
        
       
                if($this->request->is('post') || $this->request->is('put')) 
                {
			$data = $this->request->data;
			$data['Colunista']['person_id'] = $this->Session->read('Auth.User.person_id');
			if($this->Colunista->save($data)) 
			{
				$this->Session->setFlash(__('Perfil editado com sucesso'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'view', $caderno));
			}else{
				$this->Session->setFlash(__('O perfil não pode ser editado. Por favor, tente novamente!'), 'default', array('class' => 'error'));
			}
		}else{
			$this->request->data = $profile;
		}
                #pr('ddddd'); exit();
                $this->set('caderno', $caderno);
    }
    
    /**
     * @param type $cadernosa
     */
    public function admin_view($caderno = null)
    {
        if($this->Profile->start($this->Session->read('Auth.User.person_id')))
        {
            
            
          # pr($this->Session->read('Auth.User'));
           #exit(0);
            
            
            
          /*  if($this->request->is('mobile')){
                pr('MOBILE'); exit(0);
            }else{
                 pr('PC'); exit(0);
            }*/
           # pr($this->Profile->dataProfile); exit(0);
            
            
            $this->set('profile', $this->Profile->dataProfile);
        }else{
            $this->Session->setFlash(__($this->Profile->errors), 'default', array('class' => 'error'));
	        $this->redirect(array('action' => 'view', $caderno));
        }
        $this->set('caderno', $caderno);
    }    
}