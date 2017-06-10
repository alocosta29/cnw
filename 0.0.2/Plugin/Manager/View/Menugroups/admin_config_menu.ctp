<?php
echo $this->Html->script(array('jquery-1.8.3', 'Manager.ui/jquery-ui10', 'Manager.ui/modal2'));?>
<?php echo $this->Html->css(array('Manager.jquery-ui', 'Manager.estiloManager', 'estilo1Preto/formularios'));?>
<?php echo $this->Html->script(array('Manager.mask2', 'Manager.jquery.validate'));
?>
  <script>
	  $(function() {
	    $( "#accordion" ).accordion({
	      collapsible: true
	    });
	  });
  </script>

<div class="main">
<h2>Configuração de menus</h2>	

<?php //pr($this->Session->read('Auth.User')); ?>
<?php if(!empty($modulos)): 
$editarImg = $this->Html->image('Manager.icon-editar.gif');	
	?>
<h2 style="color:#3B8230; font-size: 15px; font-weight: bold; ">Módulos do sistema</h2>	
	<div id="accordion">
<?php foreach($modulos as $module): ?>
	<h3><?php echo 'Módulo: '.$module['Module']['nome']; ?> </h3>
	 <div>
	 	<table class="scrollQuebra" width="100%" style="font-size: 12px;" border = "0" cellspacing="0" cellpadding="3px">
 		<tr>
 			<th style="background-color: #3B8230; color: #fff;  font-weight: bold; ">Grupo de menu</th>
 			<th style="background-color: #3B8230; color: #fff;  font-weight: bold; ">Funcionalidade</th>
 			<th style="background-color: #3B8230; color: #fff;  font-weight: bold; ">Descrição</th>
 			<th style="background-color: #3B8230; color: #fff;  font-weight: bold; ">Ações</th>
 		</tr>	
	 	<?php
	 	if(isset($acos) and !empty($acos)):
			 	for($i=0; $i<sizeof($acos); $i++)
			 	{
			 		if($module['Module']['id'] == $acos[$i]['Aco']['module_id'])
			 		{ 
					 	?>
					 	<tr>
					 		<td><?php echo $this->MenuAssistent->getMenu($acos[$i]['Aco']['menugroup_id']); ?></td>
					 		<td><?php echo $acos[$i]['Aco']['aliasMenu']; ?></td>
					 		<td><?php echo $acos[$i]['Aco']['descricao']; ?></td>
					 		<td><?php echo $this->AclLink->link($editarImg, array('plugin'=>'manager', 'controller'=>'menugroups', 'action'=>'editItemMenu', $acos[$i]['Aco']['id']), array('escape'=>false, 'title'=>'editar item de menu')) ?></td>	
						</tr>		
						<?php	
			 		}
			 	}
		endif; 
	 	?>
	 	</table>
	 </div>
<?php endforeach; 
?>	
</div>
<?php endif; ?>
</div>