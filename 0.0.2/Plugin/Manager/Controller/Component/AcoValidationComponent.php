<?php
/**
 * Esta classe retorna os dados do aco escolhido: nó, plugin, alias, etc...
 * @author André Luís de Oliveira Costa
 * 
 */
App::uses('Aco', 'Model');
class AcoValidationComponent extends Component
{
	public $components = array('Session');
	
	
########## Métodos que validam os dados da configuração de menu ################	
	/**
	 * Método quem valida os dados da aco
	 */
	 public function _validaData($data)
	 {
	 	$verificaApelidoProgramador = $this->_confereApelidoProgramador($data);		
		if($verificaApelidoProgramador['resposta'] == true)
		{
			$verificaApelidoMenu = $this->_confereExistenciaParametro($data);
			if($verificaApelidoMenu['resposta'] == true)
			{
				$retorno  = $verificaApelidoMenu;	
			}else{
				$retorno  = $verificaApelidoMenu;
			}
		}else{
			$retorno = $verificaApelidoProgramador;
		}
		return $retorno;
	 }
		
			/**
			 * Método que verifica se o apelido do menu e]foi preenchido
			 */
			public function _confereExistenciaParametro($data)
			{
				if($data['Aco']['parametro'] == 'Y')
				{
					$retorno['resposta'] = false;
					$retorno['msg'] = 'O método não pode ser item de menu, pois recebe parâmetros variáveis';
					
				}else{
					$retorno['resposta'] = true;
				}		
				return $retorno;
				
			}
	

		/**
		 * Método que confere se existe apelidos cadastrado
		 */
		public function _confereApelidoProgramador($data)
		{
			$role_id = 	$this->Session->read('Auth.User.role_id');
			if($role_id == 1){
				if(empty($data['Aco']['aliasMetodo']))
				{
					$retorno['resposta'] = false;
					$retorno['msg'] = 'O apelido do método dado pelo programador não pode estar vazio.';
				}else{
					$retorno['resposta'] = true;	
				}				
			}else{
				$retorno['resposta'] = true;
			}
			return $retorno;
		}
		
########## Fim de Métodos que validam os dados da configuração de menu ################			
		
########## Métodos que validam os dados da configuração da aco(Config do superuser) ################		
		
		public function _valida(){}
		
		
		
		
		
		
		
########## Fim de métodos que validam os dados da configuração da aco(Config do superuser) ################	
		
		
		
}