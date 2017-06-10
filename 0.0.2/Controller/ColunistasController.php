<?php
App::uses('AppController', 'Controller');

class ColunistasController extends AppController
{
    public $uses = array('ManagerBook.Colunista', 'Articles.Artigo');
    public $components = array('Content');
    
    public function beforeFilter()
    {
            parent::beforeFilter();
            $allow = array('colunista', 'index');
            $this->Auth->allow($allow);
            if(!in_array($this->request->params['action'], $allow))
            {
                $this->redirect(array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false));
            }
    } 
    
    public function index(){
        $Colunistas = false;
        $listColPosts = $this->Artigo->find('list', 
                array(
                    'fields' => array('Artigo.person_id', 'Artigo.person_id'),
                    'conditions'=>array(
                                        'Artigo.isdeleted' => 'N',
                                        'Artigo.status' => 'P',
                    )));
        if(!empty($listColPosts)){
            sort($listColPosts);
            $options = array(
                    'conditions' => array('Colunista.isactive' => 'Y', 
                        'NOT'=>array('Colunista.resumo'=>null),
                        'Colunista.person_id' => $listColPosts
                        ),
                    'order' => array('Colunista.apelido' => 'ASC'),
                    'limit' => 15
            );
            $this->paginate = $options;
            $Colunistas = $this->paginate('Colunista');
        }
        $this->Content->startContent('list-colunistas');
        $data = $this->Content->dataContent;
        $this->set('cadernos', $data['cadernos']);
        $this->set('Colunistas', $Colunistas);
    }
    
    
    public function colunista($alias = null){
       if($this->Content->startContent('colunista', $alias))
       {
           $data =  $this->Content->dataContent; 
           $this->set('cadernos', $data['cadernos']);
           $this->set('dados', $data); 
           $this->set('crumbTitle', $data['colunista']['apelido']); 
        }else{
            $this->redirect(array('plugin'=>false, 'controller'=>'public', 'action'=>'naolocalizado'));
        }
    }
    
}