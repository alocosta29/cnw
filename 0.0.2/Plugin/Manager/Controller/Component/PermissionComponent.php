<?php
App::uses('ArosAco', 'Manager.Model');



	class PermissionComponent extends Component 
	{
		var $components = array('Auth', 'Acl', 'Acl.AclReflector', 'Session', 'Manager.AclManager');	
	
	

		public function _modificarPermissao($params)
		{
				
			$ArosAco = new ArosAco();	
			//este metodo cria ou retira permissão, caso não exista, ao nivel e ação selecionado
			$aco_id = $params['aco_id'];
			$aro_id = $params['aro_id'];
			if($params['acao'] == 'grant')
			{
				$consultaPermission = $ArosAco->find('all', 
				array('conditions'=>array(
				'ArosAco.aco_id'=>$aco_id,
				'ArosAco.aro_id'=>$aro_id
				),
				'fields'=>array('ArosAco.id')
				));	
				return $consultaPermission;
				
			}
			elseif($params['acao'] == 'notGrant')
			{

			}
			else
			{
				return false;
			
			}
		}
		
		
		/**
		 * Método que verifica se ja existe permissão cadastrada
		 */
		 public function _verificaPermission($aro_id, $aco_id)
		 {
		 		$ArosAco = new ArosAco();
		 		$consultaPermission = $ArosAco->find('first', 
				array('conditions'=>array(
				'ArosAco.aco_id'=>$aco_id,
				'ArosAco.aro_id'=>$aro_id
				),
				'fields'=>array('ArosAco.id')
				));	
				if(!empty($consultaPermission)){
					$retorno = $consultaPermission['ArosAco']['id'];
				}else{
					$retorno = false;
				}
			return $retorno;
		 }
		
		
		
		
		
		
		
}