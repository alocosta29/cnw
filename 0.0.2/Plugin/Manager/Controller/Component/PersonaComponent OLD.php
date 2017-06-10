<?php
App::uses('Contactstype', 'Manager.Model');
App::uses('Person', 'Manager.Model');
App::uses('RolesUser', 'Manager.Model');
App::uses('Individual', 'Manager.Model');

	class PersonaComponent extends Component 
	{				

		
		public function listatipoContacts()
		{	
			/*
			 * Método que lista os tipos de contatos cadastrados
			 */	
		 	$Contactstype = new Contactstype();
			$tipocontact = $Contactstype->find('all');
			return $tipocontact; 	
		}
		

		
		public function visualizePerson($id) 
		{
			/* Método que retorna os dados da pessoa física ou jurídica
			 * retorna também os tipos de contato existentes e a permissão que
			 * a entidade selecionada possui no sistema
			 */	
		 	$Person = new Person();
			$Person->id = $id;
			if (!$Person->exists()) {
				return false;
			}else{
				$return['person'] = $Person->read(null, $id);
				if(!empty($return['person']['User'][0]['id']))
				{
					$RolesUser = new RolesUser();	
					$permissionUser = $RolesUser->find('all', array('conditions'=>array('user_id' => $return['person']['User'][0]['id'])));
					if(!empty($permissionUser))
					{
						$return['permission'] = $permissionUser;
					}
					else
					{
						$return['permission'] = false;
					}
				}
				else
				{
					$return['permission'] = false;	
				}
					
				$return['tipecontact'] =  $this->listatipoContacts();	
				return $return;
			}		
		}
		
		
		
		
		public function IndividualSearch($busca)
		{
			/*
			 * Método que concatena os parâmetros de consulta para pessoa física
			 */	
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
					$params['conditions']['or']['Individual.nome LIKE '] = "%".$termo."%";
			}	
				
			if(isset($busca['Person']['cpf']) and !empty($busca['Person']['cpf']))
			{	
				$params['conditions']['or']['Individual.cpf'] = preg_replace("/[^0-9]/i", "", $busca['Person']['cpf']);
			}
				
				if(isset($params)) :
		
					return $params;

				endif;
	
				
		}
	
	
		public function CompanieSearch($busca)
		{
				/*
				 * Método que concatena os parâmetros de consulta para pessoa jurídica
				 */	
		    	//$companie = $this->Companie->find("all");
				//return $companie;
				
				if(isset($busca['Person']['r_social']) and !empty($busca['Person']['r_social']))
				{
					$termo = trim($busca['Person']['r_social']);
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
						$params['conditions']['or']['Companie.r_social LIKE '] = "%".$termo."%";
				}	
				
				if(isset($busca['Person']['fantasia']) and !empty($busca['Person']['fantasia']))
				{
					$termof = trim($busca['Person']['fantasia']);
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
						$termof = strtr($termof, $replace_pairs);
						$params['conditions']['or']['Companie.fantasia LIKE '] = "%".$termof."%";
				}	
				
			if(isset($busca['Person']['cnpj']) and !empty($busca['Person']['cnpj']))
			{	
				$params['conditions']['or']['Companie.cnpj'] = preg_replace("/[^0-9]/i", "", $busca['Person']['cnpj']);
			}
				
			if(isset($params)):
				return $params;
			endif;				
		}
	
	
		/**
		 * Método que consultará se o cpf é válido e se existe o mesmo na base de dados 
		 */
		 public function _consultaCpf($cpf)
		 {
		 	$cpf = preg_replace("/[^0-9]/i", "", $cpf);	
		 	$verificaCpf = $this->_validaCPF($cpf);
			if($verificaCpf == true)
			{
				$retorno = $this->_verificaExistencia($cpf);	
				
			}else{
				$retorno['msg'] = 'CPF inválido';
			}
			return $retorno;
		 }
	
	
		/**
		 * Método que verifica se o cpf pesquisado existe no banco de dados
		 */
		public function _verificaExistencia($cpf)
		{
			$Individual = new Individual();	
			$verificaExistencia = $Individual->find('first', array('conditions'=>array('Individual.cpf'=>$cpf)));
			if(!empty($verificaExistencia))
			{
				$retorno['resposta'] = true;
				$retorno['person_id'] = $verificaExistencia['Individual']['person_id'];
			}else{
				$retorno['resposta'] = false;
			}
			return $retorno;
		}
	
		/**
		 * Método que verifica a validade do cpf informado
		 */
		public function _validaCPF($cpf) 
		{
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
    
		/**
	 * Método que retorna o name(tipo) do contato
	 */
		public function _retornaAliasContact($id)
		{
			$Contactstype = new Contactstype();
			$tipocontact = $Contactstype->findById($id);
			if(!empty($tipocontact)){
				return $tipocontact['Contactstype']['tipo'];
			}else{
				return false;
			}
			
		}
	

		
	}		