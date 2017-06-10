<?php
App::uses('FormulariosAppController', 'Formularios.Controller');
class AreasController extends FormulariosAppController{
    
   public $uses = array('Formularios.Area');

   public function admin_index() 
   {   
        $options = array(
            'conditions' => array('Area.isdeleted' => 'N'),
            'order' => array('Area.id' => 'DESC'),
            'limit' => 20
        );
        $this->paginate = $options;
        $Areas = $this->paginate('Area');
        $this->set('Areas', $Areas);
        $this->set('title_for_layout', 'Áreas cadastradas');
   }

   public function admin_add(){
        if($this->request->is('post')){
            $data = $this->request->data;
            $this->Area->create();
            if($this->Area->save($data))
            {           
                $this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
            }
        }
    }

    public function admin_edit($id = null) 
    {
        if(!$this->Area->exists($id)) 
        {
            throw new NotFoundException(__($this->Mensagens->registroInvalido));
        }
        if($this->request->is('post') || $this->request->is('put')) 
        {
            $data = $this->request->data;
            $data['Area']['id'] = $id;
            if($this->Area->save($data)) 
            {
                $this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
            }
        }else{
            $options = array('conditions' => array('Area.' . $this->Area->primaryKey => $id));
            $this->request->data = $this->Area->find('first', $options);
        }
    }

    public function admin_delete($id = null) 
    {
        $this->Area->id = $id;
        if(!$this->Area->exists()) 
        {
            throw new NotFoundException(__($this->Mensagens->registroInvalido));
        }
                $AreaParaDeletar['Area']['id']= $id;
                $AreaParaDeletar['Area']['isdeleted']='Y';
                if($this->Area->saveAll($AreaParaDeletar))
                {
                    $this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'index'));
                }else{
                    $this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
                    $this->redirect(array('action' => 'index'));
                }
    }
}