<?php
App::uses('Companie', 'Manager.Model');
App::uses('Addresse', 'Manager.Model');
App::uses('Individual', 'Manager.Model');
App::uses('Contact', 'Manager.Model');
App::uses('Colunista', 'ManagerBook.Model');

class CheckProfileDataComponent extends Component{
    private $data = null;    
    public $errors = null;
    private $isValidation = true;

    public $components = array('Manager.Persona');
     
    public function startCheck($data)
    {
        $this->cleanClass();
        $this->data = $data;
        $this->checkExistIndividual();
        $this->checkExistColunista();
        $this->checkExistUser();
        $this->setTypeContact();
        $this->checkMail();
       
        return $this->isValidation;
    }
       
    /**
     * Método criado para tratar o array da edição de loja
     */
    public function startCheckEdit($data){
        $this->cleanClass();
        $this->data = $data;
        #Métodos que retorna chaves primarias para alterar registro
        $this->setIdEditCompanie();
        $this->setIdEditAddresse();
        #Fim de Métodos que retorna chaves primarias para alterar registro
        $this->setTypeContact();
        $this->checkMail();
        return $this->isValidation;
    }
    
    /**
     * Método criado para tratar o array do cadastro de profissional
     */
    public function startInsertProfessional($data)
    {
        $this->cleanClass();
        $this->data = $data;
        $this->checkExistIndividual();
        $this->setTypeContact();
        $this->checkMail();
        $this->checkContactExist();
        return $this->isValidation; 
    }
          
     /**
     * Método criado para tratar o array da edição do cadastro de profissional
     */
    public function startEditProfessional($data)
    {
        $this->cleanClass();
        $this->data = $data;
        $this->setTypeContact();            
        $this->checkMail();
        //$this->checkContactExist();
        return $this->isValidation; 
    }
    
    /**
     * Método verifica seocontato já foi cadastrado. Caso tenha sido, o sistema retorna a ID para a atualização do mesmo 
      */
    private function checkContactExist(){
       if(!empty($this->data['Person']['id']))
       {
                $i=0;
                $totalSize = sizeof($this->data['Contact']);
                while($i<$totalSize)
                {
                    $this->data['Contact'][$i] = $this->getDataWithIdContact($this->data['Contact'][$i], $this->data['Person']['id']);
                    $i++;
                }
       } 
    }
    
    /**
     * Método que retorna o id do contato,caso ele ja esteja cadastrado
     */
     private function getDataWithIdContact($data, $person_id){
         $Contact = new Contact();
         $find = $Contact->find('first', array('conditions'=>array('Contact.person_id'=>$person_id, 'Contact.contato'=>$data['contato'])));
         if(!empty($find)){
           $data['id'] = $find['Contact']['id']; 
         }
         return $data;         
     }
    
    /**
     * Método que verifica se o cpf já foi cadastrado no sistema 
     */
    private function checkExistIndividual(){
        if($this->isValidation and !empty($this->data['Individual'][0]))
        {
            $Individual = new Individual();
            $Individual->recursive = -1;
            $find = $Individual->findByCpf(preg_replace("/[^0-9]/i", "", $this->data['Individual'][0]['cpf']));
            
            if(!empty($find)){
                $this->data['Individual'][0]['id'] = $find['Individual']['id'];
                $this->data['Person']['id'] = $find['Individual']['person_id'];
            }            
        }
    }
    
      /**
     * Método que verifica se o cpf já foi cadastrado no sistema 
     */
    private function checkExistUser(){
        if($this->isValidation and !empty($this->data['User'][0]) and !empty($this->data['Person']['id']))
        {
            $User = new User();
            $User->recursive = -1;
            $find = $User->find('first', array('conditions'=>array('User.person_id'=>$this->data['Person']['id'])));
            $this->data['User'][0]['person_id'] = $this->data['Person']['id'];
            if(!empty($find)){
                $this->data['User'][0]['id'] = $find['User']['id'];
            }            
        }
    }
        
    /**
     * Método que verifica se o cpf já foi cadastrado no sistema 
     */
    private function checkExistColunista(){
        if($this->isValidation and !empty($this->data['Colunista'][0]) and !empty($this->data['Person']['id']))
        {
            $this->data['Colunista'][0]['person_id'] = $this->data['Person']['id'];
        }
    }
    
     /**
     * Métodos que retorna chave primaria da tabela Addresse para alterar registro
     */
     private function setIdEditAddresse(){
         if(!empty($this->data['Addresse'])){
             $Addresse = new Addresse();
             $Addresse->recursive = -1;
             $find = $Addresse->find('first', array('conditions'=>array('Addresse.person_id'=>$this->data['Loja']['person_id'])));
             if(!empty($find)){
                 $this->data['Addresse']['id'] = $find['Addresse']['id'];
             }
             $this->data['Addresse']['person_id'] = $this->data['Loja']['person_id'];
         }
     }
    
    /**
     * Métodos que retorna chave primaria da tabela Companie para alterar registro
     */
     private function setIdEditCompanie(){
         if(!empty($this->data['Companie'])){
             $Companie = new Companie();
             $Companie->recursive = -1;
             $find = $Companie->find('first', array('conditions'=>array('Companie.person_id'=>$this->data['Loja']['person_id'])));
             if(!empty($find)){
                 $this->data['Companie']['id'] = $find['Companie']['id'];
             }
             $this->data['Companie']['person_id'] = $this->data['Loja']['person_id'];
         }
     }
    
    /**
     * Método que "seta" o tipo de contato
     */
    private function setTypeContact()
    {
        if(!empty($this->data['Contact']))
        {
            $i=0;
            $totalSize = sizeof($this->data['Contact']);
            while($i<$totalSize)
            {
                if(!empty($this->data['Contact'][$i]['id']))
                {    
                       if(empty($this->data['Contact'][$i]['contato'])){
                           $this->data['Delete']['Contact']['id'][] = $this->data['Contact'][$i]['id'];
                           unset($this->data['Contact'][$i]);     
                       }else{
                           $this->data['Contact'][$i]['typeAlias'] = $this->Persona->_retornaAliasContact($this->data['Contact'][$i]['contactstype_id']);
                       }
                }else{
                        if(!empty($this->data['Contact'][$i]['contato']))
                        {
                           $this->data['Contact'][$i]['typeAlias'] = $this->Persona->_retornaAliasContact($this->data['Contact'][$i]['contactstype_id']);
                        }else{
                           unset($this->data['Contact'][$i]);
                        }
                }                    
                $i++;
            }
        }
    }
    
     /**
     * Método que valida os endereços de email
     */
    private function checkMail()
    {
            if(!empty($this->data['Contact'])){
                $i=0;
                $totalSize = sizeof($this->data['Contact']);

                while($i<$totalSize){
                  if(!empty($this->data['Contact'][$i]['contato']) and $this->data['Contact'][$i]['typeAlias'] == 'email'){
                      if(!$this->validMail($this->data['Contact'][$i]['contato'])){
                          $this->setErrors("Formato de e-mail incorreto. Por favor, verifique o email: ".$this->data['Contact'][$i]['contato']);
                      }
                  }
                  $i++;
                }
            }
    }
    
    /**
     * Método de validação de email
     */
    private function validMail($email) 
    {
        $conta = "^[a-zA-Z0-9\._-]+@";
        $domino = "[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$";
        $pattern = $conta.$domino.$extensao;
        if(ereg($pattern, $email)){
            return true;
        }else{
            return false;
        }   
    }
    
    private function setErrors($error){
        $this->isValidation = false;
        if(!empty($this->errors))
        {
            $this->errors =  $this->errors."<br>".$error;
        }else{
            $this->errors = $error;
        }
    }
    
    private function cleanClass()
    {
        $this->data = null;
        $this->errors = null;
        $this->isValidation = true;
    }
    

    
    public function getData(){
        return $this->data;
    } 
}