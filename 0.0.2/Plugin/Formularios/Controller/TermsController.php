<?php
App::uses('FormulariosAppController', 'Formularios.Controller');
class TermsController extends FormulariosAppController{
    
public $uses = array('Formularios.Term');







public function admin_createTerm(){
    if($this->request->is('post') || $this->request->is('put'))
    {
			$save = $this->request->data;
            $datasource = $this->Term->getDataSource();
            try{
                $datasource->begin();

                if(!$this->Term->save($save)){
                    throw new Exception();	
                }

                $id = $this->Term->id;
                if(!$this->Term->updateAll(
                       array('Term.isactive' => "'N'"),
                       array('NOT'=>array('Term.id' => $id))
                )){
                     throw new Exception();
                }	
                
                $datasource->commit();
                $this->Session->setFlash(__('Termo de colaboração atualizado com sucesso!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'listTerms'));
            }catch(Exception $e){
                $datasource->rollback();
                $this->Session->setFlash(__('O termo não pode ser atualizado. Por favor, tente novamente!'), 'default', array('class' => 'error'));
            }
            
    }else{
        $this->request->data = $this->Term->find('first', array('conditions'=>array('Term.isactive'=>'Y')));
        
    }
    
}


public function admin_seeTerm($id = null)
{
    $dataTerm = $this->Term->find('first', array('conditions'=>array('Term.id'=>$id)));
    if(!empty($dataTerm))
    {
        
        
        $this->set('dataTerm', $dataTerm);
    }else{
        
        $this->Session->setFlash(__('Termo não localizado!'), 'default', array('class' => 'error'));
        $this->redirect(array('action' => 'listTerms'));
    }

}

public function admin_listTerms(){
    $options = array(
        'order' => array('Term.id' => 'DESC'),
        'limit' => 20
		);
		$this->paginate = $options;
		$Terms = $this->paginate('Term');
		$this->set('Terms', $Terms);
}









}