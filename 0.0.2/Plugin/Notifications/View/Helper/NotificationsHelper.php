<?php
/**
 * Pagination Helper class file.
 *
 * Generates pagination links
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Helper
 * @since         CakePHP(tm) v 1.2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppHelper', 'View/Helper');

/**
 * Report Helper
 * Data: 08/07/2013
 * Henrique R. Melo
 */
class NotificationsHelper extends AppHelper {
	/**
	 * Helper dependencies
	 *
	 * @var array
	 */
	public $helpers = array('Html','Form');

	/**
	 * The class used for 'Ajax' pagination links. Defaults to JsHelper. You should make sure
	 * that JsHelper is defined as a helper before PaginatorHelper, if you want to customize the JsHelper.
	 *
	 * @var string
	 */
	protected $_ajaxHelperClass = 'Js';

	
	public $headNotifications = "<style>
			#scrolbarNotifications::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,0.3);background-color:#F5F5F5;border-radius:7px;}
			#scrolbarNotifications::-webkit-scrollbar{width:7px;background-color:#F5F5F5;}
			#scrolbarNotifications::-webkit-scrollbar-thumb{border-radius:10px;background-image:-webkit-gradient(linear,left bottom,left top,color-stop(0.44, rgb(122,153,217)),color-stop(0.72, rgb(73,125,189)),color-stop(0.86, rgb(28,58,148)));}
		
			.balaodialogo {
				position: relative;background-color: #000;border-radius: 7px;width: 300px;height: 180px;line-height: 12px; 
				/* vertically center */
				color: white;text-align: left;
				margin-left:-100px;margin-top:-12px;
				background:rgb(255, 247, 207);
				display:none;
			}
	 
			.balaodialogo:after {
				content: '';position: absolute;width: 0;height: 0;color:rgba(255, 255, 255, 0);border: 15px solid;border-bottom-color: rgb(255, 247, 207);
				top: -11%;left: 29%;margin-left: -15px; /* ajustar pela largura do bal�o */
			}
	
			.balaodialogo-bottom:after {
				border-bottom-color: #292929;  top: -11%;  left: 29%;  margin-left: -15px;
			}
			
			.btNt a{
				padding: 0 0 0 0
			}
	
		</style> <ul><div  class ='balaodialogo' style='z-index:999999999999999999999999999999999999999999999999;position:absolute;width:355px;padding:21px 1px 21px 21px'> 
					<div id='scrolbarNotifications' style='overflow-x:hidden;overflow-y:auto;box-shadow: 3px 3px 2px rgba(0, 0, 0, 0.5);
						-moz-box-shadow: 3px 3px 2px rgba(0, 0, 0, 0.5);
						-webkit-box-shadow: 3px 3px 2px rgba(0, 0, 0, 0.5);
						height:200px;color:blue;font-size:10px;
					'><div style='text-align: center; position: absolute; margin-top: -22px; margin-left: 230px;'><a class='btNt' style='background: none; width: auto;' href='--URL--notifications/history'>+notificações...</a></div>
	";	
	
	public $footerNotifications = '</div> </div></ul>
								    <script type="text/javascript">
                                        $(".balaodialogo").hide();
										$("#btNotifications").click(function( e ){
											if($(".balaodialogo").is(":hidden")) {
												$(".balaodialogo").show(true);
											} else {
												$(".balaodialogo").hide("slow");
											}
										});
									</script>
	';

	public function show(){
		/**
		 * Nao permite a execucao desta chamada para audit/notifications/regs, que � um metodo usado pelo ajax, de tempos em tempos, evita pesar o mesmo.
		 */
		if (!( ('notifications'==$this->params['plugin']) && ('notifications'==$this->params['controller']) && ('regs'==$this->params['action']) )) {
			try {
				/**
				 * Verifica se o usuario acessou alguma URL que estava pendente no notifications e marca como visualizada
				 */
				$urlFull = $this->Html->url('',true);
				$Notification = ClassRegistry::init('Notifications.Notification');
				$Notification->recursive = 1;
				$usuarioId = AuthComponent::user('id');
				$acessTargetNotification =  $Notification->find('first', array('conditions' => array(
					'Notification.to_user_id'=>"$usuarioId",
					'Notification.urltarget'=>"$urlFull",
					'Notification.visualized'=>null,
					'Notification.isactive'=>'Y',
					'Notification.isdeleted'=>'N'
				)));
				
				if (is_array($acessTargetNotification) && (count($acessTargetNotification)>0) ) {
					if( strlen(trim($acessTargetNotification['Notification']['visualized'])) <=0 ){
						$dateTime = new DateTime();
						
						$datetimeCreated = new DateTime($acessTargetNotification['Notification']['created']);
						$interval = $datetimeCreated->diff($dateTime);
						
						$acessTargetNotification['Notification']['visualized'] = $dateTime->format( "Y-m-d H:i:s" );
						
						if ($interval->format("%S")>30) { #Se intervalo for maior que 30seg, entao marca $acessTargetNotification como lida 
							$Notification->save($acessTargetNotification);
						}
					}
				}
			} catch (Exception $e) {
				echo '';#erro;
			}
		}
		
		/**
		 * Construindo botao do plugin Notifications
		 */
		$rs = null;
		$rs.= $this->_loadBottomNotifications();
		$rs.= str_replace('--URL--',$this->Html->url('/',true),$this->headNotifications).$this->_getListNotifications().$this->footerNotifications;
		
		return $rs;
	}
	
	public function checkNotif(){
		$usuarioId = AuthComponent::user('id');
		$usuarioNome = AuthComponent::user('username');
		$usuarioLogin = ucfirst( AuthComponent::user('username') );#primeira letra Maiuscula
		if(isset($usuarioId)) {
			$Notification = ClassRegistry::init('Notifications.Notification');
			$Notification->recursive = 1;
			$listNotification =  $Notification->find('all', array('fields'=>'count(Notification.id) as qtdeNt', 'group' => 'Notification.to_user_id', 'conditions' => array(
				'Notification.to_user_id'=>"$usuarioId",
				'Notification.visualized'=>null,
				'Notification.isactive'=>'Y',
				'Notification.isdeleted'=>'N'
			)));
			$qtdeNt = $listNotification['0']['0']['qtdeNt'];
			if( ($qtdeNt>=1) && ($qtdeNt <=9) ) {
				$bt = $this->Html->url('/').'notifications/img/notifications0'.$qtdeNt.'.png';
			} elseif( $qtdeNt>9 ){
				$bt = $this->Html->url('/').'notifications/img/notifications_9.png';
			} else {
				$bt = $this->Html->url('/').'notifications/img/notificationsHistory.png';
			}
			echo "<script>window.parent.$('#btNotifications').attr('src', '".$bt."');</script>\r\n";
		} else {
			$bt = $this->Html->url('/').'notifications/img/notificationsNull.png';
		}
	}
	
	public function _loadBottomNotifications(){
		$usuarioId = AuthComponent::user('id');
		$usuarioNome = AuthComponent::user('username');
		$usuarioLogin = ucfirst( AuthComponent::user('username') );#primeira letra Maiuscula
		if(isset($usuarioId)) {
			$Notification = ClassRegistry::init('Notifications.Notification');
			$Notification->recursive = 1;
			$listNotification =  $Notification->find('all', array('fields'=>'count(Notification.id) as qtdeNt', 'group' => 'Notification.to_user_id', 'conditions' => array(
				'Notification.to_user_id'=>"$usuarioId",
				'Notification.visualized'=>null,
				'Notification.isactive'=>'Y',
				'Notification.isdeleted'=>'N'
			)));
			if ( isset($listNotification['0']['0']['qtdeNt']) ) {
				$qtdeNt = $listNotification['0']['0']['qtdeNt'];
			} else {
				$qtdeNt = 0;
			}
			if( ($qtdeNt>=1) && ($qtdeNt <=9) ) {
				$bt = $this->Html->image('/notifications/img/notifications0'.$qtdeNt.'.png',array('id'=>'btNotifications', 'style'=>'z-index:999999999999'));
			} elseif( $qtdeNt>9 ){
				$bt = $this->Html->image('/notifications/img/notifications_9.png',array('id'=>'btNotifications', 'style'=>'z-index:999999999999'));
			} else {
				return $this->Html->image('/notifications/img/notificationsHistory.png',array("title" => "Notificações",
    				'url' => array('admin'=>false, 'plugin'=>'notifications', 'controller'=>'history', 'action' => 'index'),
    				'style'=>'z-index:999999999999'
				));
			}			
		} else {
			return $this->Html->image('/notifications/img/notificationsNull.png');
		}
		$rs = $bt;
		
		return $rs;
	}
	
	public function _getListNotifications(){
		$msg = null; $listNotifications = null;
		if ( isset($_SESSION['Auth']['User']['role_id']) ) {
			foreach ($this->_findNotifications() as $key=>$value) {
                $from = '/notifications/img/'.$value['Notification']['system_acronym'].'.png';
                $fromname = $value['System']['description'];
				$listNotifications.= "<div style='height:53px'><div style='float:left'>".$this->Html->image($from, array('border'=>'0','width'=>'45px')).'</div>';
				$listNotifications.= '<div style="height:37px"><b>'.$fromname.'</b> <p style="margin:0 0 0 0">';
				//$listNotifications.= 'informa que seu relatorio de auditoria esta disponivel para visualizacao.';
				
				$listNotifications.= $this->Html->link($this->_cutString(strip_tags($value['Notification']['msg_text']),88), array('admin'=>false, 'plugin'=>'notifications', 'controller'=>'history', 'action' => 'view/'.$value['Notification']['id']), array('style'=>'white-space:normal;width:271px;color: #1a4299;display:block;float:left;height:25px;overflow:hidden;padding: 0 0 0 0;font:10px verdana, helvetica, arial, sans-serif;text-decoration:underline;text-align:left;background: transparent url("") no-repeat center right    '));		
				$listNotifications.= '</p></div><div><p><b style="color:gray">H&aacute; '.$this->_extensoDatetimediff($value['Notification']['created']).'</b></p> </div></div><hr>';
			}
		}
		$rs = $listNotifications;
		return $rs;
		
	}
	
	public function _cutString($string, $len){
		$string.=' ';
		if (strlen($string) > $len) {
			return substr($string, 0, strrpos(substr($string,0,$len),' ')).'...';
		} else {
			return $string;
		}
	}

	public function _findNotifications(){
		if ( isset($_SESSION['Auth']['User']['role_id']) ) {
			$usuarioId = AuthComponent::user('id');
			$usuarioNome = AuthComponent::user('username');
			$usuarioLogin = ucfirst( AuthComponent::user('username') );#primeira letra Maiuscula
			$roleIdAtual = $_SESSION['Auth']['User']['role_id'];
			///try {
				/*****************************************************************************************
				 * EXEMPLO DE CODIGO PARA SER USADO PARA PESQUISAR AS NOTIFICACOES DO USUARIO LOGADO !!! *
				*************************************************************************************/
				$Notification = ClassRegistry::init('Notifications.Notification');
				$Notification->recursive = 1;
				$listNotification =  $Notification->find('all', array('order'=>array('Notification.created desc'), 'conditions' => array(
						'Notification.to_user_id'=>"$usuarioId",
						'Notification.visualized'=>null,
						'Notification.isactive'=>'Y',
						'Notification.isdeleted'=>'N'
					)));
				return $listNotification;
			
			/**
			} catch (Exception $e) {
				return $e;
				$cmdXXX = '';
				if($roleIdAtual<=2){
			
				}
			}
			**/
		}
	}
	
	
	private function _extensoDatetimediff($datetime, $datetimeAtualX=null) {
        $out='';
		if ( strlen(trim($datetimeAtualX))>0 ) {
			$datetimeAtual = date_create($datetimeAtualX);
		} else {
			$datetimeAtual = date_create();
		}
		 
		if ( strlen(trim($datetime))>0 ) {
			$datetimeFim = date_create($datetime);
		} else {
			return null;
		}
	
		$dtDiff = date_diff($datetimeAtual, $datetimeFim);
	
		$yearExt = ($dtDiff->format("%Y")>1) ? ($dtDiff->format("%Y")+0).' anos' : ($dtDiff->format("%Y")+0).' ano';
		$monthExt = ($dtDiff->format("%M")>1) ? ($dtDiff->format("%M")+0).' meses' : ($dtDiff->format("%M")+0).' mes';
		$dayExt = ($dtDiff->format("%d")>1) ? ($dtDiff->format("%d")+0).' dias' : ($dtDiff->format("%d")+0).' dia';
		$hourExt = ($dtDiff->format("%H")>1) ? ($dtDiff->format("%H")+0).' horas' : ($dtDiff->format("%H")+0).' hora';
		$minuteExt = ($dtDiff->format("%i")>1) ? ($dtDiff->format("%i")+0).' minutos' : ($dtDiff->format("%i")+0).' minuto';
		$secondExt = ($dtDiff->format("%s")>1) ? ($dtDiff->format("%s")+0).' segundos' : ($dtDiff->format("%s")+0).' segundo';
	
		if ( $dtDiff->format("%Y") >0 ){
			if ( $dtDiff->format("%M") >0 ) {
				$out = $yearExt.', '.$monthExt.' e '.$dayExt.'.';
			} else {
				$out = $yearExt.' e '.$dayExt.'.';
			}
		} elseif ( $dtDiff->format("%M") >0 ) {
			$out = $monthExt.', '.$dayExt.' e '.$hourExt.'.';
		} elseif ( $dtDiff->format("%d") >0 ) {
			$out = $dayExt.', '.$hourExt.' e '.$minuteExt.'.';
		} elseif ( $dtDiff->format("%H") >0 ) {
			$out = $hourExt.', '.$minuteExt.' e '.$secondExt.'.';
		} elseif ( $dtDiff->format("%i") >0 ) {
			$out = $minuteExt.' e '.$secondExt.'.';
		} elseif ( $dtDiff->format("%s") >0 ) {
			$out = 'menos de um minuto.';
		}
	
		return $out;
	}
	
	

}
