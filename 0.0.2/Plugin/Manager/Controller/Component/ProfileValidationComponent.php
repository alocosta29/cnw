<?php

	App::uses('Individual', 'Manager.Model');

	class ProfileValidationComponent extends Component 
	{				
		public $components = array('Manager.Persona');


		public function _validaDados($data)
		{
		    
			$data['Contact'] = $this->_retornaTypeContact($data['Contact']);
			$validaEmail = $this->_verificaEmail($data['Contact']);
			if($validaEmail == false){
				$retorno['resposta'] = false;
				$retorno['msg'] = 'E-mail inválido';
			}else{
				$retorno['resposta'] = true;
			}
			return $retorno;
		}


		/**
		 * Método que verifica se o e-mail informado esta no formato correto
		 */
		public function _verificaEmail($contactData)
		{
			for($i = 0; $i<sizeof($contactData); $i++)
			{
				if($contactData[$i]['typeAlias'] == 'email'){
					if($this->_validaEmail($contactData[$i]['contato']) == false)
					{
						$retorno[$i] = false;
					}	
				}	
			}
			if(isset($retorno)){
				$retorno = false;
			}else{
				$retorno = true;
			}
			return 	$retorno;
		}
	

		/**
		 * Método que retorna o tipo de contato para validação
		 */
		public function _retornaTypeContact($contactData)
		{
			for($i = 0; $i<sizeof($contactData); $i++)
			{
				$contactData[$i]['typeAlias'] = $this->Persona->_retornaAliasContact($contactData[$i]['contactstype_id']);
			}
			return 	$contactData;
		}

		//Define uma função que poderá ser usada para validar e-mails usando regexp
		public function _validaEmail($email) 
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
		
		/**
		 * Método que retorna os filtros de pesquisa
		 */
		public function _userSearch($busca)
		{
			$params['Person.tipo_pessoa'] = 'F';
			
			if(isset($busca['Person']['nome']) and !empty($busca['Person']['nome']))
			{
				$termo = trim($busca['Person']['nome']);
				$replace_pairs =
				array
				(
					'á' => 'a',
					'é' => 'e',
					'í' => 'i',
					'ó' => 'o',
					'ú' => 'u',
					'à' => 'a',
					'è' => 'e',
					'ì' => 'i',
					'ò' => 'o',
					'ù' => 'u',
					'ã' => 'a',
					'õ' => 'o',
					'â' => 'a',
					'ê' => 'e',
					'î' => 'i',
					'ô' => 'o',
					'ä' => 'a',
					'ë' => 'e',
					'ï' => 'i',
					'ö' => 'o',
					'ü' => 'u',
					'ç' => 'c',
					'Á' => 'A',
					'É' => 'E',
					'Í' => 'I',
					'Ó' => 'O',
					'Ú' => 'U',
					'À' => 'A',
					'È' => 'E',
					'Ì' => 'I',
					'Ò' => 'O',
					'Ù' => 'U',
					'Ã' => 'A',
					'Õ' => 'O',
					'Â' => 'A',
					'Ê' => 'E',
					'Î' => 'I',
					'Ô' => 'O',
					'Û' => 'U',
					'Ä' => 'A',
					'Ë' => 'E',
					'Ï' => 'I',
					'Ö' => 'O',
					'Ü' => 'U',
					'Ç' => 'C'
				);
					$termo = strtr($termo, $replace_pairs);
					$params['Individual.nome LIKE '] = $termo."%";
			}	
			
			if(isset($busca['Person']['username']) and !empty($busca['Person']['username']))
			{
				$termo = trim($busca['Person']['username']);
				$replace_pairs =
				array
				(
					'á' => 'a',
					'é' => 'e',
					'í' => 'i',
					'ó' => 'o',
					'ú' => 'u',
					'à' => 'a',
					'è' => 'e',
					'ì' => 'i',
					'ò' => 'o',
					'ù' => 'u',
					'ã' => 'a',
					'õ' => 'o',
					'â' => 'a',
					'ê' => 'e',
					'î' => 'i',
					'ô' => 'o',
					'ä' => 'a',
					'ë' => 'e',
					'ï' => 'i',
					'ö' => 'o',
					'ü' => 'u',
					'ç' => 'c',
					'Á' => 'A',
					'É' => 'E',
					'Í' => 'I',
					'Ó' => 'O',
					'Ú' => 'U',
					'À' => 'A',
					'È' => 'E',
					'Ì' => 'I',
					'Ò' => 'O',
					'Ù' => 'U',
					'Ã' => 'A',
					'Õ' => 'O',
					'Â' => 'A',
					'Ê' => 'E',
					'Î' => 'I',
					'Ô' => 'O',
					'Û' => 'U',
					'Ä' => 'A',
					'Ë' => 'E',
					'Ï' => 'I',
					'Ö' => 'O',
					'Ü' => 'U',
					'Ç' => 'C'
				);
					$termo = strtr($termo, $replace_pairs);
					$params['User.username LIKE '] = $termo."%";
			}else{
				$params['User.username <> '] = null;
			}		
			
			if(isset($busca['Person']['status']) and ($busca['Person']['status']<>'S')){
				
			
					$params['User.status'] = $busca['Person']['status'];
					
				}else{
					$params['User.status'] = 1;
				}
			if(isset($busca['Person']['cpf']) and !empty($busca['Person']['cpf']))
			{	
				$params['Individual.cpf'] = preg_replace("/[^0-9]/i", "", $busca['Person']['cpf']);
			}

				$options = array(
					"fields"=>array('Person.id', 'Individual.cpf', 'Individual.nome','User.username', 'User.status', 'User.id'),
						"joins" => array(
						              array(
						                        "table" => "individuals",
						                        "type" => "LEFT",
						                        'alias'=>'Individual',
						                        "conditions" => array("Person.id = Individual.person_id")
						                    ),
										 array(
						                        "table" => 'users',
						                        "type" => "LEFT",
						                        'alias'=>'User',
						                        "conditions" => array("Person.id = User.person_id")
						                    )
										), 
						                    "conditions"=>$params,
						                    'order'=>array('Individual.nome'=>'ASC'),
											'limit'=>15
											);
										return $options;
		}
	
		
	}