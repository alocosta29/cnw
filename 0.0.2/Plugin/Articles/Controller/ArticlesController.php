<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('error_reporting', E_ALL);
App::uses('ArticlesAppController', 'Articles.Controller');
class ArticlesController extends ArticlesAppController{
    public $uses = array('Articles.Categoria', 'Articles.Artigo', 'Articles.ArtigosCategoria', 'ConfigBook.Caderno', 'Articles.Extra');
    public $components = array('Articles.TreatSaveArticle', 'Articles.ValidEdit', 'UploadFile', 'Articles.ReportArticle', 'Content', 'Articles.ArticleStats');
    
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        
        if($this->Session->read('Auth.User.id')){
            $this->Auth->allow('admin_getManual', 'admin_getExtraFile');   
        }
    }
    
    /**
     * Método que é a página inicial dos colunistas
     */
    public function admin_index($caderno = null)
    {
        $this->ReportArticle->start($caderno, 'col');       
        $this->set('report', $this->ReportArticle->report);
        $this->set('caderno', $caderno);
    }
        
    public function admin_view($caderno = null, $id = null) 
    {
        if($this->ValidEdit->start($id, 'view_col'))
        {
             $this->set('dataArticle', $this->ValidEdit->artigoData);
             $this->set('categories', $this->ValidEdit->nameCategories);
             $this->set('listFiles', $this->ValidEdit->attachedFiles);
             $this->set('id', $id);
             $idArtigo = $id;
             $ValidEdit = $this->ValidEdit;
             $this->set(compact('caderno', 'idArtigo', 'ValidEdit'));
        }else{
            $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'listPosts', $caderno));
        }
    }  
    
    
    public function admin_previewPost($caderno = null, $id = null) 
    {
        if($this->Content->startContent('ver_preview', $id))
          {
              $data = $this->Content->dataContent;     
              $selectColor = $data['caderno']['cor'];
              $artigo = $data['artigo'];
              $caderno = $data['caderno'];
              $title_for_layout = $data['artigo']['titulo'];
              $listCategories = $data['list_categorias'];
              $avatar = $data['avatar'];
              $colunista = $data['colunista'];
              $categorias = $data['categorias'];
              $this->set(compact('selectColor', 'artigo', 'caderno', 'title_for_layout', 'listCategories', 'categorias', 'avatar', 'colunista'));
          }else{
            $this->Session->setFlash(__('Artigo não localizado'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'listPosts', $caderno));
          }    
    }  
    
    public function admin_getManual()
    {    
        $this->viewClass = 'Media';
        // Download app/outside_webroot_dir/example.zip
        $params = array(
            'id'        => 'manual.pdf',
            'name'      => 'manual',
            'download'  => true,
            'extension' => 'pdf',
          //  'path'      => APP . 'articles' . DS
             'path'      => WWW_ROOT.'files'.DS.'manual'.DS
        );
        $this->set($params);
    }
    
    
    
    public function admin_deleteExtra($caderno = null, $id = null) 
	{
                $this->Extra->recursive = -1;
		$find = $this->Extra->find('first', array('conditions'=>array('Extra.id'=>$id, 'Extra.isdeleted'=>'N')));
		if (!empty($find)) 
		{
			$ModelParaDeletar['Extra']['id']= $id;
                        $ModelParaDeletar['Extra']['isdeleted']='Y';
                        if($this->Extra->save($ModelParaDeletar))
                        {
                                $this->Session->setFlash(__('Arquivo deletado com sucesso!'), 'default', array('class' => 'success'));
                                $this->redirect(array('action' => 'view', $caderno, $find['Extra']['artigo_id']));
                        }else{
                                $this->Session->setFlash(__('O arquivo não pode ser deletado. Por favor, tente novamente!'), 'default', array('class' => 'error'));
                                $this->redirect(array('action' => 'view', $caderno, $find['Extra']['artigo_id']));
                        }  
		}else{
                        $this->Session->setFlash(__('Arquivo não localizado!'), 'default', array('class' => 'error'));
			$this->redirect($this->referer());
                }
		
	}
    
    
    public function admin_getExtraFile($id = null, $extension = null)
    {    
       if(!empty($id) and !empty($extension)){
            $this->viewClass = 'Media';
            $name = 'arquivo_'.date('Ymd_His');
            // Download app/outside_webroot_dir/example.zip
            $params = array(
                'id'        => $id,
                'name'      => $name,
                'download'  => true,
                'extension' => $extension,
              //  'path'      => APP . 'articles' . DS
                 'path'      => WWW_ROOT.'files'.DS.'extras'.DS
            );
           // pr($params); exit();
            
            $this->set($params);
       }else{
           $this->Session->setFlash(__('Parâmetros incompletos'), 'default', array('class' => 'error'));
           $this->redirect($this->referer());
           
       } 
        
    }
    
    
    /**
     * Método que faz a edição do resumo do artigo
     * O resumo deve conter, no máximo, 160 caracteres
     */
    public function admin_editResumo($caderno = null, $id = null)
    {
        if($this->ValidEdit->start($id, 'summary'))
        {
                 $dataArticle = $this->ValidEdit->artigoData;
                 if($this->request->is('post') || $this->request->is('put')) 
                 {
                     $data = $this->request->data['Artigo']['resumo'];
                     $datasource = $this->Artigo->getDataSource();
                    try{
                        $datasource->begin();

                        $this->Artigo->id = $id;
                        if(!$this->Artigo->saveField('resumo', $data)){
                            throw new Exception();			
                        }

                        $datasource->commit();
                        $this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'view', $caderno, $id));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
                    }
                 }else{
                  $options = array('conditions' => array('Artigo.' . $this->Artigo->primaryKey => $id));
                  $this->request->data = $this->Artigo->find('first', $options);
                }
         
                $idArtigo = $id;
                $ValidEdit = $this->ValidEdit;
                $this->set(compact('caderno', 'idArtigo', 'ValidEdit'));
        }else{
             $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
             $this->redirect(array('action' => 'listPosts', $caderno));
        }
    }
    
    
    /**
     * Método que faz a edição do resumo do artigo
     * O resumo deve conter, no máximo, 160 caracteres
     */
    public function admin_editKeyWords($caderno = null, $id = null)
    {
        if($this->ValidEdit->start($id, 'editKeyWords'))
        {
                 $dataArticle = $this->ValidEdit->artigoData;
                 if($this->request->is('post') || $this->request->is('put')) 
                 {
                     $data = str_replace(";", ",", $this->request->data['Artigo']['keywords']);
                    
                     $this->Artigo->Behaviors->disable('Locale');
                     $datasource = $this->Artigo->getDataSource();
                    try{
                        $datasource->begin();

                        $this->Artigo->id = $id;
                        if(!$this->Artigo->saveField('keywords', $data)){
                            throw new Exception();			
                        }

                        $datasource->commit();
                        $this->Session->setFlash(__($this->Mensagens->sucessoEdit), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'view', $caderno, $id));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__($this->Mensagens->falhaEdit), 'default', array('class' => 'error'));
                    }
                 }else{
                  $options = array('conditions' => array('Artigo.' . $this->Artigo->primaryKey => $id));
                  $this->request->data = $this->Artigo->find('first', $options);
                }
         
                $idArtigo = $id;
                $ValidEdit = $this->ValidEdit;
                $this->set(compact('caderno', 'idArtigo', 'ValidEdit'));
        }else{
             $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
             $this->redirect(array('action' => 'listPosts', $caderno));
        }
    }
    
    
    
    /**
           * Método responsável por criar postagens
           * @name criar post
           * @param type $caderno
           */
    public function admin_add($caderno = null)
    {
      //  pr($this->Artigo); exit();
        if($this->request->is('post'))
        {            
            $data = $this->request->data;
            if($this->TreatSaveArticle->start($data, $caderno))
            {
                $save = $this->TreatSaveArticle->save;    
                
                //$this->Artigo->Behaviors->unload('Locale');
                $this->Artigo->Behaviors->disable('Locale');
                $this->Artigo->unbindModel(
                                                array(
                                                    'hasMany' => array('Countview', 'ArticlesCategorie'),
                                                    'belongsTo' => array('Caderno')
                                                    )
                                            );
               // pr($this->Artigo); exit(); 
                $saveA['Artigo'] =$save['Artigo'];
                
                $datasource = $this->Artigo->getDataSource();
                try{
                        $datasource->begin();
                        if(!$this->Artigo->save($save)){
                                throw new Exception();				
                        }
                        
                        if(!empty($save['ArtigosCategoria']))
                        {
                            $id = $this->Artigo->id;
                            $i=0;
                            $totalSize = sizeof($save['ArtigosCategoria']);
                            while($i<$totalSize){
                                $save['ArtigosCategoria'][$i]['artigo_id'] = $id;

                               $i++;
                            }   
                            if(!$this->ArtigosCategoria->saveMany($save['ArtigosCategoria'])){
                                   throw new Exception();				
                            }
                        }
                        
                        $datasource->commit();
                        $this->Session->setFlash(__('Artigo gravado com sucesso!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'listPosts', $caderno));
                }catch(Exception $e){
                        $datasource->rollback();
                       // print_r(error_get_last());
                        //echo 'Exceção capturada: ', var_dump($e->getMessage()), "\n"; exit();
                        $this->Session->setFlash(__('O artigo não pode ser gravado! Por favor, tente novamente!'), 'default', array('class' => 'error'));
                }
            }else{
                $this->request->data = $data;
                $this->Session->setFlash(__($this->TreatSaveArticle->errors), 'default', array());
            }
		}
        $options = array(
                            'joins' => array(
                                            array(
                                                'table' => 'cw_cadernos',
                                                'alias' => 'CadernoJoin',
                                                'type' => 'LEFT',
                                                'conditions' => array(
                                                                       'CadernoJoin.id = Categoria.caderno_id'
                                                                     )
                                                 )
                            ),
                            'fields'=>array('Categoria.id', 'Categoria.nome'),
                            'conditions'=>array(
                                                'CadernoJoin.alias'=>$caderno,
                                                'CadernoJoin.isdeleted'=>'N',
                                                'Categoria.isactive'=>'Y',
                                                'Categoria.isdeleted'=>'N',
                                                ),
                            'order'=>array('Categoria.nome'=>'ASC')
        );        
        $listCategories['Categorias'] = $this->Categoria->find('list', $options);  
        $this->set('listCategories', $listCategories);
        $this->set('caderno', $caderno);   
    }
    
    /**
     * Método responsável por editar postagens
     * @param type $caderno
     * @name editar post
     */
     public function admin_edit($caderno = null, $id = null)
     {
        if($this->ValidEdit->start($id, 'edit'))
        {
                $dataCaderno = $this->ValidEdit->artigoData;
                if($this->request->is('post') || $this->request->is('put'))
                {
                         $data = $this->request->data;
                         if($this->TreatSaveArticle->start($data, $caderno))
                         {
                             $save = $this->TreatSaveArticle->save;     
                             $this->Artigo->Behaviors->disable('Locale');
                             $save['Artigo']['id'] = $id;
                             $datasource = $this->Artigo->getDataSource();
                             try{
                                     $datasource->begin();
                                     if(!$this->ArtigosCategoria->deleteAll(array('ArtigosCategoria.artigo_id' => $id), false)){
                                             throw new Exception();				
                                     }
                                     if(!$this->Artigo->saveAll($save)){
                                             throw new Exception();				
                                     }
                                     if(!empty($save['ArtigosCategoria']))
                                     {
                                         $id = $this->Artigo->id;
                                         $i=0;
                                         $totalSize = sizeof($save['ArtigosCategoria']);
                                         while($i<$totalSize){
                                            $save['ArtigosCategoria'][$i]['artigo_id'] = $id;
                                            $i++;
                                         }   
                                         if(!$this->ArtigosCategoria->saveMany($save['ArtigosCategoria'])){
                                                throw new Exception();				
                                         }
                                     }
                                     $datasource->commit();
                                     $this->Session->setFlash(__('Artigo atualizado com sucesso!'), 'default', array('class' => 'success'));
                                     $this->redirect(array('action' => 'edit', $caderno, $id));
                                }catch(Exception $e){
                                     $datasource->rollback();
                                     $this->Session->setFlash(__('O artigo não pode ser atualizado! Por favor, tente novamente!'), 'default', array('class' => 'error'));
                                }
                         }else{
                             $this->Session->setFlash(__($this->TreatSaveArticle->errors), 'default', array());
                         }
                 }else{
                         $this->request->data['Artigo'] = $dataCaderno;
                 }   
        }else{
             $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
             $this->redirect(array('action' => 'listPosts', $caderno));
        }
         $options = array(
            'joins' => array(
                            array(
                                'table' => 'cw_cadernos',
                                'alias' => 'CadernoJoin',
                                'type' => 'LEFT',
                                'conditions' => array(
                                        'CadernoJoin.id = Categoria.caderno_id'
                                                      )
                            )
            ),
            'fields'=>array('Categoria.id', 'Categoria.nome'),
            'conditions'=>array(
                                'CadernoJoin.alias'=>$caderno,
                                'CadernoJoin.isdeleted'=>'N',
                                'Categoria.isactive'=>'Y',
                                'Categoria.isdeleted'=>'N',
                                ),
            'order'=>array('Categoria.nome'=>'ASC')
        );        
        $listCategories['Categorias'] = $this->Categoria->find('list', $options);  
        $this->set('listCategories', $listCategories);
        $this->set('postCategories', $this->ValidEdit->postCategories);
          $idArtigo = $id;
         $ValidEdit = $this->ValidEdit;
         $this->set(compact('caderno', 'idArtigo', 'ValidEdit'));
    
        $this->set('post', $dataCaderno); 
     }     
        
    /**
     * Lista todos os artigos em rascunho, escritos pelo colaborador
     */    
    public function admin_listPosts($caderno = null)
    {
        $caderno_id = $this->getCadernoId($caderno);
            $options = array(
                            'conditions' => array(
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.caderno_id' => $caderno_id,
                                                    'Artigo.user_id'=>$this->Session->read('Auth.User.id'),
                                                    'Artigo.isdeleted'=>'N',
                                                    'Artigo.status'=>array('R', 'P', 'N', 'A'),
                                                  ),
                            'order' => array('Artigo.id' => 'DESC'),
                         
                            );
            
            $Artigos = $this->Artigo->find('all', $options);
            $this->set('Artigos', $Artigos);   
              
         $ValidEdit = $this->ValidEdit;
         $this->set(compact('caderno', 'ValidEdit'));  
    }

    
    
    
    /**
     * Lista todos os artigos em rascunho, escritos pelo colaborador
     */    
    public function admin_publishPosts($caderno = null)
    {
        $caderno_id = $this->getCadernoId($caderno);
            $options = array(
                            'conditions' => array(
                                                    'Artigo.isdeleted' => 'N',
                                                    'Artigo.caderno_id' => $caderno_id,
                                                    'Artigo.user_id'=>$this->Session->read('Auth.User.id'),
                                                    'Artigo.isdeleted'=>'N',
                                                    'Artigo.status'=>'P',
                                
                                                    'Artigo.data_publicacao <= '=> date('Y-m-d H:i')
                                
                                                  ),
                            'order' => array('Artigo.id' => 'DESC'),
                            'limit' => 20
                            );
            $this->paginate = $options;
            $Artigos = $this->paginate('Artigo');
            //$this->ArticleStats->start(22);
            $ArticleStats = $this->ArticleStats;
            $this->set('Artigos', $Artigos);   
            $ValidEdit = $this->ValidEdit;
            $this->set(compact('caderno', 'ValidEdit', 'ArticleStats'));  
    } 
    
    
    
    /**
     * Método que altera o status do artigo
     * @param type $caderno
     * @param type $id
     * @param type $status
     */    
    public function admin_changeStatus($caderno = null, $id = null, $status = null)
    {
            $typeChange = array('A'=>'send_analysis', 'R'=>'return_draft');
        
            if($this->ValidEdit->start($id, $typeChange[$status], $status))
            {
                $this->Artigo->Behaviors->disable('Locale');
                $datasource = $this->Artigo->getDataSource();
                try{
                        $datasource->begin();
                        
                        $this->Artigo->id = $id;
                        if(!$this->Artigo->saveField('status', $status)){
                        throw new Exception(); }

                        $datasource->commit();
                        $this->Session->setFlash(__('O status do registro foi alterado com sucesso!!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'listPosts', $caderno));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__('O status do registro não pode ser alterado. Por favor tente novamente'), 'default', array());
                        $this->redirect(array('action' => 'listPosts', $caderno));
                    }
            }else{
                $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
                $this->redirect(array('action' => 'listPosts', $caderno));
           }
    }

    
    /**
     * Método que configura imagem do artigo
     */
    public function admin_featuredImage($caderno = null, $id = null){
         if($this->ValidEdit->start($id, 'featuredImage'))
         {
             $dataCaderno = $this->ValidEdit->artigoData;
             $oldImage = null;
             $folder = $dataCaderno['user_id'].DS;
             if(!empty($dataCaderno['imagem'])){
                 $oldImage = $dataCaderno['imagem'];
             }     
            // pr($dataCaderno); exit(0);
             if($this->request->is('post') || $this->request->is('put'))
             {
                $fileSelect = $this->request->data['Artigo']['imagem']; 
                if($this->UploadFile->start($fileSelect, 'featuredImage', array('folder'=>$folder, 'name'=>$dataCaderno['numero_artigo'], 'oldFile'=>$oldImage)))
                {
                     $datasource = $this->Artigo->getDataSource();
                    try{
                        $datasource->begin();

                        $this->Artigo->id = $id;
                        if(!$this->Artigo->saveField('imagem', $this->UploadFile->nameFile)){
                        throw new Exception(); }

                        $datasource->commit();
                        $this->Session->setFlash(__('Imagem atualizada com sucesso!'), 'default', array('class' => 'success'));
                      //  $this->redirect(array('action'=>'profileCandidate', $id)); 
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__('A iamgem não pode ser atualizada! Por favor, tente novamente!'), 'default', array('class' => 'error'));
                    }      
                }else{
                     $this->Session->setFlash(__($this->UploadFile->errors), 'default', array('class' => 'error'));
                }
             }
            // pr($dataCaderno); exit();
             $this->set('dataCaderno', $dataCaderno);
             
         }else{
               $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
               $this->redirect(array('action' => 'listPosts', $caderno));
         }
         $idArtigo = $id;
         $ValidEdit = $this->ValidEdit;
         $this->set(compact('caderno', 'idArtigo', 'ValidEdit'));

        
    }
    
    /**
     * Método que apaga o artigo
     * @param type $caderno
     * @param type $id
     */
    public function admin_delete($caderno = null, $id = null)
    {
            if($this->ValidEdit->start($id, 'delete'))
            {
                $ModelParaAtivar['Artigo']['isdeleted']='Y';
                $ModelParaAtivar['Artigo']['id'] = $id;
                if($this->Artigo->saveAll($ModelParaAtivar))
                {
                    $this->Session->setFlash(__('Artigo apagado com sucesso!!'), 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'listPosts', $caderno));
                }else{
                    $this->Session->setFlash(__('O artigo não pode ser deletado. Por favor tente novamente'), 'default', array());
                    $this->redirect(array('action' => 'listPosts', $caderno));
                }
            }else{
                $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
                $this->redirect(array('action' => 'listPosts', $caderno));
           }
    }
    
      /**
     * Método que cria nova versão para o post reprovado
     */
    public function admin_createNewVersion($caderno = null, $id = null)
    {
        if($this->ValidEdit->start($id, 'new_version', 'R'))
        {
            $save = $this->ValidEdit->newVersionData;
                     
            
            if(isset($save['Artigo']['categorias'])){
              unset($save['Artigo']['categorias']);  
            }          
            $datasource = $this->Artigo->getDataSource();
            try{
                    $datasource->begin();
                    $this->Artigo->Behaviors->disable('Locale');
                    $conditions['Artigo.user_id'] = $save['Artigo']['user_id'];
                    $conditions['Artigo.numero_artigo'] = $save['Artigo']['numero_artigo'];
                    
                    if(!$this->Artigo->updateAll(
                            array('Artigo.isdeleted' => "'Y'"),
                            array($conditions)
                    )){
                            throw new Exception();	           
                    }
                    $saveA['Artigo'] = $save['Artigo'];
                    $this->Artigo->create();
                    if(!$this->Artigo->save($saveA, array('validate'=>false))){
                            throw new Exception();				
                    }
                    $idNew = $this->Artigo->id;
                    
                   if(!$this->Extra->updateAll(
                            array('Extra.artigo_id' => $idNew),
                            array('Extra.artigo_id' => $id)
                   )){
                       throw new Exception();
                   }
                                        
                    if(!empty($save['ArtigosCategoria']))
                    {
                        
                        $i=0;
                        $totalSize = sizeof($save['ArtigosCategoria']);
                        while($i<$totalSize){
                            $saveC[$i]['ArtigosCategoria']['artigo_id'] = $idNew;
                            $saveC[$i]['ArtigosCategoria']['categoria_id'] = $save['ArtigosCategoria'][$i]['categoria_id'];
                           $i++;
                        }
                        if(!$this->ArtigosCategoria->saveAll($saveC)){
                               throw new Exception();				
                        }
                    }
                    
                    $datasource->commit();
                    $this->Session->setFlash(__('Novo artigo criado com sucesso!'), 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'listPosts', $caderno));
            }catch(Exception $e){
                    $datasource->rollback();
                    $this->Session->setFlash(__('O artigo não pode ser criado! Por favor, tente novamente!'), 'default', array('class' => 'error'));
            }
        }else{
            $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'listPosts', $caderno));
        }
    }
    
    
    /**
          *  Método que edita a data de publicação
          */
    public function admin_editPublicationDate($caderno = null, $id = null)
    {
        if($this->ValidEdit->start($id, 'editDate'))
        {
            $dataArtigo = $this->ValidEdit->artigoData;
            if($this->request->is('post') || $this->request->is('put'))
            {
                $save = $this->request->data;
                $datasource = $this->Artigo->getDataSource();
                try{
                        $datasource->begin();
                        $this->Artigo->Behaviors->disable('Locale');
                        $this->Artigo->id = $id;
                        if(!$this->Artigo->saveField('data_publicacao', $save['Artigo']['data_publicacao'])){
                           throw new Exception();
                        }	
                        
                        $datasource->commit();
                        $this->Session->setFlash(__('Data de publicação alterada com sucesso!'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'view', $caderno, $id));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->request->data = $save;
                        $this->Session->setFlash(__('Não foi possível alterar a data de publicação! Por favor, tente novamente!'), 'default', array('class' => 'error'));
                    }
            }else{
                $this->request->data['Artigo'] = $dataArtigo;
            }
            $this->set('dataArtigo', $dataArtigo);
            $this->set('caderno', $caderno);
        }else{
            $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'listPosts', $caderno));
        }
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
    
    
    public function admin_addExtra($caderno = null, $id = null)
    {
       #pr($this->Session->read('Auth.User.id')); exit(); 
        if($this->ValidEdit->start($id, 'addExtra'))
        {
                 $dataArticle = $this->ValidEdit->artigoData;
                 if($this->request->is('post') || $this->request->is('put')) 
                 {
                        $data = $this->request->data;
                        $fileSelect = $this->request->data['Extra']['arquivo']; 
                        $folder = 'extras'.DS;
                        $name = $this->Session->read('Auth.User.id').date('_Ymd_His');
                                               
                        
                        if($this->UploadFile->start($fileSelect, 'extras', array('folder'=>$folder, 'name'=>$name)))
                        {         
                                    $data['Extra']['arquivo'] = $this->UploadFile->nameFile;
                                    $data['Extra']['tipo_arquivo'] = $this->UploadFile->extension;
                                    $data['Extra']['artigo_id'] = $id;
                                    $data['Extra']['caderno_id'] = $dataArticle['caderno_id'];
                                    $data['Extra']['user_id'] = $this->Session->read('Auth.User.id');
                                    $data['Extra']['person_id'] = $this->Session->read('Auth.User.person_id');

                                    $datasource = $this->Extra->getDataSource();
                                   try{
                                       $datasource->begin();

                                       if(!$this->Extra->save($data)){
                                           throw new Exception();			
                                       }

                                       $datasource->commit();
                                       $this->Session->setFlash(__('O arquivo foi anexado com sucesso ao artigo!'), 'default', array('class' => 'success'));
                                       $this->redirect(array('action' => 'view', $caderno, $id));
                                   }catch(Exception $e){
                                       $datasource->rollback();
                                       $this->Session->setFlash(__('O arquivo não pode ser anexado ao artigo. Por favor, tente novamente!'), 'default', array('class' => 'error'));
                                   }
                            }else{
                             $this->request->data['Artigo'] = $dataArticle;
                             $this->Session->setFlash(__($this->UploadFile->errors), 'default', array('class' => 'error'));
                            }
                 }else{
                  $this->request->data['Artigo'] = $dataArticle;
                }
         
                $idArtigo = $id;
                $ValidEdit = $this->ValidEdit;
                $this->set(compact('caderno', 'idArtigo', 'ValidEdit'));
        }else{
             $this->Session->setFlash(__($this->ValidEdit->errors), 'default', array('class' => 'error'));
             $this->redirect(array('action' => 'listPosts', $caderno));
        } 
    }
    
 }