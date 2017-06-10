<?php 
/**
 * Henrique R. Melo
 * data: 11-06-2013
 * Configuracoes realizadas por ambiente, conforme abaixo.
 */
/*	if(!isset($_SERVER['REQUEST_URI'])) $_SERVER['REQUEST_URI'] = 'ambienteBake'; #SeNaoExistir 'REQUEST_URI', entao esta no bake.
 	if(!isset($_SERVER['HTTP_HOST'])) $_SERVER['HTTP_HOST'] = 'ambienteBake'; #SeNaoExistir 'HTTP_HOST', entao esta no bake.

 	$url_partes = explode('/', $_SERVER['REQUEST_URI']);

    if( ($_SERVER['HTTP_HOST'] == 'sistemas.virtualtelecom.com.br') and ( 
            ($url_partes[1] == 'financeiro') or
            ($url_partes[1] == 'sgp')
        )){ #Servidor de Producao
		$plugin_db = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => 'localhost',
			'login' => 'coreTheOyster',
			'password' => 'coreTheOyster',
			'database' => 'coreTheOyster',
			'encoding' => 'utf8'
		);
        $layout_css = 'padrao.css';
    }elseif(($_SERVER['HTTP_HOST'] == '192.168.200.225') and (
            ($url_partes[1] == 'financeiro') or
            ($url_partes[1] == 'sgp')
        )){ #Servidor de Producao
		$plugin_db = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => 'localhost',
			'login' => 'coreTheOyster',
			'password' => 'coreTheOyster',
			'database' => 'coreTheOyster',
			'encoding' => 'utf8'
		);
    	$layout_css = 'ambiente_de_testes.css';
    }else{ #Ambiente de Desenvolvimento
		
			$plugin_db = array(
			'datasource' => 'Database/Mysql', 
			'persistent' => false,
			'host' => 'localhost',
			'login' => 'root',
			'password' => '11',
			'database' => 'sgp_core_producao',
			'encoding' => 'utf8'
		);
		
    	$layout_css = 'ambiente_de_testes.css';
    }
/**   Fim das Configuracoes realizadas por ambiente  **/

/*App::uses('ConnectionManager', 'Model');
ConnectionManager::create('plugin_db', $plugin_db);
*/

?>
