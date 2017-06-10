<div class="main">
<h2>RESULTADO DA SINCRONIZAÇÃO</h2>	
<?php
//pr($create_logs);

if(isset($create_logs) and !empty($create_logs)):
echo '<div class="messageFixNotification">';	
foreach($create_logs as $create): 
echo $create; ?>
<br>
<?php 
endforeach;
echo '</div>';
?>
<br></br>
<?php endif;	 
?>

<?php
if(isset($prune_logs) and !empty($prune_logs)):
	echo '<div class="messageFixNotification">';
foreach($prune_logs as $apagado): 
echo $apagado; ?>
<br>
<?php 
endforeach;
echo '</div>';
?>
<br></br>
<?php endif;	 
?>


</div>