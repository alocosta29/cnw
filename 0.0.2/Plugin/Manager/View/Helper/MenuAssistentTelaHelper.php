<?php 
App::uses('AppHelper', 'View/Helper'); 
class MenuAssistentTelaHelper extends AppHelper 
{
	
	public $helpers = array('Manager.AclLink');
	
	public function _show($menugroup_id)
	{
		$actions = $this->_carregaActions($menugroup_id);
		return $actions;
	}

	public function _carregaActions($menugroup_id)
	{
		$Aco = ClassRegistry::init('Aco');	
		$Aco = new Aco();
	
		//$params['order'] = 'Y';		
		$Aco->recursive = -1;
		$consulta = $Aco->find('all', 
		array(
		'conditions'=>array('Aco.menugroup_id'=>$menugroup_id,
		'Aco.menuSuperior'=>'Y'
		
		),
		'order'=>array('Aco.ordem_menu'=>'ASC')
		));
		
		if(!empty($consulta)){
		
			$retorno = '';
			for($i=0; $i<sizeof($consulta); $i++){
				$param[$i] = $this->_returnFormatAco($consulta[$i]);
				$retorno .= '<li style="list-style:none">'.
				$this->AclLink->link($param[$i]['Aco']['link'], array('plugin'=>$param[$i]['Aco']['plugin'], 
				'controller'=>$param[$i]['Aco']['controller'], 'action'=>$param[$i]['Aco']['action'], 'admin'=>$param[$i]['Aco']['admin']))
				.'</li>';
			}
		}else{
			$retorno = false;
		}
		return $retorno;
	}
	/**
	 * Método que retorna os dados formatados
	 */
	public function _returnFormatAco($aco)
	{
		//$retorno['Aco'] = $aco['Aco'];
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
		if($ControllerPlugin['plugin'] <> false){		
		$retorno['Aco']['plugin']  = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', lcfirst($ControllerPlugin['plugin'])));	
		}else{
		$retorno['Aco']['plugin'] = false;	
			
		}	
		$retorno['Aco']['controller']  = $ControllerPlugin['controller'];
		$retorno['Aco']['link']  = $aco['Aco']['aliasMenu'];
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
	 	$Aco = ClassRegistry::init('Aco');	
	 	$Aco = new Aco();
		$Aco->recursive = -1;
		$aco = $Aco->find('first', 
		array(
		'conditions'=>array('Aco.id'=>$id),
		'fields'=>array('Aco.id', 'Aco.parent_id', 'Aco.alias'))); 

		if(isset($aco['Aco']['alias']) and $aco['Aco']['alias'] <> 'controllers')
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
	 * Método que retorna o nome do grupo de menu
	 */
	public function getMenu($menugroup_id)
	{
		$Menugroup = ClassRegistry::init('Manager.Menugroup');	
	 	$Menugroup = new Menugroup();		
		$group = $Menugroup->findById($menugroup_id);	
		if(!empty($group)){
			return $group['Menugroup']['grupo'];
		}else{
			return null;
		}	
	}		
	
	
	
	
	
	
	
	
	
	
}			