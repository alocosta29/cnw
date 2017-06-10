<?php 
App::uses('AppHelper', 'View/Helper'); 
//App::uses('HtmlHelper', 'View/Helper');
class CmsHelper extends AppHelper{
    
    public $helpers = array('Html');
    
    

    
    public function getCms($field)
    {
       
        $return = $this->Html->script('ckeditor/ckeditor.js');
        $return .= $this->Html->script('kcfinder/kcfinder.js');
        $host = $this->getHost().'js/'; 
        $return.=  '	<script>
			var VARS_AMBIENTE = new Array();
			VARS_AMBIENTE["caminho_servidor"] = "'.$host.'"; </script>';
        $return.=  '<script type="text/javascript">
    	var ckEditor = CKEDITOR.replace("'.$field.'");
        </script>';
        $return .=' <script>            
                    $(document).ready(function(){
                      $("#'.$field.'").addClass("ckeditor");
                    }); 
                   </script> ';
        return $return;
    }
    
    private function getHost()
	{
		if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$host['protocolo'] = 'https';
		} else {
			$host['protocolo'] = 'http';
		}
			$host['host'] = $_SERVER['HTTP_HOST'];
			$host['app'] = str_replace('webroot/index.php', '', $_SERVER['SCRIPT_NAME']); 
			$host_completo = $host['protocolo'].'://'.$host['host'].$host['app'];
		return $host_completo;
	}
    
    
    
} 