<?php
App::uses('Avatar', 'Avatar.Model');
App::uses('Colunista', 'ManagerBook.Model');
App::uses('Caderno', 'ConfigBook.Model');
App::uses('Categoria', 'Articles.Model');
App::uses('Artigo', 'Articles.Model');
App::uses('Extra', 'Articles.Model');
App::uses('Postagen', 'Conteudo.Model');
class ContentComponent extends Component{
    
    private $action = null;
    private $params = null;
    
    private $isValidation = true;
    public $dataContent = null;
    private $dataSearchs = null;
    
    public $components = array('QueryParameters');
    /**
     * Método que inicia a classe
     */
    public function startContent($action, $params = null){
        $this->cleanClass();
        $this->action = $action;
        $this->params = $params;
  
        $this->setContent();
      
        return $this->isValidation;
    } 
        
    private function setContent()
    {    
        switch($this->action)
        {
            case 'home':
                $this->setCadernos();
                $this->checkHomeDestaks();
                $this->setHomeArticles();
                #pr($this->dataContent); exit();
            break; 
        
            case 'searchPosts':
                $this->setCadernos();
                $this->setSearchArticles();
              //  pr($this->dataContent); exit(0);
            break; 
        
            case 'empresa':
                $this->setCadernos();
                $this->setEmpresa();
            break;
            
            case 'artigos':
                $this->setSelectCaderno();
                $this->checkArtigos();
                
            break;
            
            case 'contato':
                $this->setCadernos();
            break;
           
            case 'trabalheconosco':
              //  $this->setFornecedores();
            break;
        
            case 'ver_artigo':
                $this->setArticle();
                $this->setBookCategories();
                $this->setDataColumnist($this->dataContent['artigo']['person_id']);
                $this->setAvatar($this->dataContent['artigo']['person_id']);
                $this->setSelectExtras();
                
            break;
        
            case 'ver_preview':
                $this->setPreviewArticle();
                $this->setBookPreviewCategories();
                $this->setDataPreviewColumnist($this->dataContent['artigo']['person_id']);
                $this->setAvatar($this->dataContent['artigo']['person_id']);
            break;
            
            case 'ver_categoria':
                $this->selectCategorie();
                $this->setBookCategories();
            break;
        
            case 'ver_caderno':
                $this->setSelectCaderno();
                $this->setBookCategories();
            break;
                      
            case 'colunista':
                
                $this->setCadernos();
                $this->selectColunista();
            break;    
            
         case 'list-colunistas':
                $this->setCadernos();
            break;  
        
           case 'listar_pdfs':
                $this->setSelectCaderno();
            break;  
        
            default:
                $this->content = "<span style='color: red; '>Conteúdo não encontrado</span>";
                $this->isContent = false;
            break;
        }
    }
    
    private function setSelectExtras()
    {
        if($this->isValidation and !empty($this->dataContent['artigo']['id']))
        {
            $Extra = new Extra();
            $Extra->recursive = -1;
            $this->dataContent['extras'] = false;
            $find = $Extra->find('all', 
                    array(
                        'fields'=>array('Extra.id','Extra.nome','Extra.descricao','Extra.arquivo',
                                    'Extra.tipo_arquivo','Extra.artigo_id','Extra.caderno_id','Extra.user_id', 'Extra.person_id'
                        ),
                    'conditions'=>array(
                                        'Extra.isdeleted' => 'N', 
                                        'Extra.artigo_id' => $this->dataContent['artigo']['id']
                                       )));
            if(!empty($find))
            {
                $i=0;
                $totalSize = sizeof($find);
                while($i<$totalSize){
                    $this->dataContent['extras'][$i] = $find[$i]['Extra'];
                    $i++;
                }
            }
        } 
    }
    
  
    
    
    
      /**
          * Método que seta os artigos
          */
    private function setSearchArticles(){
        if($this->isValidation){
            $Artigo = new Artigo();
            $find = $Artigo->find('all', array(
                                'conditions' => array(
                                    'Artigo.isdeleted'=>'N',
                                    'Artigo.status' => 'P',
                                    'Artigo.data_publicacao <= '=> date('Y-m-d H:i'),
                                    'OR' => array(
                                        'Artigo.titulo LIKE '=> '%'.$this->params.'%',
                                        'Artigo.resumo LIKE '=> '%'.$this->params.'%',
                                        'Artigo.texto LIKE '=> '%'.$this->params.'%'
                                    )
                                    ),
                'order' => array('Artigo.data_publicacao'=>'DESC'),
                
                ));
            
           if(!empty($find)){
              $this->dataContent['artigos'] = $find;
           }else{
               $this->setErrors('<span style="font-weight: bold; ">Não foram localizados artigos com o termo: <span style="color: #c02230; font-size:1.7em; ">'.$this->params.'</span></span>');
           } 
        }
    }
    
    
    /**
        * Método que seta os dados do colunista selecionado
        */
    private function selectColunista(){
        $Colunista = new Colunista();
        $data = $Colunista->find('first', 
                array('conditions'=>array(
                                        'Colunista.alias' => $this->params,
                                        'Colunista.isactive' =>'Y'            
        )));
        
        $this->dataContent['avatar'] = false;
        if(!empty($data)){
            $this->dataContent['colunista'] = $data['Colunista'];
            $this->dataContent['colunista']['nome_completo'] =  $data['Individual']['nome']; 
            $this->dataContent['colunista']['data_nascimento'] =   $data['Individual']['data_nascimento'];
            
            if($data['Avatar']['id']):
            $this->dataContent['avatar'] = $data['Avatar'];
            endif;
        }else{
            $this->setErrors('Colunista não localizado!');
            
        }
    }
    
    
    
    /**
     * Método que seta os cadernos do portal
     */
    private function setCadernos()
    {
        $this->dataContent['cadernos'] = false;
        $Caderno = new Caderno();
        $find = $Caderno->query(
                "SELECT Caderno.id, Caderno.nome, Caderno.alias, Caderno.cor
                 FROM cw_cadernos as Caderno
                 INNER JOIN 
                            (SELECT 
                                   DISTINCT(Artigo01.caderno_id) 
                                   FROM cwcol_artigos As Artigo01
                                   WHERE Artigo01.status = 'P'
                             ) AS Artigo
                 ON Caderno.id = Artigo.caderno_id
                 WHERE Caderno.isdeleted = 'N'
                 AND
                 Caderno.isactive = 'Y'
                 ORDER BY Caderno.nome ASC"
                );
       if(!empty($find)){
           $i=0;
           $totalSize = sizeof($find);
           while($i<$totalSize){
               $this->dataContent['cadernos'][$i]['id'] = $find[$i]['Caderno']['id'];
               $this->dataContent['cadernos'][$i]['nome'] = $find[$i]['Caderno']['nome'];
               $this->dataContent['cadernos'][$i]['alias'] = $find[$i]['Caderno']['alias'];
               $this->dataContent['cadernos'][$i]['cor'] = $find[$i]['Caderno']['cor'];
               $i++;
           }
       }       
    }

    /**
     * Seta o caderno selecionado
     */
    private function setSelectCaderno()
    {
        if($this->isValidation)
        {
            $Caderno = new Caderno();
            $find = $Caderno->find('first', array(
                                                'conditions'=>array(
                                                         'Caderno.isdeleted' => 'N',
                                                         'Caderno.isactive' => 'Y',
                                                         'Caderno.alias' => $this->params
                                                )));
            if(!empty($find))
            {
                $this->dataSearchs = $find;
                $this->dataContent['caderno']['id'] =  $find['Caderno']['id']; 
                $this->dataContent['caderno']['alias'] =  $find['Caderno']['alias']; 
                $this->dataContent['caderno']['nome'] =  $find['Caderno']['nome'];   
                $this->dataContent['caderno']['descricao'] =  $find['Caderno']['descricao'];   
                $this->dataContent['caderno']['cor'] =  $find['Caderno']['cor']; 
                $this->dataContent['caderno']['url_form'] =  $find['Caderno']['url_form'];
                $this->dataContent['caderno']['url_post_form'] =  $find['Caderno']['url_post_form'];
            }else{
                $this->setErrors('Caderno não localizado! ');
            }
        }
    }
    
    /**
     * Seta os artigos do caderno selecionado
     */
    private function checkArtigos(){
        if($this->isValidation)
        {
            $Artigo = new Artigo();        
            $count = $Artigo->find('count', array(
                'conditions'=>array(
                                        'Artigo.isdeleted'=>'N',
                                        'Artigo.caderno_id'=>$this->dataSearchs['Caderno']['id'],
                                        'Artigo.status'=>'P',
                                        'Artigo.data_publicacao <= '=>date('Y-m-d H:i:s')
                                    )));
            if($count < 1){
                $this->setErrors('O caderno selecionado não possui nenhum artigo publicado! ');
            }
        }        
    }
    
    /**
          * Método que seta os artigos
          */
    private function setHomeArticles(){
        if($this->isValidation){
           
            $Artigo = new Artigo();
            $options = array(
                                'conditions' => array(
                                    'Artigo.isdeleted'=>'N',
                                    'Artigo.status' => 'P',
                                    'Artigo.data_publicacao <= '=> date('Y-m-d H:i')
                                    ),
                'order' => array('Artigo.data_publicacao'=>'DESC'),
                'limit' => 10
                );
            if(!empty($this->dataContent['idsDestaque'])){
                $options['conditions']['NOT'] = array('Artigo.id'=>$this->dataContent['idsDestaque']);
            }
            $find = $Artigo->find('all',$options);           
            if(!empty($find)){
               $this->dataContent['artigos'] = $find;
            }else{
                if(!empty($this->dataContent['idsDestaque'])){
                   unset($this->dataContent['idsDestaque']);
                   unset($this->dataContent['destaque']); 
                   $this->dataContent['destaque'] = false;
                   $this->setHomeArticles();
                }
            } 
        }
    }
    
    
    private function checkHomeDestaks(){
         if(!$this->params['isMobile']){
                $this->dataContent['destaque'] = false;
                $this->setHomeDestaks('view');
                $this->setHomeDestaks('last');
            }
        
    }
    
    
    
    private function selectCategorie(){
        $Categoria = new Categoria();
        $find = $Categoria->find('first', 
                array('conditions'=>array('Categoria.alias'=>$this->params, 'Categoria.isdeleted'=>'N')));
        if(!empty($find)){
            $this-> dataContent['categoria'] = $find['Categoria'];
            $this-> dataContent['caderno'] = $find['Caderno'];
            $this->dataContent['list_categorias'][] =  $find['Categoria']['id'];
        }else{
            $this->setErrors('Categoria não localizada!');
        }
    }
    
    
    private function setHomeDestaks($type){
        if(!$this->dataContent['destaque'])
        {
                $dateEnd = date('Y-m-d H:i');
                $dateStart = date('Y-m-d H:i', strtotime("-20 days",strtotime($dateEnd)));
                $options = array(
                                'limit' => 5
                                );
                $typeCond = array(
                    'view' => array(
                                    'conditions'=>array(
                                        'Artigo.data_publicacao BETWEEN ? AND ?'=>array($dateStart, $dateEnd),
                                        'Artigo.isdeleted'=>'N',
                                        'Artigo.status' => 'P'
                                        ),
                                    'order' => array('Artigo.page_views'=>'DESC')
                                    ),
                    'last' => array(
                        'conditions'=>array(
                            'Artigo.data_publicacao <=' => $dateEnd,
                                        'Artigo.isdeleted'=>'N',
                                        'Artigo.status' => 'P'
                                        ),
                                    'order' => array('Artigo.data_publicacao'=>'DESC')
                                    )
                );
                if(!empty($typeCond[$type])){
                    $options = array_merge($options, $typeCond[$type]);
                }
                $Artigo = new Artigo();
                $find = $Artigo->find('all', $options);
                
                if(!empty($find) and sizeof($find) > 4){
                   $this->dataContent['destaque'] = $find;
                   $i=0;
                   $totalSize = sizeof($find);
                   while($i<$totalSize){
                       $this->dataContent['idsDestaque'][$i] = $find[$i]['Artigo']['id'];
                       $i++;
                   }
                    
                }
        }
    }
    
    
    
    
    
    
    
    
    
    private function setEmpresa(){
       $this-> dataContent['empresa'] = false;
       $Postagen = new Postagen();
       $find = $Postagen->find('first', 
               array('conditions'=>array(
                   'Postagen.isactive' => 'Y',
                   'Postagen.isdeleted' => 'N'
                   )));
        if(!empty($find)){
          $this-> dataContent['empresa'] = $find['Postagen'];  
        }
    }
    
    private function setBookCategories(){
        if(!empty($this-> dataContent['caderno']['id'])){
            $caderno_id = $this-> dataContent['caderno']['id'];
            $this->dataContent['categorias'] = false;
            $Categoria = new Categoria();
            $today = date('Y-m-d H:i');
            $find = $Categoria->query(
                "SELECT * FROM cwcol_categorias AS Categoria
                    INNER JOIN (
                    SELECT DISTINCT(ArtigosCategoria.categoria_id) 
                    FROM cwcol_artigos_categorias AS ArtigosCategoria
                    LEFT JOIN cwcol_artigos AS Artigo
                    ON ArtigosCategoria.artigo_id = Artigo.id
                    WHERE Artigo.status = 'P'
                    AND Artigo.data_publicacao <= '".$today."'
                    AND 
                    Artigo.caderno_id = ".$caderno_id."
                    ) AS PublicCategoria
                    ON Categoria.id = PublicCategoria.categoria_id
                    WHERE 
                    Categoria.isdeleted = 'N'
                    AND
                    Categoria.isactive = 'Y'
                    ORDER BY Categoria.nome ASC
                    "
                );
            
           if(!empty($find)){
               $i=0;
               $totalSize = sizeof($find);
               while($i<$totalSize){
                   $this->dataContent['categorias'][$i]['nome'] = $find[$i]['Categoria']['nome'];
                   $this->dataContent['categorias'][$i]['alias'] = $find[$i]['Categoria']['alias'];
                   $this->dataContent['categorias'][$i]['id'] = $find[$i]['Categoria']['id'];
                   $i++;
               }
           } 
        }
    }
    
    
     private function setBookPreviewCategories(){
        if(!empty($this-> dataContent['caderno']['id'])){
            $caderno_id = $this-> dataContent['caderno']['id'];
            $this->dataContent['categorias'] = false;
            $Categoria = new Categoria();
            $today = date('Y-m-d H:i');
            $find = $Categoria->query(
                "SELECT * FROM cwcol_categorias AS Categoria
                    INNER JOIN (
                    SELECT DISTINCT(ArtigosCategoria.categoria_id) 
                    FROM cwcol_artigos_categorias AS ArtigosCategoria
                    LEFT JOIN cwcol_artigos AS Artigo
                    ON ArtigosCategoria.artigo_id = Artigo.id
                    WHERE 
                    Artigo.caderno_id = ".$caderno_id."
                    ) AS PublicCategoria
                    ON Categoria.id = PublicCategoria.categoria_id
                    WHERE 
                    Categoria.isdeleted = 'N'
                    ORDER BY Categoria.nome ASC
                    "
                );

           if(!empty($find)){
               $i=0;
               $totalSize = sizeof($find);
               while($i<$totalSize){
                   $this->dataContent['categorias'][$i]['nome'] = $find[$i]['Categoria']['nome'];
                   $this->dataContent['categorias'][$i]['alias'] = $find[$i]['Categoria']['alias'];
                   $this->dataContent['categorias'][$i]['id'] = $find[$i]['Categoria']['id'];
                   $i++;
               }
           } 
        }
    }
    
    
     private function setPreviewArticle(){
        $this->dataContent['artigo'] = false;
        $this->dataContent['caderno'] = false;
        $Artigo = new Artigo();
        $find =  $Artigo->find('first', 
                array('conditions'=>array(
                                            'Artigo.id' => $this->params,
                                            //'Artigo.status' => 'P',
                                            'Artigo.isdeleted' => 'N',
                                           // 'Artigo.data_publicacao <=' => date('Y-m-d H:i:s')    
                    
                    )));
        if(!empty($find)){
            $this->dataContent['artigo'] = $find['Artigo'];
            $this->dataContent['caderno'] = $find['Caderno'];
            $this->dataContent['list_categorias'] = false;
            # pr($find); exit(0);
            if(!empty($find['ArticlesCategorie'])){
                $i=0;
                $totalSize = sizeof($find['ArticlesCategorie']);
                while($i<$totalSize){
                    $this->dataContent['list_categorias'][$i] = $find['ArticlesCategorie'][$i]['categoria_id'];
                    $i++;
                }
            }
           #pr($this->dataContent); exit(0);
        }else{
            $this->setErrors('Artigo não localizado');
        }
    }
    
    
    
    private function setArticle(){
        $this->dataContent['artigo'] = false;
        $this->dataContent['caderno'] = false;
        $Artigo = new Artigo();
        $find =  $Artigo->find('first', 
                array('conditions'=>array(
                                            'Artigo.id' => $this->params,
                                            'Artigo.status' => 'P',
                                            'Artigo.isdeleted' => 'N',
                                            'Artigo.data_publicacao <=' => date('Y-m-d H:i:s')    
                    
                    )));
    
        if(!empty($find)){
            $this->dataContent['artigo'] = $find['Artigo'];
            $this->dataContent['caderno'] = $find['Caderno'];
            $this->dataContent['list_categorias'] = false;
             
            if(!empty($find['ArticlesCategorie'])){
                $i=0;
                $totalSize = sizeof($find['ArticlesCategorie']);
                while($i<$totalSize){
                    $this->dataContent['list_categorias'][$i] = $find['ArticlesCategorie'][$i]['categoria_id'];
                    $i++;
                }
            }

        }else{
            $this->setErrors('Artigo não localizado');
        }
    }
            //seta os dados do colunista    
            private function setDataColumnist($person_id = null){
                if($this->isValidation){
                    $this->dataContent['colunista'] = false;
                    $Colunista = new Colunista();
                    $Colunista->recursive = -1;
                    $find = $Colunista->find('first', array('conditions'=>array('Colunista.person_id' => $person_id, 'Colunista.isactive'=>'Y')));
                    if(!empty($find)){
                       $this->dataContent['colunista'] =  $find['Colunista'];
                    }
                }

            }
    
             //seta os dados do colunista    
            private function setDataPreviewColumnist($person_id = null){
                if($this->isValidation){
                    $this->dataContent['colunista'] = false;
                    $Colunista = new Colunista();
                    $Colunista->recursive = -1;
                    $find = $Colunista->find('first', array('conditions'=>array('Colunista.person_id' => $person_id)));
                    if(!empty($find)){
                       $this->dataContent['colunista'] =  $find['Colunista'];
                    }
                }

            }
            
            
    //seta os dados do colunista    
            private function  setAvatar($person_id = null){
                if($this->isValidation){
                    $this->dataContent['avatar'] = false;
                    $Avatar = new Avatar();
                    $Avatar->recursive = -1;
                    $find = $Avatar->find('first', array('conditions'=>array('Avatar.person_id' => $person_id, 'Avatar.isdeleted'=>'N')));
                    if(!empty($find)){
                       $this->dataContent['avatar'] =  $find['Avatar'];
                    }
                }

            }
    
    
    
    
    
    /**
     * Método que seta possíveis erros
     */
    private function setErrors($error){
        $this->isValidation = false;
        if(!empty($this->errors)){
            $this->errors = $this->errors .'<br>'.$error;
        }else{
            $this->errors = $error;
        }
    } 
    
     private function cleanClass()
     {
            $this->action = null;
            $this->params = null;
            $this->isValidation = true;
            $this->dataContent = null;
            $this->dataSearchs = null;
       
     }   
}