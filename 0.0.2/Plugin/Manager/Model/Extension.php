<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Extension extends ManagerAppModel{
       public $name = 'Extension';
       public $useTable = 'extensions';
        
       public $validate = array
       (     
         'complete_number' =>array(
                            'notEmpty' => array(
                                                'rule'=>'notEmpty',
                                                'message' => "Por favor digite o ramal",
                                                ),
                            'checkFormat' => array(
                                                'rule'    => 'checkFormat',
                                                'message' => 'Formato inválido! Verifica o ramal digitado!',
                                                ),
                            'extensionBroken' => array(
                                                'rule'    => 'extensionBroken',
                                                'message' =>'Formato inválido! Favor verificar o ramal digitado!'
                                                ),
                             'isUniqueOptimize' => array(
                                                'rule'    => 'isUniqueOptimize',
                                                'message' =>'Ramal já cadastrado!'
                                                 ),                                                   
                                        ),  
       );     
            
    /**
     * Método que verifica se o formato de ramal está correto
     */    
    public function checkFormat()
    {
       $number = preg_replace("/[^0-9\s]/", "", $this->data['Extension']['complete_number']); 
       if(strlen($number) <> 11)
       {
           return false;
       }else{
           return true;
       }
    }  
    
    /**
     * Método que "quebra"  trata o número de ramal
     */
    public function extensionBroken()
    {
       try{
            $number = explode('-', $this->data['Extension']['complete_number']);
            $this->data['Extension']['number_extension'] = $number[1];
            $brokenPrefix = explode(')', $number[0]);
            $this->data['Extension']['prefix_number'] = $brokenPrefix[1];
            $this->data['Extension']['code_area'] = preg_replace("/[^0-9\s]/", "", $brokenPrefix[0]); 
            return true;
       }catch(Exception $e){
           return false;
       }
    }     
        
    /**
     * Método que verifica se o ramal já não está cadastrado
     */    
      public function isUniqueOptimize()
      {
        $form = $this->data;      
        if(isset($form['Extension']['id'])){
            $options['conditions']['NOT']['Extension.id'] = $form['Extension']['id'];
        }           
        $options['conditions']['Extension.isdeleted'] = 'N';  
        $options['conditions']['Extension.complete_number'] = $form['Extension']['complete_number'];
                          
        $result = $this->find("count", $options);       
        if($result > 0){
            $this->data = $form;
            return false;           
        }else{
            $this->data = $form;
            return true;
        }   
      }  
	
	public $belongsTo = array(
		'Sector' => array(
			'className' => 'Manager.Sector',
			'foreignKey' => 'sector_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}