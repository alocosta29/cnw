<?php 
App::uses('AppHelper', 'View/Helper'); 
//App::uses('HtmlHelper', 'View/Helper');
class AclLinkHelper extends AppHelper 
{
	
public $helpers = array('Html', 'Session', 'Form');
	
		/**
		 * Método que subscreve o método link do Html.
		 * Só retorna as actions caso o usuário possua permissão.
		 * @tutorial 
		 * Forma de uso
		 * $title -> Nome do link ->  Se for null, ele retornará como label o apelido na tabela aco.  
		 * $plugin-> Nome do plugin, caso deixe vazio ele pegara o plugin do rquest. caso o do request esteje vazio, ele não criará o link com plugin 
		 * $controller-> nome do controller. caso esteje vazio ele pegará o controller do request
		 * $action->Nome da action. caso esteja vazia ele pegará a index 
		 * $parametro='', 
		 * $admin=''
		 */
		
		public function link($title = null, $url, $options = array())
		{
			$buscapermission = $this->_verificaPermission($url);
			if($title == null){
				if(isset($buscapermission['apelido']) and !empty($buscapermission['apelido']))
				{
					$title = $buscapermission['apelido'];
				}else{
					$title = 'Desconhecido';
				}
			}	
			
			if(isset($buscapermission['permission'])){
				if($this->Session->read('Auth.User.role_id') == 1)
				{
					$buscapermission['permission'] = true;
				}
				if($buscapermission['permission'] == true){
					$link = $this->Html->link($title, $url, $options);
				}else{
					$link = '';
				}
			}else{
				$link = $buscapermission['msg'];
			}
			return $link;
		}
		
		
		
		public function _verificaPermission($url)
		{
			
			if(!isset($url['plugin']))
			{
				if($this->params['plugin'] == ''){
					$plugin = false;
				}else{
					$plugin = $this->params['plugin'];
				}
			}else{
				$plugin = $url['plugin'];
			}	
			
			if(!isset($url['controller'])){
				$controller = $this->params['controller'];
			}else{
				$controller = $url['controller'];
			}
			
			if(!isset($url['action'])){
				$action = 'index';
			}else{
				if(strstr($url['action'],"?"))
				{
					 $tmp = explode('?', $url['action']);  
					 $action = $tmp[0];
				}else{
					$action = $url['action'];
				}
			}
			
			if(!isset($url['admin'])){
				$admin = $this->params['admin'];;
			}else{
				$admin = $url['admin'];
			}
			
			if($admin == true){
				$actionBusca = 'admin_'.$action;
			}else{
				$actionBusca = $action;
			}
			$buscapermission = $this->_buscarPermission($plugin, $controller, $actionBusca);
			return $buscapermission;	
		}
		
		/**
		 * Retornma o formato do nome do plugin do jeito que esta formatado no BD
		 */
		public function pluginNameTreatment($pluginName)
		{
			if(strpos($pluginName, "_"))
			{
				$newName = explode('_', $pluginName);
				$i = 0;
				$totalSize = sizeof($newName);
				while($i < $totalSize){
					$newName[$i] = ucfirst($newName[$i]);	
					$i++;
				}
				$newName = implode('', $newName);
				return $newName;
			}else{
				return $pluginName;
			}
		}
		
		public function _buscarPermission($plugin, $controller, $action)
		{						
			$aco = ClassRegistry::init('Aco');
			//testa se existe plugin válido
			if($plugin <> false)
			{
				$plugin = $this->pluginNameTreatment($plugin);
				$pluginName = $aco->find('list', array('conditions'=>array('alias'=>$plugin,
				'parent_id'=> 1 )));
				if(!empty($pluginName)){
					sort($pluginName);
					$plugin_id =  $pluginName[0];	
					$params['Aco.parent_id'] = $plugin_id;
				}
			}else{
				$params['Aco.parent_id'] = 1;
			}
					
			//Busca a id do controller
			$controller = ucfirst($controller);
			$params['alias'] = $controller;
			$controller_id = $aco->find('list',array('conditions'=>$params));
			
			if(!empty($controller_id)){
					sort($controller_id);
					$controller_id =  $controller_id[0];
				}else{
					$controller_id =  false;
				}
			
			if($controller_id <> false)
			{
				$action_params['Aco.alias'] = $action;	
				$action_params['Aco.parent_id'] = $controller_id;
				$action_id = $aco->find('all',array('conditions'=>$action_params));
				
				if(!empty($action_id))
				{
					//sort($action_id);
					$retorno['apelido'] = $action_id[0]['Aco']['aliasMenu'];
					$arosAco = ClassRegistry::init('ArosAco');
					$aco_id = $action_id[0]['Aco']['id'];
					$aro_id = $this->_retornaAro();
					//$aro_id = 3;
					$permission = $arosAco->find('list', array('conditions'=>array(
					'ArosAco.aro_id'=>$aro_id,
					'ArosAco.aco_id'=>$aco_id,
					'ArosAco._create'=> 1,
					'ArosAco._read'=> 1,
					'ArosAco._update'=> 1,
					'ArosAco._delete'=> 1 )));
					
					if(!empty($permission))
					{
						$retorno['resposta'] = true;
						$retorno['permission'] = true;
						
					}else{
						$retorno['permission'] = false;
					}
				}else{
					$retorno['resposta'] = false;
					$retorno['msg'] = 'Action desconhecida';
				}
			}else{
				$retorno['resposta'] = false;
				$retorno['msg'] = 'Controller desconhecido';
			}
	
			return $retorno;		
		}


		/**
		 * Método que retorna a id aro do usuario logado
		 */
		public function _retornaAro(){
			$role_id = $this->Session->read('Auth.User.role_id');
			$aro = ClassRegistry::init('Aro');
			$id_aro = $aro->find('list',array('conditions'=>array('Aro.foreign_key'=>$role_id)));
			sort($id_aro);
			return $id_aro[0];
			
		}
	


		/**
		 * Método que cospe o postlink na view se o mesmo possui permissão
		 */
		public function postLink($title = null, $url, $options = array(), $confirmMessage = false)
		{
			$buscapermission = $this->_verificaPermission($url);
			if($title == null){
				if(isset($buscapermission['aliasMenu']) and !empty($buscapermission['aliasMenu']))
				{
					$title = $buscapermission['aliasMenu'];
				}else{
					$title = 'Desconhecido';
				}
			}	
	
	
			
			if(isset($buscapermission['permission'])){
				if($this->Session->read('Auth.User.role_id') == 1)
				{
					$buscapermission['permission'] = true;
				}
				if($buscapermission['permission'] == true){
					//$link = $this->Html->link($title, $url, $options);
					$link =  $this->Form->postLink($title, $url, $options, $confirmMessage);
					
					//postLink(string $title, mixed $url = null, array $options = array (), string $confirmMessage = false)
				}else{
					$link = '';
				}
			}else{
				$link = $buscapermission['msg'];
			}

			return $link;
		}

}
