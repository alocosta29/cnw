<?php
App::uses('AppController', 'Controller');
Configure::load('Recaptcha.key');
class PublicController extends AppController
{
    public $uses = array('Formularios.Contato', 'Articles.Artigo', 'Articles.Extra', 'Articles.ArtigosCategoria', 'Formularios.Cadastro', 
        'ConfigBook.Caderno', 'Formularios.CadastrosCaderno', 'Formularios.Term', 'Formularios.StatusTerm', 'Manager.Person' );
   // public $components = array('SendMail', 'Formularios.FileManager', 'Content', 'Recaptcha.Recaptcha', 'CheckCount');
    public $components = array('SendMail', 'Formularios.FileManager', 'Content', 'Recaptcha.Recaptcha', 'CheckCount', 'Crypt', 'SelectAd');
    public $helpers = array('Recaptcha.Recaptcha');
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        $allow = array('empresa', 'sugestoes', 'contato', 'colunista', 'artigos', 'artigo', 'download', 'naolocalizado', 'caderno', 'categoria', 'searchPosts', 'activate', 'getFile');
        $this->Auth->allow($allow);
        if(!in_array($this->request->params['action'], $allow))
        {
            $this->redirect(array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false));
        }
    }
    
    /**
      * Método que exibe a descrição institucional da empresa
      */
    public function empresa()
    {
        if($this->Content->startContent('empresa'))
        {
             $data = $this->Content->dataContent;
             $title_for_layout = 'Crescer na Web';
             if(!empty($data['empresa'])){
               $title_for_layout = $data['empresa']['titulo'];
             }
             $this->set('cadernos', $data['cadernos']);
             $this->set('title_for_layout', $title_for_layout);
             $this->set('content', $data);
        }
    }

    public function artigos($slug = null)
    {
       if($this->Content->startContent('artigos', $slug))
       {
            $data = $this->Content->dataContent;
            
            $options = array(
                                'conditions' => array(
                                                        'Artigo.isdeleted' => 'N',
                                                        'Artigo.status' => 'P',
                                                        'Artigo.caderno_id' => $data['caderno']['id']
                                                     ),
                                'order' => array('Artigo.data_publicacao' => 'DESC'),
                                'limit' => 15
                            );
            $this->paginate = $options;
            $Artigos = $this->paginate('Artigo');
            
            $this->set('artigos', $Artigos);
            $this->set('caderno', $data['caderno']);
            $this->set('subcategorias', $data['subcategorias']);
       }else{
            $this->redirect(array('action' => 'naolocalizado'));
       }

    }
    
    public function artigo($id = null, $alias = null)
    {
          if($this->Content->startContent('ver_artigo', $id))
          {      
              $data = $this->Content->dataContent; 
              $selectColor = $data['caderno']['cor'];
              $artigo = $data['artigo'];
              $caderno = $data['caderno'];
              $this->CheckCount->start(array('action'=>'ver_artigo', 'idArtigo'=>$id, 'caderno'=>$caderno['id']));
              $title_for_layout = $data['artigo']['titulo'];
              $listCategories = $data['list_categorias'];
              $avatar = $data['avatar'];
              $colunista = $data['colunista'];
              $categorias = $data['categorias'];
              $imgDestak = 'img_destak/'.$data['artigo']['user_id'].'/'.$data['artigo']['imagem'];
              
              ########## BANNER SIDEBAR ##########
              $adOptions = array('conditions' => array(
                                                        'AdType.alias'=> 'banner-sidebar', 
                                                        'Ad.caderno_id'=> $data['artigo']['caderno_id'], 
                                                        'Ad.user_id'=>$data['artigo']['user_id']), 'limit'=>2);
              
              $data['anuncio_sidebar'] = false;
              if($this->SelectAd->start('ver_artigo', $adOptions)){
                    $data['anuncio_sidebar'] = $this->SelectAd->dataContent;
              }
              
              $this->set('anuncio_sidebar', $data['anuncio_sidebar']);
              ########## FIM DE BANNER SIDEBAR ##########
              
              $this->set('pageKeywords', $data['artigo']['keywords']);
              $this->set('imgDestak', $imgDestak);
              $this->set('extras', $data['extras']);
              $this->set('crumbTitle', $artigo['titulo']);
              $this->set('metaDesc', $data['artigo']['resumo']);
              $this->set(compact('selectColor', 'artigo', 'caderno', 'title_for_layout', 'listCategories', 'categorias', 'avatar', 'colunista'));
          }else{
             $this->redirect(array('action' => 'naolocalizado'));
          }    
     } 

    public function naolocalizado(){
       # pr('Conteúdo não localizado'); 
        #exit(0);
    }
        
    
    public function download($alias = null){
      //  $alias = $this->crypt('empreendedorismo-e-gestao', 'cnw2017', true);
        //$alias = $this->crypt($alias, 'cnw2017', true);
       // pr($alias); exit(0);
        
        $decodeAlias = $this->crypt($alias, 'cnw2017', false);
        if($this->Content->startContent('listar_pdfs', $decodeAlias))
        {  
            $data = $this->Content->dataContent;
            
            $options = array(
                'fields' => array(
                     'Extra.id','Extra.nome','Extra.descricao','Extra.arquivo','Extra.created',
                     'Extra.tipo_arquivo','Extra.artigo_id','Extra.caderno_id','Extra.user_id', 'Extra.person_id',
                     'Artigo.titulo', 'Colunista.apelido', 'Colunista.alias'
                    
                    ),
                'conditions' => array(
                                        'Extra.isdeleted'=>'N',
                                        'Extra.caderno_id'=>$data['caderno']['id']
                                    )        
                        );
            
            $this->paginate = $options;
            $find = $this->paginate('Extra');
            #pr($find); exit();
            $this->set('crumbTitle', $data['caderno']['nome']);
            $this->set('selectColor', $data['caderno']['cor']);
            $this->set('extras', $find);
            $this->set('caderno', $data['caderno']);
        }else{
            $this->redirect(array('action' => 'naolocalizado'));
        }   
    }
    

    private function crypt($string, $key, $crypt = false)
    {
        $retorno = "";
        if(!empty($string))
        {
            if($crypt)
              {
                $string = $string;
                $i = strlen($string)-1;
                $j = strlen($key);
                 do
                {
                  $retorno .= ($string{$i} ^ $key{$i % $j});
                }while ($i--);

                $retorno = strrev($retorno);
                $retorno = base64_encode($retorno);
              }
              else
              {
                $string = base64_decode($string);
                $i = strlen($string)-1;
                $j = strlen($key);
                do
                {
                  $retorno .= ($string{$i} ^ $key{$i % $j});
                }while ($i--);
                  $retorno = strrev($retorno);
              }
        } 
        return $retorno;
    }
    
    
    
    public function activate($id = null){
        $permission = false;
        $stageActivate = false;
        $msgError = false;
        $msgSuccess = false;
        $cryptId = $id;
        $id = $this->Crypt->run($id, false);
        $this->Cadastro->recursive = 0;
        $find = $this->Cadastro->find('first', array('conditions'=>array('Cadastro.id'=>$id)));
       
        if(!empty($find))
        {           
            $stageActivate = $find['Cadastro']['status'];
            $term = false;
            if($find['Cadastro']['status'] == "A"){
                $term = $this->Term->find('first', array('conditions'=>array('Term.isactive'=>"Y")));
                $term = $term['Term'];
            }
                        
            if(in_array($find['Cadastro']['status'], array('A', 'I')))
            {
                if($this->request->is('post') || $this->request->is('put') )
                {
                        $data = $this->request->data;
                        $datasource = $this->Cadastro->getDataSource();
                      try{
                          $datasource->begin();
                          if($find['Cadastro']['status'] == 'A')
                          {
                              $StatusTerm['StatusTerm']['cadastro_id'] = $find['Cadastro']['id'];
                              $StatusTerm['StatusTerm']['term_id'] = $term['id'];
                              $StatusTerm['StatusTerm']['text_term'] = $term['texto'];
                              $StatusTerm['StatusTerm']['aceite_termo'] = $data['Cadastro']['aceite_termo'];
                              if(!$this->StatusTerm->save($StatusTerm)){
                                 throw new Exception();	   
                              }
                              $save['Cadastro']['id'] = $find['Cadastro']['id'];
                              if($data['Cadastro']['aceite_termo'] == 'N')
                              {
                                    $save['Cadastro']['obs_status'] = 'Termo de utilização do portal não aceito!';  
                                    $save['Cadastro']['status'] =  'F';
                                    $msgSuccess = 'Solicitação de acesso cancelada com sucesso!';
                              }elseif($data['Cadastro']['aceite_termo'] == 'Y')
                              {
                                    $save['Cadastro']['status'] =  'I';
                                    $msgSuccess = 'Termo de aceite aceito! Por favor, preencha os dados de acesso!';
                              }   
                              if(!$this->Cadastro->save($save)){
                                      throw new Exception();	   
                              }
                          }
                          if($find['Cadastro']['status'] == 'I')
                          {
                              
                              $data['User'][0]['username'] = $find['Cadastro']['email'];
                              $data['User'][0]['pass_register'] = $data['User'][0]['password'];
                              $data['User'][0]['type_register'] = 'S';
                              $data['Person']['tipo_pessoa'] = 'F';
                          
                              if(!$this->Person->saveAll($data)) {
                                throw new Exception();   
                              }
                              
                              $save['Cadastro']['person_id'] = $this->Person->id;
                              $save['Cadastro']['id'] = $find['Cadastro']['id'];
                              $save['Cadastro']['status'] = 'F';
                              if(!$this->Cadastro->saveAll($save)) {
                                throw new Exception();   
                              }
                              
                             if(!$this->CadastrosCaderno->updateAll(
                                        array('CadastrosCaderno.status' => "'P'"),
                                        array('CadastrosCaderno.cadastro_id' => $id)
                             )){
                                 throw new Exception();  
                             }
                          }
                          $datasource->commit();
                         $this->Session->setFlash(__($msgSuccess), 'default', array('class' => 'success'));
                         $this->redirect(array('action'=>'activate', $cryptId));
                      }catch(Exception $e){
                          $datasource->rollback();
                          $this->request->data = $data;
                          $this->Session->setFlash(__( 'A operação não foi completada! Por favor, tente novamente!'), 'default', array('class' => 'error'));       
                      } 
                }
                $permission = true;
                
                $this->set('term', $term);
            }else{
                //N-> Não avaliado, A -> Aprovado, R -> reprovado, C -> Cadastro completo, E -> Expirado, F -> Finalizado
                $arrayStatus = array(
                    'N' => 'O cadastro ainda não foi avaliado. Por favor, aguarde instruções por e-mail!',
                    'R' => 'O cadastro foi reprovado.',
                    'F' => 'A criação do login de acesso já foi concluída. Aguarde instruções por e-mail!',
                );
               $msgError = $arrayStatus[$find['Cadastro']['status']];
            }    
            $this->set('dataCadastro', $find['Cadastro']);
        }else{
           $msgError = "Cadastro não localizado. Tente novamente"; 
        }
       $this->set('permission', $permission);
       $this->set('msgError', $msgError); 
       $this->set('msgSuccess', $msgSuccess); 
       $this->set('stageActivate', $stageActivate);  
    }
    
 
    public function categoria($alias = null){
          if($this->Content->startContent('ver_categoria', $alias))
          {
              $data = $this->Content->dataContent;
              $options = array(
                                'conditions' => array(
                                                'Categoria.alias' => $alias,
                                                'Artigo.isdeleted' => 'N',
                                                'Artigo.status' => 'P'
                                                     ),
                                'order' => array('Artigo.data_publicacao' => 'DESC'),
                                'limit' => 15
                               );
            $this->paginate = $options;
            $Artigos = $this->paginate('ArtigosCategoria');
            $i=0;
            $totalSize = sizeof($Artigos);
            while($i<$totalSize){
                $Artigos[$i]['Caderno'] = $data['caderno'];
                $i++;
            }
            $categorias = $data['categorias'];
            $listCategories = $data['list_categorias'];
            $selectColor = $data['caderno']['cor'];
            $caderno = $data['caderno'];
           
            ########## BANNER SIDEBAR ##########
            $adOptions = array('conditions' => array(
                                                        'AdType.alias'=> 'banner-sidebar', 
                                                        'Ad.caderno_id'=> $data['caderno']['id']), 
                                                        'limit'=>2);
            $data['anuncio_sidebar'] = false;
            if($this->SelectAd->start('ver_artigo', $adOptions)){
                    $data['anuncio_sidebar'] = $this->SelectAd->dataContent;
            }
            $this->set('anuncio_sidebar', $data['anuncio_sidebar']);
            ########## FIM DE BANNER SIDEBAR ##########
     
            $this->set('artigos', $Artigos);
            $this->set('crumbTitle', $data['categoria']['nome']);
            $this->set(compact('caderno', 'selectColor', 'categorias', 'listCategories'));
          }else{
               $this->redirect(array('action' => 'naolocalizado'));
          }  
    }

    public function caderno($caderno = null){
        if($this->Content->startContent('ver_caderno', $caderno))
        {
            $data = $this->Content->dataContent;
         
            $options = array(
                    'conditions' => array(
                            'Artigo.isdeleted' => 'N',
                            'Caderno.alias' => $caderno,
                            'Artigo.status' => 'P',
                            'Artigo.data_publicacao <='=> date('Y-m-d H:i:s')
                        ),
                    'order' => array('Artigo.data_publicacao' => 'DESC'),
                    'limit' =>15
            );
            $this->paginate = $options;
            $Artigos = $this->paginate('Artigo');
   
            ########## BANNER SIDEBAR ##########
            $adOptions = array('conditions' => array(
                                                        'AdType.alias'=> 'banner-sidebar', 
                                                        'Ad.caderno_id'=> $data['caderno']['id']), 
                                                        'limit'=>2);
            $data['anuncio_sidebar'] = false;
             
            if($this->SelectAd->start('ver_artigo', $adOptions)){
                    $data['anuncio_sidebar'] = $this->SelectAd->dataContent;
            }
          
            $this->set('anuncio_sidebar', $data['anuncio_sidebar']);
            ########## FIM DE BANNER SIDEBAR ##########
            
            
            
            $this->set('crumbTitle', $data['caderno']['nome']);
            $this->set('caderno', $data['caderno']);
            $this->set('artigos', $Artigos);
            $this->set('selectColor', $data['caderno']['cor']);
            $this->set('categorias', $data['categorias']);
        }else{
            $this->redirect(array('action' => 'naolocalizado'));
        }           
   }
   
   public function searchPosts($term = null)
   {
        if(($this->request->is('post') || $this->request->is('put')) and !empty($this->request->data['search-terms']))
        {
            $this->redirect(array('action' => 'searchPosts', $this->request->data['search-terms']));
        }
        $errors = false;$artigos = false;
        if($this->Content->startContent('searchPosts', $term))
        {
            $artigos = $this->Content->dataContent['artigos'];
        }else{
            $errors = $this->Content->errors;
        }
        $data = $this->Content->dataContent;
        $this->set('cadernos', $data['cadernos']);
        $this->set('errors', $errors);
        $this->set('artigos', $artigos);
   }
     
   public function getFile($id = null, $extension = null){
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
            $this->set($params);
       }else{
           $this->Session->setFlash(__('Parâmetros incompletos'), 'default', array('class' => 'error'));
           $this->redirect(array('action' => 'naolocalizado'));
           
       }    
       
       
       
       
       
   }
   
   
   
   
   ############ Métodos de contato do site ################ 
   public function contato()
   {
        if($this->request->is('post'))
        {    
            $data = $this->request->data;
            $data['Contato']['formulario_id'] = 1;
            $data['Contato']['created'] = date('Y-m-d H:i:s');
    
    
            if($this->SendMail->startSend($data['Contato']))
            { $data['Contato']['sent'] = 'Y'; }
            if($this->Contato->save($data)){
                 $this->Session->setFlash(__('Mensagem enviada com sucesso!!'), 'default', array('class' => 'success'), 'return');
                 $this->redirect(array('action' => 'contato'));
            }else{
                $this->Session->setFlash(__('A mensagem não foi enviada. Por favor, tente novamente!!'), 'default', array('class' => 'success'), 'return');
                $this->request->data = $data;
            }
        } 
        if($this->Content->startContent('contato')){
             $data = $this->Content->dataContent;
             $this->set('cadernos', $data['cadernos']);
        }
        $this->set('title_for_layout', 'Fale conosco');
   }
   
   public function colunista()
   {
       /*if($this->Session->read('formTrabalhe')){
          $this->request->data = $this->Session->read('formTrabalhe');
          $this->Session->delete('formTrabalhe');
       }*/
       if($this->request->is('post'))
       {
                    $data = $this->request->data;
                    if(!empty($data['CadastrosCaderno']['caderno_id']))
                    {
                        $datasource = $this->Cadastro->getDataSource();
                        try{
                            $datasource->begin();
                            $saveCadastro['Cadastro'] = $data['Cadastro'];
                            if(!$this->Cadastro->save($saveCadastro)){
                             throw new Exception();	   
                            }
                            $idCadastro = $this->Cadastro->id;
                            
                            $i=0;
                            $totalSize = sizeof($data['CadastrosCaderno']['caderno_id']);
                            while($i<$totalSize){
                                $saveCaderno[$i]['caderno_id'] = $data['CadastrosCaderno']['caderno_id'][$i];
                                $saveCaderno[$i]['cadastro_id'] = $idCadastro;
                                $i++;
                            }
                           if(!$this->CadastrosCaderno->saveAll($saveCaderno)){
                                throw new Exception();	   
                            }

                            $datasource->commit();
                            $this->Session->setFlash(__('Solicitação enviada com sucesso! Aguarde instruções por e-mail!'), 'default', array('class' => 'success'), 'return');
                            $this->redirect(array('action' => 'colunista'));
                        }catch(Exception $e){
                            $datasource->rollback();
                            $this->Session->setFlash(__('A solicitação não pode ser enviada. Por favor, tente novamente! '), 'default', array('class' => 'error'), 'return');
                            $this->request->data = $data;
                        }
                    }else{
                         $this->Session->setFlash(__('Você precisa selecionar pelo menos um caderno pelo qual tenha interesse de ser colunista! '), 'default', array('class' => 'error'), 'return');
                         $this->request->data = $data;
                    }
                    
       }
       
       #$find = $this->CadastrosCaderno->find('all');
      # pr($find); exit();
       $listCadernos['Tenho interesse em escrever para os cadernos:'] =  $this->Caderno->find('list', 
               array(
                        'fields' => array('Caderno.id', 'Caderno.nome'),
                        'conditions'=>array(
                                                'Caderno.isdeleted' => 'N',
                                                'Caderno.isactive' => 'Y'
                                            ),
                        'order'=>array( 'Caderno.nome' => 'ASC')
                   ));
       $this->set('listCadernos', $listCadernos);
       $this->set('title_for_layout', 'Venha ser um colunista!');
   }
   ############ Fim de Métodos de contato do site ################ 
}