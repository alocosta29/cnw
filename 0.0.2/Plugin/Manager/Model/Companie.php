<?php
App::uses('ManagerAppModel', 'Manager.Model');

/**
 * Company Model
 *
 * @property Person $Person
 * @property Individual $Individual
 */
class Companie extends ManagerAppModel{
public $validate = array(
                		'cnpj' =>array(
                						'notEmpty' => array(
                						'rule' => 'notEmpty',
                						'message' => "Por favor digite o CNPJ",
                		              ),
                        'validaCNPJ' => array(
                    					       'rule'    => 'validaCNPJ',
                    					       'message' => 'CNPJ inválido',
                		                       // 'on' => 'create'
                		                      ),
                		'isUniqueOptimized' => array(
                            				         'rule'    => 'isUniqueOptimized',
                            				         'message' => 'Este cnpj já foi cadastrado.',
                            				         'on' =>'create'
                		                              ),
                	    'savestring' => array(
                        						'rule' => array('savestring'),
                        						'message' => 'erro ao salvar o arquivo',
                		                      )),
	                     );

			public function savestring()
			{
				if(isset($this->data['Companie']['cnpj']))
				{
					$this->data['Companie']['cnpj'] = preg_replace("/[^0-9]/i", "", $this->data['Companie']['cnpj']);
				}
				return true;
			}
				
			public function isUniqueOptimized()
			{
				$result = $this->find("count", array(
						        "conditions" => array(
						        'cnpj' => preg_replace("/[^0-9]/i", "", $this->data['Companie']['cnpj']),
				)));
				if($result == 0){
					return true;
				}else{
					return false;
				}
			}
			
			function validaCNPJ()
			{
				
				$cnpj = preg_replace("/[^0-9]/i", "", $this->data['Companie']['cnpj']);
				//Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
				$j=0;
				for($i=0; $i<(strlen($cnpj)); $i++)
				{
				if(is_numeric($cnpj[$i]))
				{
				$num[$j]=$cnpj[$i];
				$j++;
				}
				}
				//Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
				if(count($num)!=14)
				{
				$isCnpjValid=false;
			}
				//Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
				if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
				{
				$isCnpjValid=false;
			}
				//Etapa 4: Calcula e compara o primeiro dígito verificador.
				else
				{
				$j=5;
				for($i=0; $i<4; $i++)
				{
				$multiplica[$i]=$num[$i]*$j;
				$j--;
			}
			$soma = array_sum($multiplica);
			$j=9;
				for($i=4; $i<12; $i++)
				{
				$multiplica[$i]=$num[$i]*$j;
				$j--;
			}
				$soma = array_sum($multiplica);
				$resto = $soma%11;
				if($resto<2)
				{
					$dg=0;
				}
					else
					{
					$dg=11-$resto;
				}
				if($dg!=$num[12])
				{
				$isCnpjValid=false;
			}
			}
			//Etapa 5: Calcula e compara o segundo dígito verificador.
			if(!isset($isCnpjValid))
			{
				$j=6;
				for($i=0; $i<5; $i++)
				{
				$multiplica[$i]=$num[$i]*$j;
				$j--;
				}
				$soma = array_sum($multiplica);
				$j=9;
				for($i=5; $i<13; $i++)
				{
				$multiplica[$i]=$num[$i]*$j;
				$j--;
			}
				$soma = array_sum($multiplica);
				$resto = $soma%11;
					if($resto<2)
					{
					$dg=0;
				}
				else
				{
				$dg=11-$resto;
				}
				if($dg!=$num[13])
				{
				$isCnpjValid=false;
				}
				else
				{
				$isCnpjValid=true;
				}
				}
				//Trecho usado para depurar erros.
				/*
				if($isCnpjValid==true)
				{
					echo "<p><font color=\"GREEN\">Cnpj é Válido</font></p>";
				}
					if($isCnpjValid==false)
					{
					echo "<p><font color=\"RED\">Cnpj Inválido</font></p>";
				}
				*/
				//Etapa 6: Retorna o Resultado em um valor booleano.
				return $isCnpjValid;
				}
	
	public $belongsTo = array(
                        		'Person' => array(
                        			'className' => 'Manager.Person',
                        			'foreignKey' => 'person_id',
                        			'conditions' => '',
                        			'fields' => '',
                        			'order' => ''
                        		      )
	                           );
                               
                               
    /* public $hasOne = array(
        'Person' => array(
            'className' => 'Manager.Person',
            //'foreignKey' => 'person_id',
            'conditions' =>'',
            //'dependent' => true
        )
    );  */                         
                               
                               
                               
                               
}