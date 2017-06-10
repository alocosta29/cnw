<?php
App::uses('Aco', 'Model');
App::uses('ArosAco', 'Manager.Model');
App::uses('Aro', 'Model');
//App::uses('Menugroup', 'Manager.Model');



	class MenuEsquerdoComponent extends Component 
	{				
		public $components = array('Session', 'Manager.AcoData');
		private $menugroup_id = null;
		private $menuEsquerdo = false;
		
	
	
		public function _startMenu($allowActions){
			if($this->_setParameters($allowActions) <> false)
			{
				return $this->_montaMenu();
			}else{
				return false;
			}
		}
		
		/**
		 * Método que montará o menu
		 */
		 public function _montaMenu()
		 {
		 		$Aco = new Aco();	
		 		$Aco->recursive = -1;
		 		$menu = $Aco->find('list', array('conditions'=>
														 		array(
														 		'Aco.menugroup_id'=>$this->menugroup_id,
														 		'Aco.menuEsquerdo'=>'Y',
														 		'NOT'=>array(
														 			'Aco.aliasMenu'=>null,
														 			'Aco.parametro'=>'Y' )),
																'order'=>array('Aco.ordem_menu'=>'ASC')));
			if(!empty($menu)){
				sort($menu);
				for($i=0; $i<sizeof($menu); $i++){
					
					$menu[$i] = $this->AcoData->_returnAcoData($menu[$i]);
				}
				$this->menuEsquerdo = $menu;
			}else{
				return false;
			}
		 }
				
		
		/**
		 * Método público que retornará o menu
		 */
		public function getMenu(){
			return $this->menuEsquerdo;
		}
	
		/**
		 * Método seta o id do menu
		 */
		private function _setParameters($allowActions)
		{
			$Aco = new Aco();
			$Aco->recursive = -1;	
			$listAcos = $Aco->find('first', 
			array(
			'fields'=>array('Aco.menugroup_id'),
			'conditions'=>array(
								'Aco.id'=>$allowActions,
								'NOT'=>array(
										'Aco.menugroup_id'=>NULL,
										'Aco.aliasMenu'=>NULL)
								)
				));
			
			if(!empty($listAcos))
			{
				$this->menugroup_id = $listAcos['Aco']['menugroup_id'];
				return true;
			}else{
				return false;
			}
		}
	
	
	
	
	
	
	
	}