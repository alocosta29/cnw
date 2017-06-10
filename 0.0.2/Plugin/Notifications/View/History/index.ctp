<?php 
function _extensoDatetimediff($datetime, $datetimeAtualX=null) {
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
	
?>

<div  style='width:1000px;'>
<div class="assist" style="width: 23px;">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__('New Notification'), array('action' => 'add')); ?></li>
		<li><?php //echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index')); ?> </li>
	</ul>
</div>

<?php  if( (count($notifications)>0) && (is_array($notifications)) ) : ?>
	
<div class="main" style="width: 95%;">
	<h3><?php echo __('Lista de notificações'); ?></h3>
	<table id="grid" cellpadding="0" cellspacing="0"  class="scroll" border='1' style="width: 100%;">
	<tr>
			<th style="width: 78px;"><?php echo $this->Paginator->sort('from_user_id','Remetente'); ?></th>
			<th style="width: 50%;"><?php echo $this->Paginator->sort('msg_text','Notificação'); ?></th>
			<th><?php echo $this->Paginator->sort('visualized','Data visualização'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($notifications as $notification): ?>
	<tr>
		<td>
		 	<?php 
            $from = '/notifications/img/'.$notification['Notification']['system_acronym'].'.png';
            $fromname = $notification['System']['description'];
            echo "<div style='height:53px'><div style='text-align: center;'>".$this->Html->image($from, array('border'=>'0','width'=>'53px')).'</div>';?>
		</td>
		<td style="width: 255px;white-space:initial">
			<?php echo '<div><b>'.$fromname.'</b> <p style="margin:0 0 0 0">';?>
	
			<?php echo $this->Notifications->_cutString(strip_tags($notification['Notification']['msg_text']),88); 
				$datax = new DateTime(); $targetx = $datax->format('Y_m_d_TH_i_s');
				if(strlen(trim($notification['Notification']['urltarget']))>0): echo ' <a style="color:blue" target="'.$targetx.'" href="'.$notification['Notification']['urltarget'].'">Clique aqui!</a>' ;endif;?>
			&nbsp;
			<?php echo '</p></div>';?>
			<?php echo '<div><p><b style="color:gray">H&aacute; '._extensoDatetimediff($notification['Notification']['created']).'</b></p> </div>'; ?>

		</td>
		<td>
			<?php if(strlen(trim($notification['Notification']['visualized']))>0): echo date('d/m/Y H:i', strtotime("+0 days",strtotime($notification['Notification']['visualized']))).'h';endif;?>
			&nbsp;
		</td>
		<td class="actions">
			<?php echo $this->AclLink->link(__('View'), array('action' => 'view', $notification['Notification']['id'])); ?>
			<?php echo $this->AclLink->postLink(__('Deletar'), array('action' => 'delete', $notification['Notification']['id']), null, __('Tem certeza que deseja deletar notificação enviado via %s?', $fromname.' de '.$notification['UserCreated']['username'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php 
	 echo $this->Element('Manager.paginacao');
	?>
</div>

<?php else: ?>
	<h2><?php echo __('<b>No momento n&atilde;o existem notifica&ccedil;&otilde;es para listar.</b>'); ?></h2>
<?php endif; ?>

</div>

