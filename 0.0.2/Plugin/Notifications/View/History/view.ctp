<style>
	dl {line-height: 2em;margin: 0em 0em;width: 570px;}
</style>

<div  style='width:1200px;'>

<div class="assist" style="float: left;">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->AclLink->link(__('Listar notificações'), array('action' => 'index')); ?> </li>
        <br>
        <li><?php echo $this->AclLink->postLink(__('Deletar notificação'), array('action' => 'delete', $notification['Notification']['id']), null, __('Tem certeza que deseja deletar notificação de %s?', $notification['UserCreated']['username'])); ?> </li>
        <div>
            <br /><br /><h3><?php echo __('Remetente:'); ?></h3>
		 	<?php
            $from = '/notifications/img/'.$notification['Notification']['system_acronym'].'.png';
            $fromname = $notification['System']['description'];
            echo "<div style='float:none'>".$this->Html->image($from, array('border'=>'0','width'=>'145px')).'';?>
			<div><b><?php echo $fromname;?></b></div>
		</div>
	</ul>
</div>

<div class="main">
<h3><?php  echo __('Visualizando notificação'); ?></h3>
	<dl style="width: 100%;">
		<dt><?php echo __('Destinatário:'); ?></dt>
		<dd>
			<?php echo $notification['ToUser']['username']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Criada em:'); ?></dt>
		<dd>
			<?php
				if(strlen(trim($notification['Notification']['created']))>0):
					echo date('d/m/Y H:i', strtotime("+0 days",strtotime($notification['Notification']['created']))).'h';
					echo ' ('.$notification['UserCreated']['username'].')';
				endif;?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visualizada em:'); ?></dt>
		<dd>
			<?php if(strlen(trim($notification['Notification']['visualized']))>0): echo date('d/m/Y H:i', strtotime("+0 days",strtotime($notification['Notification']['visualized']))).'h';endif;?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notificação:'); ?></dt>
		<dd>
			<?php echo $notification['Notification']['msg_text']; 
			$datax = new DateTime(); $targetx = $datax->format('Y_m_d_TH_i_s');
			if(strlen(trim($notification['Notification']['urltarget']))>0): echo ' <a style="color:blue" target="'.$targetx.'" href="'.$notification['Notification']['urltarget'].'">Clique aqui!</a>' ;endif;?>
			&nbsp;
		</dd>
	</dl>
</div>

</div>
