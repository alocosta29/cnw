<?php
/**
 * Esta classe retorna os dados do aco escolhido: nó, plugin, alias, etc...
 * @author André Luís de Oliveira Costa
 *  
 */
App::uses('Aco', 'Model');
class AcoDataComponent extends Component
{
	
	public $components = array('Manager.AcoValidation', 'Session');
	
	/**
	 * Método que retorna a Aco com todos os dados
	 */
	public function _returnAcoData($id)
	{
		$Aco = new Aco();
		$Aco->recursive = -1;
		$aco = $Aco->find('first', 
		array(
		'conditions'=>array('Aco.id'=>$id),
		'fields'=>array('Aco.id', 'Aco.parent_id', 'Aco.aliasMenu', 'Aco.aliasMetodo', 'Aco.menuEsquerdo', 'Aco.menuSuperior', 'Aco.menugroup_id', 'Aco.descricao', 'Aco.alias', 'Aco.module_id', 'Aco.parametro', 'Aco.restrito', 'Aco.ordem_menu'))); 
		$dataAco = $this->_returnFormatAco($aco);
		return $dataAco;
	}
	
	/**
	 * Método que retorna apenas os dados referentes a menu
	 */
	 	
	public function _returnAcoMenu($id)
	{
		$Aco = new Aco();
		$Aco->recursive = -1;
		$aco = $Aco->find('first', 
		array(
		'conditions'=>array('Aco.id'=>$id),
		'fields'=>array('Aco.id', 'Aco.parent_id', 'Aco.aliasMenu', 'Aco.aliasMetodo', 'Aco.menuEsquerdo', 'Aco.menuSuperior', 'Aco.menugroup_id', 'Aco.descricao', 'Aco.alias'))); 

		$dataAco = $this->_returnFormatAco($aco);
		unset($dataAco['Aco']['id']);
		unset($dataAco['Aco']['parent_id']);
		unset($dataAco['Aco']['aliasMetodo']);
		unset($dataAco['Aco']['menuEsquerdo']);
		unset($dataAco['Aco']['menugroup_id']);
		unset($dataAco['Aco']['menuSuperior']);
		unset($dataAco['Aco']['descricao']);
		unset($dataAco['Aco']['alias']);
		return $dataAco;
	}
	
	/**
	 * Método que retorna os dados formatados
	 */
	public function _returnFormatAco($aco)
	{
		$retorno['Aco'] = $aco['Aco'];
		$ControllerPlugin = $this->_returnControllerPlugin($aco['Aco']['parent_id']);
		//$retorno['Aco']['admin']
		
		if(strstr($aco['Aco']['alias'], 'admin_'))
		{
			$action = $aco['Aco']['alias'];	
			$acao = explode('_', $action);
			$retorno['Aco']['admin'] = true;
			$retorno['Aco']['action'] = $acao[1];
		}else{
			$retorno['Aco']['action'] = $aco['Aco']['alias'];
			$retorno['Aco']['admin'] = false;
		}
				
		$retorno['Aco']['plugin']  = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', lcfirst($ControllerPlugin['plugin'])));	
		$retorno['Aco']['controller']  = $ControllerPlugin['controller'];
		if(!empty($aco['Aco']['module_id'])){
			$retorno['Aco']['module_id'] = $aco['Aco']['module_id'];
		}
		return $retorno;
	}
	
	
	/**
	 * Método que retorna controller e plugin, caso tenha
	 */
	 public function _returnControllerPlugin($id)
	 {
	 	$Aco = new Aco();
		$Aco->recursive = -1;
		$aco = $Aco->find('first', 
		array(
		'conditions'=>array('Aco.id'=>$id),
		'fields'=>array('Aco.id', 'Aco.parent_id', 'Aco.alias'))); 
		if($aco['Aco']['alias'] <> 'controllers')
		{
			$retorno['controller'] = lcfirst($aco['Aco']['alias']);	
			
			if($aco['Aco']['parent_id']<> NULL){
			$plugin = $Aco->find('first', 
			array(
			'conditions'=>array('Aco.id'=>$aco['Aco']['parent_id']),
			'fields'=>array('Aco.id', 'Aco.parent_id', 'Aco.alias'))); 
			if($plugin['Aco']['alias'] <> 'controllers')
			{
				$retorno['plugin'] = lcfirst($plugin['Aco']['alias']);
				
			}else{
				$retorno['plugin'] = false;	
				}
			}else{
				$retorno['plugin'] = false;	
			}
		}else{
			$retorno['controller'] = false;
		}
		return $retorno;		
	 }
	
	
	
	
	
	/**
	 * Método que trata os dados para salvar a aco
	 */	
	 public function _trataAcoData($id){
	 	$Aco = new Aco();
		$Aco->recursive = -1;
		$loadAco = $Aco->findById($id);	

		$validation = $this->AcoValidation->_validaData($loadAco);
		if($validation['resposta'] == true)
		{
			$retorno['resposta'] = true;
		}else{
			
			$retorno = $validation;
		}
		return $retorno;

	 }
	




	/**
	 * Método que trata os dados para salvar as configurações da aco pelo superuser
	 */	
	 public function _trataAcoSuperuser($data, $id){
			
			
		$retorno['AcoSuperuser']['id'] = 	$id;
		$retorno['AcoSuperuser']['aliasMetodo'] = 	$data['AcoSuperuser']['aliasMetodo'];
		$retorno['AcoSuperuser']['descricao'] = 	$data['AcoSuperuser']['descricao'];
		$retorno['AcoSuperuser']['module_id'] = 	$data['AcoSuperuser']['module_id'];
		$retorno['AcoSuperuser']['parametro'] = 	$data['AcoSuperuser']['parametro'];
		$retorno['AcoSuperuser']['restrito'] = 	$data['AcoSuperuser']['restrito'];
		
		$Aco = new Aco();
		$Aco->recursive = -1;
		$loadAco = $Aco->findById($id);
		if(empty($loadAco['Aco']['aliasMenu'])){
			$retorno['AcoSuperuser']['aliasMenu']  = $data['AcoSuperuser']['aliasMetodo'];
		}
		
		
		return $retorno;

	 }


	/**
	 * Método que retorna permissão 
	 */
	 public function _retornaSavePermission($permission)
	 {	 	
		if($permission == 'Y'){
				$permission = array('_create'=>1, '_read'=>1, '_update'=>1, '_delete'=>1);	
		}else{
				$permission = array('_create'=>0, '_read'=>0, '_update'=>0, '_delete'=>0);			
		}
		return $permission;
	 }








	
}
