<?php 
if(!empty($services)): 
    
    
?>
<br><br>
<span class="text-content">
<?php    
foreach ($services as $service ) {

echo '<strong>'.$service['Servico']['servico'].'</strong><br>';
 echo $service['Servico']['descricao'].'<br><br>';

?>





<?php 
} ?>
</span>
<?php
endif; ?>