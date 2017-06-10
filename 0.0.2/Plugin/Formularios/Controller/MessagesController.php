<?php
App::uses('FormulariosAppController', 'Formularios.Controller');
class MessagesController extends FormulariosAppController{
   public $uses = array('Formularios.Rh', 'Formularios.Contato', 'Formularios.Orcamento', 'Formularios.Sugestao');
   
   /**
    * Método que lista o currículos recebidos pelo site
    */
  /* public function admin_listCvs()
   {       
         $options = array(
                            //'conditions' => array('Rh.isdeleted'=>'N', 'Rh.formulario_id'=>4),
                            'order' => array('Rh.id' => 'DESC'),
                            'limit' => 20
                         );
        $this->paginate = $options;
        $Rhs = $this->paginate('Rh');
        $this->set('Rhs', $Rhs);
        $this->set('title_for_layout', 'Currículos recebidos');
   }*/
      
   /**
    * Método que lista as menssagens recebidas pelo formulário de contato
    */
   public function admin_listContacts(){
         $options = array(
                            'conditions' => array('Contato.isdeleted'=>'N', 'Contato.formulario_id'=>1),
                            'order' => array('Contato.id' => 'DESC'),
                            'limit' => 20
                         );
        $this->paginate = $options;
        $Contatos = $this->paginate('Contato');
        $this->set('Contatos', $Contatos);
        $this->set('title_for_layout', 'Contatos recebidos');
   }
   
   /**
    * Método que lista as sugestões recebidas de colaboradores pelo site(caixinha de sugestões)
    */
 /*  public function admin_listSuggestions()
   {
     $options = array(
                            //'conditions' => array('Sugestao.isdeleted'=>'N'),
                            'order' => array('Sugestao.id' => 'DESC'),
                            'limit' => 20
                         );
        $this->paginate = $options;
        $Sugestaos = $this->paginate('Sugestao');
        $this->set('Sugestaos', $Sugestaos);
        $this->set('title_for_layout', 'Sugestões recebidas');
   
       
   }*/
   
       /**
     * Método que abre uma mensagem selecionada
     */
    /* public function admin_openSuggestion($id=null)
     {
        if(!$this->Sugestao->exists($id)) 
        {
            throw new NotFoundException(__($this->Mensagens->registroInvalido));
        }
        $options = array('conditions' => array('Sugestao.' . $this->Sugestao->primaryKey => $id));
        $message = $this->Sugestao->find('first', $options);
        if($message['Sugestao']['read'] == 'N')
        {
            $data['Sugestao']['id'] = $id;
            $data['Sugestao']['read'] = 'Y';
            $data['Sugestao']['readfor'] = $this->Session->read('Auth.User.id');
            $this->Sugestao->save($data);
            $message = $this->Sugestao->find('first', $options);   
        }
        $this->set('msg', $message);
        $this->set('title_for_layout', 'Visualizar mensagem recebida');   
     }
     
 */
   

    
    /**
     * Método que abre a mensagem enviada pelo "Trabalhe conosco"
     */
   /*  public function admin_openCv($id= null)
     {
        if(!$this->Rh->exists($id)) 
        {
            throw new NotFoundException(__($this->Mensagens->registroInvalido));
        }
       
        $options = array('conditions' => array('Rh.' . $this->Rh->primaryKey => $id));
        $message = $this->Rh->find('first', $options);
      
        if($message['Rh']['read'] == 'N')
        {
                $data['Rh']['id'] = $id;
                $data['Rh']['read'] = 'Y';
                $data['Rh']['readfor'] = $this->Session->read('Auth.User.id');
                $this->Rh->save($data);
                $message = $this->Rh->find('first', $options);
        }
        $this->set('msg', $message);
        $this->set('title_for_layout', 'Visualizar e-mail recebido');  
     }*/
     
    /**
     * Método que abre uma mensagem selecionada
     */
     public function admin_openMessage($id=null)
     {
        if(!$this->Contato->exists($id)) 
        {
            throw new NotFoundException(__($this->Mensagens->registroInvalido));
        }
        $options = array('conditions' => array('Contato.' . $this->Contato->primaryKey => $id));
        $message = $this->Contato->find('first', $options);
        if($message['Contato']['read'] == 'N')
        {
            $data['Contato']['id'] = $id;
            $data['Contato']['read'] = 'Y';
            $data['Contato']['readfor'] = $this->Session->read('Auth.User.id');
            $this->Contato->save($data);
            $message = $this->Contato->find('first', $options);   
        }
        $this->set('msg', $message);
        $this->set('title_for_layout', 'Visualizar mensagem recebida');   
     }
     
     
     
     
     
     
     
     
     
   
}