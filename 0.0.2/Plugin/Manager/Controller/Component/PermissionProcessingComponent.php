<?php
App::uses('ArosAco', 'Manager.Model');
App::uses('AcoAdmin', 'Manager.Model');
App::uses('Module', 'Manager.Model');
App::uses('Model', 'Model');

	class PermissionProcessingComponent extends Component 
	{
		private $aroId = NULL;
		private $acoPermissions = null;
		private $acoNotPermissions = null;
		private $modules = null;
		private $role_id = null;
		private $acoCompletePermissions = null;
		
		public function loadPermissions($aroId, $role_id)
		{
			$this->aroId = $aroId;
			$this->role_id = $role_id;
			$this->setAcoPermissions();
			$this->setAcoNotPermissions();
			$this->setModules();
		}
		
		/**
		 * Método que seta os módulos cadastrados no sistema
		 */
		private function setModules()
		{
			$Module = new Module();	
			$Module->recursive = -1; 
			$listModule = $Module->find('all', array(
			'fields'=>array('Module.id', 'Module.nome', 'Module.alias'),
			'conditions'=>array(
			'Module.isdeleted'=>'N'),
			'order'=>array('Module.nome'=>'ASC')
			));
			if(!empty($listModule)){
				$this->modules = $listModule;
				return true;
			}else{
				return false;
			}
		}
		
		/**
		 * Método que seta as permissões para o grupo selecionado
		 */
		private function setAcoPermissions()
		{
			$ArosAco = new ArosAco();	
			$options['fields'] = array('AcoAdmin.id', 'AcoAdmin.id');
								
			$options['conditions']['ArosAco.aro_id'] = $this->aroId;
			$options['conditions']['ArosAco._create'] = 1;
			$options['conditions']['ArosAco._read'] = 1;
			$options['conditions']['ArosAco._update'] = 1;
			$options['conditions']['ArosAco._delete'] = 1;
			
			$options['conditions']['NOT']['AcoAdmin.module_id <= '] = 0;
			$options['conditions']['NOT']['AcoAdmin.aliasMetodo'] = null;
						
			$options['joins'][0]['table'] = 'acos';
			$options['joins'][0]['alias'] = 'AcoAdmin';
			$options['joins'][0]['type'] = 'LEFT';
			$options['joins'][0]['conditions'] = array("ArosAco.aco_id = AcoAdmin.id ");
		
			$listAcos = $ArosAco->find('list', $options);
	
			if(!empty($listAcos))
			{
				sort($listAcos);
				$this->acoPermissions = $listAcos;
				$this->setAcoCompletePermissions();
				return true;
			}else{
				return false;
			}	
		}

		/**
		 * Método que seta os acos com informações completas
		 */
		private function setAcoCompletePermissions()
		{
			$AcoAdmin = new AcoAdmin();
			$AcoAdmin->recursive = -1;
			$listAcos = $AcoAdmin->find('all', 
				array(
				'fields'=>array('AcoAdmin.id', 'AcoAdmin.module_id', 'AcoAdmin.aliasMenu', 'AcoAdmin.descricao'),
				'conditions'=>array('AcoAdmin.id'=>$this->acoPermissions)));
			if(!empty($listAcos)){
				$this->acoCompletePermissions = $listAcos;
			}	
			return true;	
		}
		
		/**
		 * Método que seta as acos não permitidas para o grupo selecionado
		 */
		private function setAcoNotPermissions()
		{
			$ArosAco = new ArosAco();
			$ArosAco->recursive = -1;
			$consulta = array(
			'fields'=>array('AcoAdmin.aliasMenu', 'AcoAdmin.descricao', 'AcoAdmin.module_id', 'AcoAdmin.id'),
				'conditions'=>array(
									'NOT'=>array(
									'AcoAdmin.module_id <= '=> 0,
									'AcoAdmin.aliasMetodo'=> null,
									'AcoAdmin.id'=>$this->acoPermissions
									)));
			if($this->role_id <> 1){
				$consulta['conditions']['AcoAdmin.restrito'] = "N";
			}
			$AcoAdmin = new AcoAdmin();
			$AcoAdmin->recursive = -1;
			$listAcos = $AcoAdmin->find('all', $consulta);
			if(!empty($listAcos)){
				sort($listAcos);
				$this->acoNotPermissions = $listAcos;
				return true;
			}else{
				return false;
			}	
		}
		
		
		/**
		 * Método que retorna os modulos
		 */
		public function getModules()
		{
			return $this->modules;
		}
		
		/**
		 * Método que retorna as acos permitidas
		 */
		public function getAcoPermission()
		{	
			return $this->acoCompletePermissions;
		}
		
		/**
		 * Método que retorna as acos não permitidas
		 */
		public function getAcoNotPermission()
		{
			return $this->acoNotPermissions;
		}		
}			