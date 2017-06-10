<?php
/**
 * Esta classe retorna os dados do aco escolhido: nó, plugin, alias, etc...
 * @author André Luís de Oliveira Costa
 *  
 */
App::uses('Aco', 'Model');
App::uses('ArosAco', 'Manager.Model');
App::uses('Aro', 'Model');
class MenuTesteComponent extends Component
{
	
	
	
	
	
	
	
	public function _showSubmenu($menugroup_id, $role_id)
	{
			
		$submenus = $this->_retornaSubmenus($menugroup_id, $role_id);
			pr($submenus);
			exit(0);
		
		
		return $submenus;
	}	
			
		
	
	
	
	public function _retornaSubmenus($menugroup_id, $role_id)
	{
		$list_acos = $this->_returnAllItensMenu($role_id);
		$list_menus = $this->_listMenus($list_acos);
		
		if($list_acos <> false and $list_menus <> false)
		{
				$Menugroup = new Menugroup();
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
		$Aco = new Aco();
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

			$Aco = new Aco();
			if($role_id <> 1)
			{
				$params['Aco.id'] = $this->_retornaPermissoes($role_id);
			}
			$params['Aco.aliasMenu <> '] = NULL;
			$params['Aco.menuSuperior'] = 'Y';	
			
			$consulta = $Aco->find('list', array('conditions'=>$params));
			if(!empty($consulta)){
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
			$ArosAco = new ArosAco();
			$permissionaAcos = 	$ArosAco->find('list', array(
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
			//$Aro = ClassRegistry::init('Aro');	
			$Aro = new Aro();
			
			$consultaAro = $Aro->findByForeign_key($role_id);
			return $consultaAro['Aro']['id'];
		}






















}	