<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Individual extends ManagerAppModel {
	//public $actsAs = array('Locale.Locale');
	public $validate = array
	(
        'cpf' =>array(
                        'notEmpty' => array(
                                        'rule'=>'notEmpty',
                                        'message' => "Por favor digite seu CPF",
                                           ),
                        'validaCPF' => array(
                                        'rule'    => 'validaCPF',
                                        'message' => 'CPF inválido',
                                       // 'on' => 'create'
                                           ),
                        'isUniqueOptimized' => array(
                                        'rule'    => 'isUniqueOptimized',
                                        'message' => 'Este cpf já foi cadastrado.',
                                        //'on' => 'create'
                                            ),
                        'savestring' => array(
                                        'rule' => array('savestring'),
                                        'message' => 'erro ao salvar o arquivo',
                                            )		
			
                      ),	

	    'nome' =>array(
                        'notEmpty' => array(
                                            'rule'=>'notEmpty',
                                            'message' => "Por favor digite o nome do cliente",
                        )),
	
			
			
		/*	'identidade' =>array(
				'notEmpty' => array(
					'rule'=>'notEmpty',
					'message' => "Por favor digite sua identidade",
				),
		
				'isUniqueIdentidade' => array(
			        'rule'    => 'isUniqueIdentidade',
			        'message' => 'Este rg já foi cadastrado.',
			        'on'=>'create'
			),
			
			'savestringrg' => array(
							'rule' => array('savestringrg'),
							'message' => 'erro ao salvar o arquivo',
			)),*/
			
	/*	'dtnascimento' =>array(
			'savedata'=> array(
					'rule'=>array('savedata'),
					'message' => 'Erro ao acertar formato da data'),
					
			) 
	 */
	 );
	
			public function savestring()
			{
				if(isset($this->data['Individual']['cpf']))
				{
				$this->data['Individual']['cpf'] = preg_replace("/[^0-9]/i", "", $this->data['Individual']['cpf']);
						}
				return true;
			}
			
			
			
			public function savestringrg()
			{
				if(isset($this->data['Individual']['identidade']))
				{
					$this->data['Individual']['identidade'] = preg_replace("/[^0-9]/i", "", $this->data['Individual']['identidade']);
				}
				return true;
			}
			
			
			public function savedata()
			{
			if(!empty($this->data['Individual']['dtnascimento'])){	
			$var = $this->data['Individual']['dtnascimento'];
			$date = str_replace('/', '-', $var);
			$this->data['Individual']['dtnascimento'] = date('Y-m-d', strtotime($date));
			}
			return true;
			}
			
			public function validaCPF() {
 		
			$cpf = $this->data['Individual']['cpf'];
		    // Verifica se um número foi informado
		    if(empty($cpf)) {
		        return false;
		    }
		 
		    // Elimina possivel mascara
		    $cpf = ereg_replace('[^0-9]', '', $cpf);
		    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		     
		    // Verifica se o numero de digitos informados é igual a 11 
		    if (strlen($cpf) != 11) {
		        return false;
		    }
		    // Verifica se nenhuma das sequências invalidas abaixo 
		    // foi digitada. Caso afirmativo, retorna falso
		    else if ($cpf == '00000000000' || 
		        $cpf == '11111111111' || 
		        $cpf == '22222222222' || 
		        $cpf == '33333333333' || 
		        $cpf == '44444444444' || 
		        $cpf == '55555555555' || 
		        $cpf == '66666666666' || 
		        $cpf == '77777777777' || 
		        $cpf == '88888888888' || 
		        $cpf == '99999999999') {
		        return false;
		     // Calcula os digitos verificadores para verificar se o
		     // CPF é válido
		     } else {   
		         
		        for ($t = 9; $t < 11; $t++) {
		             
		            for ($d = 0, $c = 0; $c < $t; $c++) {
		                $d += $cpf{$c} * (($t + 1) - $c);
		            }
		            $d = ((10 * $d) % 11) % 10;
		            if ($cpf{$c} != $d) {
		                return false;
		            }
		        }
		 
		        return true;
		    }
}

			
			
			public function isUniqueOptimized() 
			{
				$form = $this->data;
				$person_id_1 = $this->read('Person_id');
				$person_id = $person_id_1['Individual']['Person_id'];
				
				$result = $this->find("count", array(
			        "conditions" => array(
			        'NOT'=>array('Individual.person_id'=>$person_id),
					'cpf' => preg_replace("/[^0-9]/i", "", $form['Individual']['cpf'])
				)));
				
				if($result == 0){
					$this->data = $form;
					return true;			
				}else{
					$this->data = $form;
					return false;
				}	
			}
			
			public function isUniqueIdentidade()
			{
				
				
				$result = $this->find("count", array(
				        "conditions" => array(
				        'identidade' => preg_replace("/[^0-9]/i", "", $this->data['Individual']['identidade']),
				)));
				if($result == 0){
					return true;
				}else{
					return false;
				}
			}
			
	
	public $belongsTo = array(
		'Person' => array(
			'className' => 'Manager.Person',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
         'User' => array(
            'className' => 'Manager.User',
            //'joinTable' => 'roles_users',
            'foreignKey' => false,
           // 'associationForeignKey' => 'person_id',
            //'dependent' => true,
            'conditions' => array('Individual.person_id = User.person_id'),
            //'conditions' => array(' `User`.`person_id` = `Individual`.`person_id`'),
            'fields' => array('User.username'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        
        
	);
}
	
