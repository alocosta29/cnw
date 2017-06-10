<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('ManagerBookAppController', 'ManagerBook.Controller');
class ManagerBooksController extends ManagerBookAppController{
    public $uses = array('Articles.Categoria', 'Articles.Artigo', 'ConfigBook.Caderno');
    public $components = array('Articles.ValidEdit', 'Articles.ReportArticle');    
    
    /**
            * lista os cadernos administráveis do usuário 
            */
    public function admin_index($caderno = null)
    {
        $this->ReportArticle->start($caderno, 'admin');
        $this->set('report', $this->ReportArticle->report);
        $this->set('caderno', $caderno);
    }
                
    /**
     * Método que retorna o id do caderno
     */
    private function getCadernoId($caderno = null)
    {
        $find = $this->Caderno->find('first', 
                                        array(
                                            'conditions'=>array(
                                                                    'Caderno.alias'=>$caderno,
                                                                    'Caderno.isdeleted'=>'N'
                                                                )));
        if(!empty($find))
        {
            return $find['Caderno']['id'];
        }else{
            return false;
        }
    }  
    
 ##############################  ADMINISTRAÇÃO DE CATEGORIAS ###########################################     
    
    /**
     * Método que lista a categoria
     */
    public function admin_listCategorie($caderno = null)
    {
        $caderno_id = $this->getCadernoId($caderno);
        $options = array(
			'conditions' => array('Categoria.isdeleted' => 'N', 'Categoria.caderno_id'=>$caderno_id),
			'order' => array('Categoria.id' => 'DESC'),
			'limit' => 20
		);
		$this->paginate = $options;
		$Categorias = $this->paginate('Categoria');
		$this->set('Categorias', $Categorias);
        $this->set('caderno', $caderno);
    }
        
    /**
     * Cadastra categoria de assunto de caderno
     */
    public function admin_addCategorie($caderno = null){
    
      if($this->request->is('post')){
			$data = $this->request->data;
            $data['Categoria']['caderno_id'] = $this->getCadernoId($caderno);
			$this->Categoria->create();
			if($this->Categoria->save($data))
            {			
				$this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'listCategorie', $caderno));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
			}
		}
        $this->set('caderno', $caderno);
    }
   
    /**
     * Edita categoria de assunto de caderno
     * @param type $id
     */
    public function admin_editCategorie($caderno = null, $id = null)
    {
        if(!$this->Categoria->exists($id)) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		if($this->request->is('post') || $this->request->is('put')) 
        {
			$data = $this->request->data;
			$data['Categoria']['id'] = $id;
			if($this->Categoria->save($data)) 
			{
				$this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'listCategorie', $caderno));
			}else{
				$this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
			}
		}else{
			$options = array('conditions' => array('Categoria.' . $this->Categoria->primaryKey => $id));
			$this->request->data = $this->Categoria->find('first', $options);
		} 
        $this->set('caderno', $caderno); 
    }
       
    /**
     * Apaga categoria de assunto de caderno
     * @param type $id
     */
    public function admin_deleteCategorie($caderno = null, $id = null)
    {
        $this->Categoria->id = $id;
		if (!$this->Categoria->exists()) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}
		$CategoriaParaDeletar['Categoria']['id']= $id;
		$CategoriaParaDeletar['Categoria']['isdeleted']='Y';
		$CategoriaParaDeletar['Categoria']['isactive']='N';
              
		if($this->Categoria->save($CategoriaParaDeletar))
		{
			$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'listCategorie', $caderno));
		}else{
			$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'listCategorie', $caderno));
		} 
    }
  
     /**
     * Autoriza colunista 
     */
    #public function admin_authorizeUser($caderno = null){}
    /**
     * Nega acesso ao usuário
     */
    #public function admin_denyUser($caderno = null){}
   /* public function admin_authorizeUser($caderno = null, $id = null)
    {   
    }*/

##############################  ADMINISTRAÇÃO DE POSTS ###########################################    
      /**
     * Método que lista os artigos EM ANÁLISE
     * @param type $caderno
     */
    public function admin_pendingPosts($caderno = null)
    {
        $caderno_id = $this->getCadernoId($caderno);
        $options = array(
                            'conditions' => array(
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.status' => 'A',
                                                    'Artigo.caderno_id' => $caderno_id
                                                   ),
                            'order' => array('Artigo.id' => 'ASC'),
                            'limit' => 20
                        );
		$this->paginate = $options;
		$lists = $this->paginate('Artigo');
		$this->set('lists', $lists);
        $this->set('caderno', $caderno);
    }  
            
   /**
    * Lista os artigos REPROVADOS
    */ 
    public function admin_reprovedPosts($caderno = null)
    {
        $caderno_id = $this->getCadernoId($caderno);
        $options = array(
                            'conditions' => array(
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.status' => 'N',
                                                    'Artigo.caderno_id' => $caderno_id,
                                                    'Artigo.reprovedby'=>$this->Session->read('Auth.User.id')
                                                   ),
                            'order' => array('Artigo.id' => 'ASC'),
                            'limit' => 20
                        );
		$this->paginate = $options;
		$lists = $this->paginate('Artigo');
		$this->set('lists', $lists);
        $this->set('caderno', $caderno);
    }
    
   /**
    * Lista os artigos PUBLICADOS
    */ 
    public function admin_listPublish($caderno = null)
    {
        $caderno_id = $this->getCadernoId($caderno);
        $options = array(
                            'conditions' => array(
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.status' => 'P',
                                                    'Artigo.caderno_id' => $caderno_id,
                                                    'Artigo.authorizedby'=>$this->Session->read('Auth.User.id')
                                                   ),
                            'order' => array('Artigo.id' => 'ASC'),
                            'limit' => 20
                        );
		$this->paginate = $options;
		$lists = $this->paginate('Artigo');
		$this->set('lists', $lists);
        $this->set('caderno', $caderno);
    }
    
      /**
     * Método que visualiza o conteúdo do post
     * @param type $caderno
     * @param type $id
     */
    public function admin_viewPost($caderno = null, $id = null)
    {
        if($this->ValidEdit->start($id, 'view'))
        {
             $this->set('dataArticle', $this->ValidEdit->artigoData);
             $this->set('categories', $this->ValidEdit->nameCategories);
              $this->set('listFiles', $this->ValidEdit->attachedFiles);
             $this->set('id', $id);
             $this->set('caderno', $caderno);
        }else{
            $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'pendingPosts', $caderno));
        }
    }  
    
    /**
     * Autorizar publicação
     * @param type $caderno
     * @param type $id
     */
    public function admin_authorizePosts($caderno = null, $id = null)
    {   
        $this->request->onlyAllow('post');
       # pr($id); exit(0);
        if($this->ValidEdit->start($id, 'publish', 'P'))
        {
            $idAuthor = $this->ValidEdit->artigoData['user_id'];
            $title = $this->ValidEdit->artigoData['titulo'];
   
            $datasource = $this->Artigo->getDataSource();
            try{
                    $datasource->begin();
                    $this->Artigo->Behaviors->disable('Locale');
                    $data['Artigo']['id'] = $id;
                    $data['Artigo']['status'] = 'P';
                    $data['Artigo']['authorizedby'] = $this->Session->read('Auth.User.id');
                    $data['Artigo']['date_authorization'] = date('Y-m-d H:i:s');
                    if(!$this->Artigo->save($data)){
                    throw new Exception(); }

                    $datasource->commit();
                    $this->Notify->send($idAuthor, 'O artigo '.$title.' foi aprovado!');
                    $this->Session->setFlash(__('O artigo foi publicado com sucesso!!'), 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'listPublish', $caderno));
                }catch(Exception $e){
                    $datasource->rollback();
                    $this->Session->setFlash(__('O artigo não pode ser publicado. Por favor tente novamente'), 'default', array());
                    $this->redirect(array('action' => 'pendingPosts', $caderno));
                }
        }else{
            $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'pendingPosts', $caderno));
        }
         $this->set('caderno', $caderno);
    }
    
    
    /**
     * Posts autorizados
     * @param type $caderno
     * @param type $id
     */
    public function admin_authorizedPosts($caderno = null, $id = null)
    {   
        $caderno_id = $this->getCadernoId($caderno);
        $options = array(
                            'conditions' => array(
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.status' => 'P',
                                                    'Artigo.caderno_id' => $caderno_id,
                                                    'Artigo.authorizedby'=>$this->Session->read('Auth.User.id')
                                                   ),
                            'order' => array('Artigo.id' => 'ASC'),
                            'limit' => 20
                        );
		$this->paginate = $options;
		$lists = $this->paginate('Artigo');
		$this->set('lists', $lists);
                $this->set('caderno', $caderno);
     }

    
    /**
     * Método que reprova postagens
     * @param type $caderno
     * @param type $id
     */
    public function admin_reprovePosts($caderno = null, $id = null)
    {
        if($this->ValidEdit->start($id, 'reprove', 'N'))
        {
            if($this->request->is('post') and !empty($this->request->data['Artigo']['comments']))
            {
                $idAuthor = $this->ValidEdit->artigoData['user_id'];
                $title = $this->ValidEdit->artigoData['titulo'];
                
                $datasource = $this->Artigo->getDataSource();
                try{
                        $datasource->begin();
                        $this->Artigo->Behaviors->disable('Locale');
                        if(!$this->Artigo->updateAll(array(
                                                                'Artigo.status' =>  "'N'",
                                                                'Artigo.comments'=> "'".$this->request->data['Artigo']['comments']."'",
                                                                'Artigo.reprovedby' =>  $this->Session->read('Auth.User.id'),
                                                                'Artigo.reprobation_date' =>  "'".date('Y-m-d H:i:s')."'"
                                                             ), array('Artigo.id' => $id)))
                        {
                            throw new Exception(); 
            
                        }
                        $datasource->commit();
                        $this->Notify->send($idAuthor, 'O artigo '.$title.' foi avaliado! O moderador solicitou a revisão do mesmo!');
                        $this->Session->setFlash(__('O artigo foi reprovado com sucesso!!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'reprovedPosts', $caderno));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__('O artigo não pode ser reprovado. Por favor tente novamente'), 'default', array());
                        $this->redirect(array('action' => 'pendingPosts', $caderno));
                    }
            }
            $this->set('dataArticle', $this->ValidEdit->artigoData);
             $this->set('caderno', $caderno);
        }else{
            $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'pendingPosts', $caderno));
        }
    } 

    /**
          * Método que reprova postagens
           * @param type $caderno
           * @param type $id
           */
    public function admin_reverseApprovalPosts($caderno = null, $id = null)
    {
        if($this->ValidEdit->start($id, 'reverseApproval', 'N'))
        {
            if($this->request->is('post') and !empty($this->request->data['Artigo']['comments']))
            {
                $idAuthor = $this->ValidEdit->artigoData['user_id'];
                $title = $this->ValidEdit->artigoData['titulo'];
                
                $datasource = $this->Artigo->getDataSource();
                try{
                        $datasource->begin();
                        $this->Artigo->Behaviors->disable('Locale');
                        $data['Artigo']['id'] = $id;
                        $data['Artigo']['status'] = 'N';
                        $data['Artigo']['comments'] = $this->request->data['Artigo']['comments'];
                        $data['Artigo']['reprovedby'] = $this->Session->read('Auth.User.id');
                        $data['Artigo']['reprobation_date'] = date('Y-m-d H:i:s');
                        if(!$this->Artigo->save($data)){
                        throw new Exception(); }

                        $datasource->commit();
                        $this->Notify->send($idAuthor, 'O status de aprovado do artigo '.$title.' foi reavaliado! O moderador solicitou a revisão do mesmo!');
                        $this->Session->setFlash(__('O status de aprovado do artigo '.$title.' foi reavaliado com sucesso!!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'reprovedPosts', $caderno));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__('O status do artigo '.$title.' não pode ser revertido. Por favor, tente novamente!'), 'default', array());
                        //$this->redirect(array('action' => 'pendingPosts', $caderno));
                    }
            }
            $this->set('dataArticle', $this->ValidEdit->artigoData);
             $this->set('caderno', $caderno);
        }else{
            $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'pendingPosts', $caderno));
        }
    }     

}