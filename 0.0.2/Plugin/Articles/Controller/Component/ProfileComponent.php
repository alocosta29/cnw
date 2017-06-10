<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('Individual', 'Manager.Model');
App::uses('Colunista', 'ManagerBook.Model');
App::uses('Avatar', 'Avatar.Model');
class ProfileComponent extends Component{
    
    private $id = null;
    public $dataProfile = null;
    private $isValidation = true;
	public $errors = null;
    
    public function start($id = null){
        $this->cleanClass();
        $this->id = $id;
        $this->startVariables();
        $this->findData();  
        $this->findProfileCol(); 
        $this->findAvatar();
        return $this->isValidation;
    }
    
    /**
     * Busca os dados do perfil
     */
    private function findData(){
        $Individual = new Individual();
        $Individual->recursive = 0;
        $find = $Individual->find('first', array('conditions'=>array('Individual.person_id'=>$this->id)));
       
        if(!empty($find))
        {
            $this->setData($find);
        }else{
            $this->setErrors('Perfil não localizado');
        }
    }
    
    /**
     * Método que busca os dados de colunista
     */
    private function findProfileCol()
    {
        if($this->isValidation)
        {
           $Colunista = new Colunista();
           $find = $Colunista->find('first', array('conditions'=>array('Colunista.person_id'=>$this->id)));
           if(!empty($find)){
               $this->setData($find);
           }
        }  
    }
    
    /**
     * Método que seta o avatar do usuário
     */
    private function findAvatar(){
       if($this->isValidation)
       { 
           $Avatar = new Avatar();
           $find =  $Avatar->find('first', array(
               'conditions'=>array(
                   'Avatar.person_id'=>$this->id,
                   'Avatar.isdeleted' => 'N'
                   )));
           if(!empty($find)){
               $this->setData($find);
           }
       } 
    }
    
    /**
     * Método que seta os dados do usuário
     * @param type $data
     */
    private function setData($data){
        
        foreach ($data as $key => $value) 
        {
            switch ($key) 
            {
               case 'Individual':
                    $this->dataProfile['nome'] = $data['Individual']['nome'];
                    $this->dataProfile['cpf'] = $data['Individual']['cpf'];
                    $this->dataProfile['data_nascimento'] = $data['Individual']['data_nascimento'];
                    $this->dataProfile['sexo'] = $data['Individual']['sexo'];
                    $this->dataProfile['nome'] = $data['Individual']['nome'];
               break;

               case 'User':
                    $this->dataProfile['username'] = $data['User']['username'];
               break;
           
               case 'Colunista':
                    $this->dataProfile['apelido'] = $data['Colunista']['apelido'];
                    $this->dataProfile['alias'] = $data['Colunista']['alias'];
                    $this->dataProfile['resumo'] = $data['Colunista']['resumo'];
                    $this->dataProfile['bio'] = $data['Colunista']['bio'];
               break;
           
               case 'Avatar':
                    $this->dataProfile['avatar'] = $data['Avatar']['avatar'];
                   $this->dataProfile['avatar_id'] = $data['Avatar']['id'];
               break;
           
                
               default:
                    break;
            }
        }
    }
    
    private function startVariables(){
        $this->dataProfile['person_id'] = $this->id;
        $this->dataProfile['nome'] = null;
        $this->dataProfile['apelido'] = null;
        $this->dataProfile['alias'] = null;
        $this->dataProfile['cpf'] = null;
        $this->dataProfile['data_nascimento'] = null;
        $this->dataProfile['sexo'] = null;
        $this->dataProfile['username'] = null;
        $this->dataProfile['user_id'] = null;
        $this->dataProfile['avatar'] = null;
        $this->dataProfile['resumo'] = null;
        $this->dataProfile['bio'] = null;
    }
    
    
       /**
        * Método que seta os erros encontrados
        * @param type $error
        */
       private function setErrors($error = null)
       {
            $this->isValidation = false;
            if(!empty($this->errors)){
                $this->errors = $this->errors.'<br>'.$error;
            }else{
                $this->errors = $error;
            }
       }
    
    /**
     * Método que limpa a classe
     */
    private function cleanClass()
    {
        $this->id = null;
        $this->dataProfile = null;
        $this->isValidation = true;
        $this->errors = null;
    }
    
    
}