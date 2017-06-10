<?php
App::uses('Postagen', 'Conteudo.Model');
App::uses('CatConteudo', 'Conteudo.Model');
class ValidConteudoComponent extends Component{
    private $action = null;
    private $data = null;
    private $category = false;
    private $errors = null;
    public $getCategory = null;
    public $dataAction = null;
    
    private $isValidation = true;
    
    public function startValid($data, $action, $category=false){
        $this->cleanClass();
        $this->data = $data;
        $this->action = $action;
        $this->category = $category;
        $this->checkData();        
        return $this->isValidation;      
    }
    
    public function startGetCategorie($category = false){
        $this->cleanClass();
        $this->setCategory($category);
        return $this->isValidation;   
    }
    
    /**
     * Método que valida e checa categoria 
     */
    private function checkData($category = null)
    {    
            switch($this->action)
            {
                    case 'admin_editDescricaoInstitucional':
                         $this->checkEmptyTitle();
                         $this->checkEmptyText();
                         $this->setCategory('quem-somos');
                    break;

                    case 'admin_cadastraIntro':
                         $this->checkEmptyTitle();
                         $this->checkEmptyText();
                    break;

                    case 'listSection':
                         $this->setListCategory(); 
                        $this->checkStatusContent();
                    break;

                    case 'editContent':
                         $this->setCategoryById($this->data);  
                         $this->searchContent();
                    break;

                    default:
                         $this->setErrors('Parâmetros incompletos!');
                    break;
            }
    }
        
     /**
             * Método que seta a categoria
             */    
     private function setCategory($category)
     {
        if($this->isValidation)
        {
            $CatConteudo= new CatConteudo();
            $find = $CatConteudo->findByAlias($category);
            if(!empty($find))
            {
                $this->getCategory = $find['CatConteudo']['id'];
            }else{
                $this->setErrors('Categoria não localizada');
            }
        } 
     } 
     
      /**
             * Método que seta a categoria pelo id
             */    
     private function setCategoryById($category)
     {
        if($this->isValidation)
        {
            $CatConteudo = new CatConteudo();
            $CatConteudo->recursive = -1;
            $find = $CatConteudo->find('first', array('conditions' => 
                    array(
                           'CatConteudo.id'=>$category, 
                           'CatConteudo.isdeleted'=>'N')));
            if(!empty($find))
            {

                $this->dataAction['categoria'] = $find['CatConteudo'];
            }else{
                $this->setErrors('Categoria não localizada');
            }
        }    
     }    
     
     
    /**
           * Método que seta a categoria
           */    
     private function setListCategory()
     {
            if($this->isValidation)
            {
                    $CatConteudo= new CatConteudo();
                    $CatConteudo->recursive = -1;
                    $find = $CatConteudo->find('all', 
                                                    array(
                                                            'fields' => array('CatConteudo.id', 'CatConteudo.categoria'),
                                                            'conditions' => array('CatConteudo.isdeleted'=>'N'),
                                                            'order' => array('CatConteudo.categoria'=>'ASC')
                                                        ));
                    if(!empty($find))
                    {
                        $this->dataAction['categorias'] = $find;
                    }else{
                        $this->setErrors('Categorias não localizadas!');
                    }
            }    
     }
     
    /**
     * Método que checa se a variável está vazia
     */
    private function checkEmptyTitle()
    {    
        if(!$this->checkEmpty($this->data['titulo'])){
            $this->setErrors("Erro! O campo <strong>Título</strong> não pode estar vazio.");
            $this->isValidation = false;
        }
    }
    
     /**
     * Método que checa se a variável está vazia
     */
    private function checkEmptyText(){
        if(!$this->checkEmpty($this->data['texto'])){
            $this->setErrors("Erro! O campo <strong>Conteúdo</strong> não pode estar vazio.");
            $this->isValidation = false;
        }
    }
    
    /**
     * Método que verifica se existe conteudo para o 
     */
    private function searchContent(){
            if($this->isValidation)
            {
                    $Postagen = new Postagen();
                    $Postagen -> recursive = -1;
                    $find = $Postagen->find('first', 
                            array('conditions'=>array(
                                                        'Postagen.cat_conteudo_id' => $this->data,
                                                        'Postagen.isdeleted' => 'N',
                                'Postagen.isactive'=>'Y'
                                                      )));
                    if(!empty($find)){
                        $this->dataAction['conteudo'] = $find['Postagen'];
                    }
            }
    }
    
    
    /**
     *Método que verifica se existe conteudo cadastrado para a sessãpo 
     */
    private function checkStatusContent(){
        if($this->isValidation){
            if(!empty($this->dataAction['categorias'])){
              $i=0;
              $totalSize = sizeof($this->dataAction['categorias']);
              while($i<$totalSize){
                 $this->dataAction['categorias'][$i]['CatConteudo']['status'] = $this->checkStatusSession($this->dataAction['categorias'][$i]['CatConteudo']['id']);
                $i++; 
              }  
            }            
        }
    }
    
    /**
           * Método que retorna o status de conteudo da sessão 
           * @param type $id
           * @return string
           */
    private function checkStatusSession($id)
    {
        $Postagen = new Postagen();
        $return = 'NÃO CADASTRADO';
        $Postagen -> recursive = -1;
        $find = $Postagen->find('count', 
                 array('conditions'=>array(
                                             'Postagen.cat_conteudo_id' => $id,
                                             'Postagen.isdeleted' => 'N',
                                             'Postagen.isactive'=>'Y'
                                           )));
        if($find > 0){
            $return = 'CADASTRADO';
        } 
        return $return;
    }
    
    
    
        
    /**
        * Método que checa se a variável está vazia
        */
    private function checkEmpty($variable)
    {
        if(!empty($variable)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Método que seta os possíveis erros encontrados
     */
    private function setErrors($error){
        if(!empty($this->errors)){
            $this->errors = $this->errors.'<br>'.$error;
        }else{
            $this->errors = $error;
        }
    }
    
    /**
     * Método que retorna mensagens de possíveis erros encontrados
     */
    public function getErrors(){
        return $this->errors;
    }
        
    /**
     * Método que "limpa" a classe
     */    
    private function cleanClass()
    {
        $this->action = null;
        $this->dataAction = null;
        $this->data = null;
        $this->category = false;
        $this->getCategory = null;
        $this->errors = null;
        $this->isValidation = true;
    }
}