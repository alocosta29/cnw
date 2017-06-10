<?php
App::uses('Configmail', 'Manager.Model');

	class RemetenteComponent extends Component 
	{				
		private $Configmail = null;


	public function __construct()
		{	
			$this->Configmail = new Configmail();
		}
	
	
	public function _retornaRemetente()
	{
		$rem = $this->Configmail->find('all', 
	    array(	'conditions'=>array('Configmail.isdeleted'=>'N'),
	    		'order'=>array('Configmail.id'=>'desc'),
	    		'limit'=> 1 ));	
		$remetente = $rem[0]['Configmail'];
		return $remetente;	
	}
	
		public function _retorna_host()
		{
			if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
				$host['protocolo'] = 'https';
			} else {
				$host['protocolo'] = 'http';
			}
				$host['host'] = $_SERVER['HTTP_HOST'];
				$host['app'] = str_replace('webroot/index.php', '', $_SERVER['SCRIPT_NAME']); ;
				$host_completo = $host['protocolo'].'://'.$host['host'].$host['app'];
			return $host_completo;
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	}	