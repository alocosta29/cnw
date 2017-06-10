<?php
App::uses('Menuiten', 'Manager.Model');
App::uses('Aco', 'Model');
App::uses('ArosAco', 'Manager.Model');
App::uses('Aro', 'Model');
App::uses('Menugroup', 'Manager.Model');

	class MenuSuperiorComponent extends Component 
	{				
		public $components = array('Session');
		
		/**
		 * Método que retorna o aro_id logado
		 */
		public function _retornaAroId()
		{
			$role_id = $this->Session->read('Auth.User.role_id');
			$Aro = new Aro();
			$consultaAro = $Aro->findByForeign_key($role_id);
			return $consultaAro['Aro']['id'];
		}
		
		/**
		 * Método que retorna todas as permissões para o usuaario logado
		 */
		 public function _retornaPermissoes(){
		 	$aro_id  = $this->_retornaAroId();
		
			$ArosAco = new ArosAco();
			$permissionaAcos = 	$ArosAco->find('list', 
			array(
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
		 * Método que retorna odas as actions configuradas e permitidas para o menu superior
		 */
		public function _returnAllItensMenu(){
		$role_id = $this->Session->read('Auth.User.role_id');
		$Aco = new Aco();
		if($role_id <> 1)
		{
			$params['Aco.id'] = $this->_retornaPermissoes();
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
		
		
		
		
		public function retornaMenu()
		{
			$listAcos = $this->_returnAllItensMenu();
			$listMenuPais = $this->_retornaMenuPais($listAcos);
		//	pr($listAcos);
			//exit(0);	
			if($listMenuPais<>false){
				$retorno = $this->_formatMenu($listMenuPais);	
			}else{
				$retorno = false;
			}
			return $retorno;
		}
		
		
		public function _formatMenu($list){
			for($i=0; $i<sizeof($list); $i++)
			{
				$retorno[$i]['id'] = $list[$i]['Menugroup']['id'];
				$retorno[$i]['grupo'] = $list[$i]['Menugroup']['grupo'];
			}
			return $retorno;	
		}
		
		
		/**
		 * Método que retorna menu pais
		 */
		public function _retornaMenuPais($listAcos)
		{
			
			/*if(!empty($listMenuItens)){
			$Menugroup = new Menugroup();
			$Menugroup->recursive = -1;		
			$listGrupoPais = $Menugroup->find('all',
			array(
			'fields'=>array('Menugroup.grupo', 'Menugroup.id'),
			'conditions'=>array(
			'Menugroup.isdeleted'=>'N',
			//'Menugroup.id'=>$listMenuItens,
			'Menugroup.parent_id'=>NULL),
			'order'=>array('Menugroup.ordem'=>'ASC')));
			 $retorno = $listGrupoPais;
			 * */	
				$retorno = $this->_mesclaMenuPais($listAcos);
			
			/*}else{
				$retorno = false;
			}*/
			return $retorno;
		}
		
		
		
		
		/**
		 * Método que mescla menupais
		 */
		 public function _mesclaMenuPais($listAcos)
		 {
		 	$listMenuItens = $this->_listMenuItens($listAcos);
			
		
			if(!empty($listMenuItens)){
					$Menugroup = new Menugroup();
					$Menugroup->recursive = -1;		
					$listGrupoPais1 = $Menugroup->find('all',
					array(
					'fields'=>array('Menugroup.grupo', 'Menugroup.id', 'Menugroup.ordem'),
					'conditions'=>array(
					'Menugroup.isdeleted'=>'N',
					'Menugroup.main_menu'=>'Y',
					'Menugroup.id'=>$listMenuItens,
					'Menugroup.parent_id'=>NULL),
					'order'=>array('Menugroup.ordem'=>'ASC')));	
					
				
					
			
					$listGrupoFilhos = $Menugroup->find('list',
					array(
					'fields'=>array('Menugroup.parent_id', 'Menugroup.parent_id'),
					'conditions'=>array(
					'Menugroup.isdeleted'=>'N',
					'Menugroup.id'=>$listMenuItens,
					'Menugroup.parent_id <>'=>NULL),
					'order'=>array('Menugroup.ordem'=>'ASC')));
				
			
					if(!empty($listGrupoFilhos)){
					$idsMenuPais = $this->menuPaisTreatment($listGrupoPais1);	
				
							
					if($idsMenuPais <> false){
						sort($listGrupoFilhos);	
						$i=0;
						$totalSize = sizeof($listGrupoFilhos);
						while($i<$totalSize){
							if(in_array($listGrupoFilhos[$i], $idsMenuPais))
							{
								unset($listGrupoFilhos[$i]);								
							}	
							$i++;
						}
					}
									
						if(isset($listGrupoFilhos))
						{
									$options = array(
													'fields'=>array('Menugroup.grupo', 'Menugroup.id', 'Menugroup.ordem'),
													'conditions'=>array(
													'Menugroup.isdeleted'=>'N',
													'Menugroup.main_menu'=>'Y',
													'Menugroup.id'=>$listGrupoFilhos,
													'Menugroup.parent_id'=>NULL),
									'order'=>array('Menugroup.ordem'=>'ASC'));	
									$listGrupoPais2 = $Menugroup->find('all', $options);
						}else{
							$listGrupoPais2 = array();
						}

					}else{
						$listGrupoPais2 = array();
					}
		
				}else{
					$retorno = false;
				}
			
			if(!empty($listGrupoPais1) or !empty($listGrupoPais2))
			{
					$retorno = array_merge($listGrupoPais1, $listGrupoPais2);
									
					if(!empty($retorno)){
						foreach ($retorno as $key => $row) {
		  							$filtro[$key]['Menugroup']  = $row['Menugroup']['ordem'];
							}
						array_multisort($filtro, SORT_ASC, $retorno);
						return $retorno;
							
						
					}else{
						return false;
					}	
			}else{
				return false;
			}
		 }
		
		
		
		private function menuPaisTreatment($menuPais)
		{
			if(!empty($menuPais))
			{
				$totalSize = sizeof($menuPais);
				$i=0;
				while($i<$totalSize)
				{
					$ids[$i] =  $menuPais[$i]['Menugroup']['id'];	
					$i++;
				}
				return $ids;
				
			}else{
				return false;
			}
		}
		
				
		
		/**
		 * Método que retorna a lista de menus que pertencem as acos autorizaDAS para determinado perfil.
		 */
		public function _listMenuItens($listAcos){
			$Aco = new Aco();
			$buscaMenu = $Aco->find('list', 
			array(
			'conditions'=>array('Aco.id'=>$listAcos),
			'fields'=>array('Aco.menugroup_id', 'Aco.menugroup_id')));
			if(!empty($buscaMenu))
			{
				sort($buscaMenu);
				$retorno = $buscaMenu;
			}else{
				
				$retorno = false;
			}
			return $retorno;
		}
	
		
		
	

		
	}	
?>