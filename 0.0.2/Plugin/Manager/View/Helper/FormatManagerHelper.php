<?php 
App::uses('AppHelper', 'View/Helper'); 
class FormatManagerHelper extends AppHelper 
{
		/**
		 * Formata com mascara. Útil para cpf e outros documentos...
		 * @tutorial ex: $this->FormatManager->mask($dadosEmployee['cpf'],'###.###.###-##');
         * cnpj: $this->Complement->mask($dadosEmployee['cnpj'],'##.###.###/####-##');
		 */	
		public function _mask($val, $mask)
		{
			$maskared = '';
			$k = 0;
			for($i = 0; $i<=strlen($mask)-1; $i++)
			{
				if($mask[$i] == '#')
				{
					if(isset($val[$k]))
					$maskared .= $val[$k++];
				}else{
					if(isset($mask[$i]))
					$maskared .= $mask[$i];
				}
			}
			return $maskared;
		}

        /**
         * Método que retorna o status
         */
         public function getStatus($status){
             if($status == 'Y')
             {
                 return '<span style = "color:#006400; font-weight:bold; ">ATIVO</span>';
             }else{
                 return '<span style = "color:#8B0000; font-weight:bold; ">INATIVO</span>'; 
             }
         }

        /**
         * Método que retorna Sim/Não
         */
         public function getYesNo($status){
             if($status == 'Y'){
                 return '<span style = "color:#006400; font-weight:bold; " >SIM</span>';
             }else{
                 return '<span style = "color:#8B0000; font-weight:bold; " >NÃO</span>'; 
             }
         }

		/**
		 * Método que transforma um numero decimal qualquer em formato moeda real
		 * @tutorial $dindinFormatado = $this->FormatManager->_formataReal($dindin);	
		 */
		public function _formataReal($valor)
		{
			$valorFormatado = 'R$ '.str_replace('.', ',', $valor);	
			return $valorFormatado;
		}
		
		/**
		 * Método que retorna o nome da pessoa física 
		 * @tutorial echo $this->FormatManager->_returnName(9);	
		 */		
		public function _returnName($person_id)
		{
			$Individual = ClassRegistry::init('Manager.Individual');
			$name = $Individual->find('first', array('conditions'=>array('Individual.person_id'=>$person_id)));
			if(isset($name['Individual']['nome']) and !empty($name['Individual']['nome'])){
				return $name['Individual']['nome'];
			}else{
				return '';
			}
		}


        public function getTypeContact($id = null)
        {
          $Contactstype = ClassRegistry::init('Manager.Contactstype');    
          $type =  $Contactstype->findById($id);
           if(!empty($type)){
               return $type['Contactstype']['label'];
           }
        }    

		/**
		 * Método que retorna o nome do usuário
		 */
		public function _returnUser($user_id)
		{	
			$User = ClassRegistry::init('Manager.User');	
			$username = $User->findById($user_id);
			if(!empty($username)){
				$name = '<font color = "green">'.$username['User']['username'].'</font>'; 
			}else{
				$name = '';
			}
			return $name;
		}
		
		/**
		 * Método que retorna o nome do módulo, pelo id
		 */
		public function _returnModule($module_id)
		{	
			$Module= ClassRegistry::init('Manager.Module');	
			$moduleName= $Module->findById($module_id);
			if(!empty($moduleName))
			{
				$name = $moduleName['Module']['nome']; 
			}else{
				$name = '';
			}
			return $name;
		}
				
		/**
		 * Método que retorna o tipo de permissão no sistema
		 */
		public function _consultaPermissaoSistema($user_id)
		{			
			$RolesUser = ClassRegistry::init('RolesUser');
			$consulta = $RolesUser->findByUser_id($user_id);
			if(!empty($consulta)){
				$retorno = $this->_retornaRoleName($consulta['RolesUser']['role_id']);
			}else{
				$retorno = '<font color = "red">S/permissão neste sistema</font>';
			}
			return $retorno;
		}
		
	    /**
		 * Método que retorna o nome do grupo
		 */
		public function _retornaRoleName($role_id)
		{
			$Role = ClassRegistry::init('Role');
			$consulta = $Role->findById($role_id);
			if(!empty($consulta)){
				if(!empty($consulta['Role']['role']))
				{
					$retorno = $consulta['Role']['role'];
				}else{
					$retorno = $consulta['Role']['alias'];
				}	
			}else{
				$retorno = '';
			}
			return $retorno;
		}
		
		/**
		 * Método que limita a exibição em X caracteres
		 */
		public function limitTexto($Texto,$Tamanho){
  			return (strlen($Texto) > $Tamanho) ? substr($Texto, 0, $Tamanho) . '...' : $Texto;
		}
        
		/**
		 * Método que retorna sim/não
		 */
		 public function getLabelSingleData($data)
		 {
		 	if($data == 'Y' or $data == '1')	
			{
				return 'Sim';
			}else{
				return 'Não';
			}
		 }
         
         
         /**
          * Método que retorna o sexo 
          */
         public function getSex($sex = null)
         {
            if($sex == 'M'){
                $sex = 'Masculino';
            }elseif($sex == 'F'){
                $sex = 'Feminino';
            }
             return $sex;
         
         }
         
         
         
         
         
         
}