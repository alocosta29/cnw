<?php
App::uses('ConteudoAppController', 'Conteudo.Controller');
class ConteudosController extends ConteudoAppController{
    
    public $uses = array('Conteudo.CatConteudo', 'Conteudo.Postagen');
    public $components = array('Conteudo.ValidConteudo');
     
    /**
          * Editar descrição institucional
          */
    public function admin_editDescricaoInstitucional()
    {  
            if($this->request->is('post') || $this->request->is('put'))
            {
                //$data['Conteudo']['id'] = $id;    
               $data = $this->request->data;
               if($this->ValidConteudo->startValid($data['Postagen'], 'admin_editDescricaoInstitucional'))
               {
                  $data['Postagen']['cat_conteudo_id'] = $this->ValidConteudo->getCategory;
                  $data['Postagen']['isactive'] = 'Y';
                  $datasource = $this->Postagen->getDataSource();
                    try{
                        $datasource->begin();
                       
                        if(!$this->Postagen->updateAll(
                                array('Postagen.isdeleted' => "'Y'"),
                                array('Postagen.isdeleted' => 'N', 'Postagen.cat_conteudo_id' => 1)
                                    ))
                        throw new Exception();
                                              
                        if(!$this->Postagen->save($data))
                            throw new Exception();
                                        
                        $datasource->commit();
                        $this->Session->setFlash(__('Descrição institucional atualizada com sucesso.'), 'default', array('class'=>'success'));
                        $this->redirect(array('action' => 'visualizaDescricaoInstitucional'));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->request->data = $data;
                        $this->Session->setFlash(__('A descrição institucional não pode ser atualizada. Por favor, tente novamente!'), 'default', array('class'=>'error'));
                    }
               }else{
                   $this->request->data = $data;
                   $this->Session->setFlash(__($this->ValidConteudo->getErrors()), 'default', array('class'=>'error'));
               }
                
            }else{
                   $this->request->data = $this->Postagen->find('first', array(
                                            'conditions'=>array('CatConteudo.alias'=> 'quem-somos', 'Postagen.isdeleted'=>'N'),
                                            'order'=>array( 'Postagen.id'=>'DESC'),
                                            'limit'=> 1));
            }
            $this->set('title_for_layout', 'Conteúdo -> Editar descrição institucional');
    }
    
    public function admin_visualizaDescricaoInstitucional()
    {
         $this->set('quemSomos', $this->Postagen->find('first', array(
                                            'conditions'=>array('CatConteudo.alias'=> 'quem-somos', 'Postagen.isdeleted'=>'N'),
                                            'order'=>array( 'Postagen.id'=>'DESC'),
                                            'limit'=> 1)));
         $this->set('title_for_layout', 'Conteúdo -> Descrição institucional');        
    }
    
    public function admin_editContent($category = null)
    {
        if($this->ValidConteudo->startValid($category, 'editContent'))
        {
            $data = $this->ValidConteudo->dataAction;
 
            if($this->request->is('post') || $this->request->is('put'))
            {
                    $dataSave = $this->request->data;
                    $dataSave['Postagen']['cat_conteudo_id'] = $data['categoria']['id'];
                    $dataSave['Postagen']['isactive'] = 'Y';
                    $datasource = $this->Postagen->getDataSource();
                    try{
                        $datasource->begin();
                       
                        if(!$this->Postagen->updateAll(
                                array('Postagen.isdeleted' => "'Y'"),
                                array('Postagen.isdeleted' => 'N', 
                                      'Postagen.cat_conteudo_id' => $data['categoria']['id'])
                                    )){
                            throw new Exception(); 
                        }
                                              
                        if(!$this->Postagen->save($dataSave)){
                            throw new Exception();
                        }
                                        
                        $datasource->commit();
                        $this->Session->setFlash(__('Conteúdo da sessão atualizado com sucesso.'), 'default', array('class'=>'success'));
                        $this->redirect(array('action' => 'index'));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->request->data = $data;
                        $this->Session->setFlash(__('O conteúdo da sessão não pode ser atualizado. Por favor, tente novamente!'), 'default', array('class'=>'error'));
                    }
            }else{
                $this->request->data['Postagen'] = $data['conteudo'];
                $this->Session->setFlash(__($this->ValidConteudo->getErrors()), 'default', array('class'=>'error'));
            }
            $this->set('categoria', $data['categoria']['categoria']);
        }else{
            $this->Session->setFlash(__($this->ValidConteudo->getErrors()), 'default', array('class'=>'error'));
            $this->redirect(array( 'action' => 'index'));
        }
        $this->set('title_for_layout', 'Conteúdo -> Editar conteúdo de sessão');        
    }
    
    public function admin_index()
    {
        if($this->ValidConteudo->startValid(null, 'listSection'))
        {
            $data = $this->ValidConteudo->dataAction;  
            
            $this->set('categorias', $data['categorias']);
        }else{
            $this->Session->setFlash(__($this->ValidConteudo->getErrors()), 'default', array('class'=>'error'));
            $this->redirect(array('plugin'=>'manager', 'controller'=>'users', 'action' => 'index'));
        }
        $this->set('title_for_layout', 'Conteúdo -> Administrar conteúdo das sessões');
    }       
}