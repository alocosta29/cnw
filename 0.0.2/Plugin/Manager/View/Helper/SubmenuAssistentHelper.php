<?php 
App::uses('AppHelper', 'View/Helper'); 
class SubmenuAssistentHelper extends AppHelper 
{
	
	public $helpers = array('Manager.MenuAssistent');
	
	
	public function _showSubmenu($menugroup_id, $role_id)
	{

		$submenus = $this->_retornaSubmenus($menugroup_id, $role_id);
		if($submenus <> false)
		{
			$retorno = '';
			for($i=0; $i<sizeof($submenus); $i++)
			{
				$retorno .= '<li style="position: static;" class="sfirst"><a class="ajxsub" href="#">'.$submenus[$i]['grupo'].'</a><ul style="display: none;">';
				$retorno .= $this->MenuAssistent->_show($submenus[$i]['menugroup_id']);
				$retorno .= $this->_showSubmenu($submenus[$i]['menugroup_id'], $role_id);
				$retorno .= '</ul>';	
			}
		}else{
			$retorno = '';
		}
		//pr($retorno);
		//exit(0);
		
		return $retorno;
	}	
	
	public function _retornaSubmenus($menugroup_id, $role_id)
	{
		$list_acos = $this->_returnAllItensMenu($role_id);
		$list_menus = $this->_listMenus($list_acos);
		
		if($list_acos <> false and $list_menus <> false)
		{
				//$Menugroup = new Menugroup();
				$Menugroup = ClassRegistry::init('Menugroup');	
				$Menugroup->recursive = -1;
				$buscaMenu = $Menugroup->find('all', 
				array(
				'conditions'=>array(
					'Menugroup.id'=>$list_menus,
					'Menugroup.parent_id'=>$menugroup_id
				),
				'fields'=>array('Menugroup.id', 'Menugroup.grupo'),
				'order'=>array('Menugroup.ordem'=>'ASC')
				));
		
				if(!empty($buscaMenu))
				{
					for($i=0; $i<sizeof($buscaMenu); $i++)
					{
						$retorno[$i]['menugroup_id'] = $buscaMenu[$i]['Menugroup']['id'];
						$retorno[$i]['grupo'] = $buscaMenu[$i]['Menugroup']['grupo'];
					}
				}else{
					$retorno = false;
				}
			}else{
				$retorno = false;
			}	
			return $retorno;
	}
		
	/**
	 * Método que retorna todos os menus não vazios no sistema
	 */
	public function _listMenus($list_acos)
	{
		//$Aco = new Aco();
		$Aco = ClassRegistry::init('Aco');	
		$listMenu = $Aco->find('list', array(
		'fields'=>array('Aco.menugroup_id', 'Aco.menugroup_id'),
		'conditions'=>array(
		'Aco.id'=>$list_acos )));
		if(!empty($listMenu)){
			sort($listMenu);
			$retorno = $listMenu;
		}else{
			$retorno = false;
		}
		return $retorno;
	}
	
		/**
		 * Método que retorna odas as actions configuradas e permitidas para o menu superior
		 */
		public function _returnAllItensMenu($role_id)
		{
			$Aco = ClassRegistry::init('Aco');	
			//$Aco = new Aco();
			if($role_id <> 1)
			{
				$params['Aco.id'] = $this->_retornaPermissoes($role_id);
			}
			$params['Aco.aliasMenu <> '] = NULL;
			$params['Aco.menuSuperior'] = 'Y';	
			$consulta = $Aco->find('list', array('conditions'=>$params));
			if(!empty($consulta))
			{
				sort($consulta);
				$retorno  =$consulta;
			}else{
				$retorno  =false;
			}
			return $retorno;
		}
		/**
		 * Método que retorna todas as permissões para o usuaario logado
		 */
		 public function _retornaPermissoes($role_id){
		 	$aro_id  = $this->_retornaAroId($role_id);
			//$ArosAco = new ArosAco();
			$ArosAco = ClassRegistry::init('ArosAco');
			$permissionaAcos = 	$ArosAco->find('list', array(
			'fields'=>array('ArosAco.aco_id', 'ArosAco.aco_id'),
			'conditions'=>array(
			'ArosAco.aro_id'=>$aro_id,
			'ArosAco._create'=>1,
			'ArosAco._read'=>1,
			'ArosAco._update'=>1,
			'ArosAco._delete'=>1)));
			if(!empty($permissionaAcos)){
				sort($permissionaAcos);
				$retorno = $permissionaAcos;
			}else{
				$retorno = false;
			}
			return $retorno;
		 }

		/**
		 * Mértodo que retorna a id do aro logado
		 */
		public function _retornaAroId($role_id)
		{
			$Aro = ClassRegistry::init('Aro');	
			//$Aro = new Aro();
			$consultaAro = $Aro->findByForeign_key($role_id);
			return $consultaAro['Aro']['id'];
		}

	
	
	
	
	
	
	
}
	