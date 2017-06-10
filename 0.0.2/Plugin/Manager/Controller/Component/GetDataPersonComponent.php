<?php
/**
 * Classe que irá retornar os dados do usuário
 */
App::uses('Person', 'Manager.Model');
App::uses('Individual', 'Manager.Model');
App::uses('Addresse', 'Manager.Model');
App::uses('Contactstype', 'Manager.Model');
App::uses('Contact', 'Manager.Model');
App::uses('User', 'Manager.Model');
App::uses('AccessUser', 'AccessUsers.Model');

class GetDataPersonComponent extends Component{
     
    private $person = null;
    private $group = false;

    public $returnData = null;
    private $returnDataSupport = null;
    
    public $errors = null;

    private $isValidation = true; 
    
    /**
     * @param type $person_id id da abela person
     * 
     * @param type $group formato em array ou com o nome do indice de informações em array(); 
     * Exemplo1: 'pessoa_fisica'
     * Exemplo2: array('Person', 'pessoa_fisica', 'endereco', 'contato', 'user, 'permissoes', 'list_permissions') 
     * Exemplo3: false -> retorna todos os indices
     * 
     * @param type $field: campo que deseja retornar.
     * @return se enciontrou o regstro ou não
     */
    public function start($person_id = false, $group = false)
    {
        $this->cleanClass();
        $this->person_id = $person_id;
        $this->group = $group;
        $this->setPerson();
        $this->setData();
        return $this->isValidation;
    }
    
    /**
     * Método que seta as informações da pessoa
     */
    private function setPerson()
    {
       $Person = new Person();
       $Person->recursive = -1;
       $this->returnData = $Person->findById($this->person_id);
        if(empty($this->returnData)){
             $this->setErrors('Registro não localizado!');   
        }
    }
    
    
    /**
     * Método que seleciona todos os dados
     */
    private function setData()
    {
        if($this->isValidation)
        {
            switch($this->group)
            {
                case false:
                    $this->setAllData();
                break;    

                default:
                    $this->setSelectData();
                break;    
            } 
        }
    }
    
    
    /**
     * Método que seleciona todos os dados
     */
    private function setAllData()
    {
         $this->setIndividual();       
         $this->setAddresse();       
         $this->setContact();       
         $this->setUser();
         $this->setEspecialPermissions();
    }
    
    /**
     * Método que seleciona a informação
     */
    private function setSelectData(){
        if(!is_array($this->group))
        {
            $this->selectInfo($this->group);
        }else{
            $this->setSelectIndex();
        }
    }
    
    
   /**
    * Método que seleciona as informações de indice único
    */ 
   private function  selectInfo($group){
      switch($group)
            {
                case 'pessoa_fisica':
                    $this->setIndividual();   
                break;    

                case 'endereco':
                       $this->setAddresse();   
                break;   

                case 'contato':
                       $this->setContact();   
                   break;   

                case 'user':
                       $this->setUser();   
                   break;   

               case 'permissoes':
                       $this->setUser();   
                       $this->setEspecialPermissions();   
               break;   
            }    
   }
    
    /**
     * Metodo que seleciona as informações de múltiplos indices
     */
    private function setSelectIndex()
    {
        $i=0;
        $totalSize = sizeof($this->group);
        while($i<$totalSize)
        {
            $this->selectInfo($this->group[$i]);
            $i++;
        }
    }
    
    
    /**
     * Método que seta os dados pessoais
     */
    private function setIndividual()
    {
        $this->returnData['pessoa_fisica'] = false;
        if($this->returnData['Person']['tipo_pessoa'] == 'F')
        {
            $Individual = new Individual();
            $Individual->recursive = -1;
            $data = $Individual->findByPersonId($this->person_id);
            if(!empty($data)){
                $this->returnData['pessoa_fisica'] = $data['Individual']; 
            }
        }
    }
        
     /**
     * Método que seta os dados de endereço
     */
    private function setAddresse()
    {
        $Addresse = new Addresse();
        $Addresse->recursive = -1;
        $data = $Addresse->findByPersonId($this->person_id);
        if(!empty($data)){
            $this->returnData['endereco'] = $data['Addresse']; 
        }
    }
    /**
     * Método que seta os dados de contato
     */
    private function setContact()
    {
        $this->returnData['contato'] = false;
        $Contact = new Contact();
        $Contact->recursive = 1;
        $data = $Contact->find('all', 
                                array('conditions'=>array(
                                                        'Contact.person_id'=>$this->person_id,
                                                        'Contact.isdeleted'=>'N'),
                                      'order'=>array('Contactstype.ordem'=>'ASC')
                                    ));
        if(!empty($data))
        {
            $i=0;
            $totalSize = sizeof($data);
            while($i<$totalSize)
            {
                $this->returnData['contato'][$i] = $data[$i]['Contact']; 
                $this->returnData['contato'][$i]['tipo'] = $data[$i]['Contactstype']['tipo']; 
                $this->returnData['contato'][$i]['label'] = $data[$i]['Contactstype']['label']; 
                $this->returnData['contato'][$i]['ordem'] = $data[$i]['Contactstype']['ordem']; 
                $i++;
            }
        }
    } 
    
    /**
     * Método que seta os dados de usuário
     */
    private function setUser()
    {
            $this->returnData['user'] = false; 
            $User = new User();
            $User->recursive = 1;
            $data = $User->find('first', array(
                                            'fields'=>array(
                                             'User.id',
                                             'User.username','User.status','User.created','User.createdby',
                                             'User.modified','User.modifiedby','User.isactive','User.isdeleted',
                                                            ),
                                            'conditions'=>array(
                                                                'User.person_id'=>$this->person_id)));            
            if(!empty($data)){
                $this->returnData['user'] = $data['User']; 
                if(!empty($data['Role'][0])){
                   $this->returnData['user']['grupo'] = $data['Role'][0]['role'];
                   $this->returnData['user']['alias'] = $data['Role'][0]['alias'];
                }else{
                    $this->returnData['user']['grupo'] = 'Sem permissão no sistema!';
                }
            }
    }
    
    
    
    
    
    
    /**
     * Método seu seta as permissões especiais
     */    
    private function setEspecialPermissions()
    {
        $this->returnData['permissoes'] = false;
        $this->returnData['list_permissions'] = false;
        if($this->returnData['user'])
        {
                $AccessUser = new AccessUser();
                $AccessUser->recursive = 1;
                $data = $AccessUser->find('all', 
                                        array('conditions'=>array(
                                                                'AccessUser.user_id'=>$this->returnData['user']['id'],
                                                                'AccessUser.isactive'=>'Y',
                                                                'Package.isdeleted'=>'N',
                                                                'User.isactive'=>'Y', 
                                                                'User.status'=>1
                        )));

                if(!empty($data))
                {
                    $i=0;
                    $totalSize = sizeof($data);
                    while($i<$totalSize)
                    {
                        $this->returnData['permissoes'][$i]['package_id'] = $data[$i]['Package']['id']; 
                        $this->returnData['permissoes'][$i]['alias'] = $data[$i]['Package']['alias']; 
                        $this->returnData['permissoes'][$i]['plugin'] = $data[$i]['Package']['plugin']; 
                        $this->returnData['permissoes'][$i]['nome'] = $data[$i]['Package']['nome']; 
                        $this->returnData['permissoes'][$i]['descricao'] = $data[$i]['Package']['descricao']; 
                        $this->returnData['list_permissions'][$i] = $data[$i]['Package']['plugin'];
                        
                        $i++;
                    }
                } 
        }
              
    }
    
    
    
    
    /**
     * Método que seta os erros na classe
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
    public function cleanClass()
    {
            $this->person = null;
            $this->group = false;
            $this->returnData = null;  
            $this->returnDataSupport = null;
            $this->errors = null;
            $this->isValidation = true;
    }    
}