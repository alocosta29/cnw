<?php
App::uses('Colunista', 'ManagerBook.Model');
class CheckDataColunistaComponent extends Component{
    
    private $person_id = null;
    private $action = null;
    private $caderno = null;
      
    public $url = null;
    
    private $isValidation = true;
	public $errors = null;
    
    public function start($person_id = null, $action = null, $caderno = null){
        $this->cleanClass();
        $this->person_id = $person_id;
        $this->action = $action;     
        $this->caderno = $caderno;
        $this->valid();
        
        return $this->isValidation;
    }
    
    
    private function valid(){
            switch ($this->action)
            {
                case 'admin_index':
                    $this->setData();  
                    $this->checkData();
                break;    

                default:
                    
                break;

            }
    }
    
    /**
     * Método que seta os dados do colunista
     */
    private function setData()
    {
        $Colunista = new Colunista();
        $find = $Colunista->find('first', 
                array(
                    'conditions'=>array('Colunista.person_id'=>$this->person_id))
                    );

        if(!empty($find)){
            $this->data = $find['Colunista'];
        }else{
            $this->setUrl(1);
            $this->setErrors('Não foram localizados dados de colunista. Por favor, antes de escrever algo, preencha os dados da sua apresentação!');
        }
    }
    
    /**
     * Método que verifica se o colunista possui alguns dados para serem exiidos no perfil
     */
    private function checkData()
    {
        if($this->isValidation)
        {
            if(empty($this->data['resumo']) or empty($this->data['apelido'])){
                $this->setErrors('Por favor, preencha suas informações de colunista! ');
                $this->setUrl(1);
            }
        }
    }   
    
    /**
     * Método que seta a url de desti
     * no
     * @param type $number
     */
    private function setUrl($number){
      $arrayUrl  = array(
          1 => array('plugin'=> 'articles', 'controller'=>'profiles', 'action'=>'edit', $this->caderno),
      );
      $this->url = $arrayUrl[$number];
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
            $this->person_id = null;
            $this->isValidation = true;
            $this->errors = null;
    }
    
    
}