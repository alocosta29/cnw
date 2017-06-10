<?php 
if(isset($this->params['MenuEsquerdo']) and $this->params['MenuEsquerdo'] <> false):
?>
<br>
<ul>
<?php foreach($this->params['MenuEsquerdo'] as $menuEsquerdo): ?>

<?php if($this->params['plugin'] == $menuEsquerdo['Aco']['plugin'] and $this->params['controller'] == $menuEsquerdo['Aco']['controller']  and $this->params['action'] == $menuEsquerdo['Aco']['alias'])
{
	
}else{
 echo '<li>'.$this->AclLink->link($menuEsquerdo['Aco']['aliasMenu'], array('plugin'=>$menuEsquerdo['Aco']['plugin'], 'controller'=>$menuEsquerdo['Aco']['controller'], 'action'=>$menuEsquerdo['Aco']['action'])).'</li>'; 	
}
?>
<?php endforeach; ?>
</ul>
<?php endif; ?>