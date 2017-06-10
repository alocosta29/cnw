<?php
echo $this->Html->script(array('jquery-1.8.3', 'Manager.ui/jquery-ui10', 'Manager.ui/modal2'));?>
<?php echo $this->Html->css(array('Manager.jquery-ui', 'Manager.estiloManager', 'estilo1Preto/formularios'));?>
<?php echo $this->Html->script(array('Manager.mask2', 'Manager.jquery.validate'));
$details= HOST_REAL.'Manager'.DS.'img'.DS.'details.png';
$details = $this->Html->image($details);
$imagemDel = HOST_REAL.'Manager'.DS.'img'.DS.'mdeletar.png';
$imagemAd = HOST_REAL.'Manager'.DS.'img'.DS.'madicionar.png';
 ?>
<?php if(!empty($modulos)): ?>
  <script>
	  $(function() {
	    $( "#accordion" ).accordion({
	      collapsible: true
	    });
	  });
  </script>
    <script>
	  $(function() {
	    $( "#accordion2" ).accordion({
	      collapsible: true
	    });
	  });
  </script>
  

<div class="metadeTelaToda">
<h3 style="color:#3B8230; font-size: 15px; font-weight: bold; ">Funções permitidas</h3>	
	<div id="accordion" style="width: 420px;">
<?php foreach($modulos as $module): ?>

  <h3><?php echo 'Módulo: '.$module['Module']['nome']; ?> </h3>
  <div>
   <?php 
 	$k=0;
 	if($aclPermissions<>false): ?>
 		<table class="scrollQuebra" width="400px" style="font-size: 12px;" border = "0" cellspacing="0" cellpadding="3px">
 		<tr>
 			<th style="background-color: #3B8230; color: #fff;  font-weight: bold; ">Funcionalidade</th>
 			<th style="background-color: #3B8230; color: #fff;  font-weight: bold; ">Descrição(Passe o mouse)</th>
 			<th style="background-color: #3B8230; color: #fff;  font-weight: bold; ">Ações</th>
 		</tr>	
 		<?php
 		for($i=0; $i<sizeof($aclPermissions); $i++): ?>
 		<?php if($aclPermissions[$i]['AcoAdmin']['module_id'] == $module['Module']['id']): 
 			$k++;
 			if($k % 2 == 0) { $color = "#DFDFDF";}else{ $color = "#fff"; }
 			?>
 		<tr>
 			<td style="background-color: <?php echo $color; ?>; font-weight: bold; ">
 				<?php
 			echo $this->FormatManager->limitTexto($aclPermissions[$i]['AcoAdmin']['aliasMenu'], 25); ?> </td>
 			<td style="background-color: <?php echo $color; ?>;">
 				<a href='#' title="<?php echo $aclPermissions[$i]['AcoAdmin']['aliasMenu'].': '.$aclPermissions[$i]['AcoAdmin']['descricao']; ?>"><?php echo $details; ?>
 				<?php echo $this->FormatManager->limitTexto($aclPermissions[$i]['AcoAdmin']['descricao'], 15); ?></a> </td>
 			<td style="background-color: <?php echo $color; ?>;">
						<?php echo $this->Form->create('Permission', array('action' => 'changePermission')); ?>
						<?php echo $this->Form->hidden('permission', array('value'=> 'N')); ?>
						<?php echo $this->Form->hidden('aco_id', array('value'=> $aclPermissions[$i]['AcoAdmin']['id'])); ?>
						<?php echo $this->Form->hidden('aro_id', array('value'=> $aroId)); ?>
						<?php
						echo $this->Form->submit($imagemDel, array('style'=>'width:15px; ', 'alt'=>'Deletar', 'div'=>false));
						echo $this->Form->end(); ?>
 			</td>
 		</tr>	
 		<?php endif; ?>
 	<?php 
		endfor;?>
		</table>
	<?php endif; ?>
  </div>
<?php endforeach; ?> 
</div>
	
	
</div>
<div class="metadeTelaToda">
	<h3 style="color:#CC0002; font-size: 15px; font-weight: bold;">Funções não-permitidas</h3>	
<div id="accordion2" style="width: 420px;">
<?php foreach($modulos as $module): ?>

  <h3><?php echo 'Módulo: '.$module['Module']['nome']; ?> </h3>
  <div>
 	<?php 
 	$k=0;
 	if($aclNotPermissions<>false): ?>
 		<table class="scrollQuebra" width="400px" style="font-size: 12px;" border = "0" cellspacing="0" cellpadding="3px">
 		<tr>
 			<th style="background-color: #CC0002; color: #fff;  font-weight: bold; ">Funcionalidade</th>
 			<th style="background-color: #CC0002; color: #fff;  font-weight: bold; ">Descrição(Passe o mouse)</th>
 			<th style="background-color: #CC0002; color: #fff;  font-weight: bold; ">Ações</th>
 		</tr>	
 			
 		<?php
 		for($i=0; $i<sizeof($aclNotPermissions); $i++): ?>
 		<?php if($aclNotPermissions[$i]['AcoAdmin']['module_id'] == $module['Module']['id']): 
 			$k++;
 			if($k % 2 == 0) { $color = "#DFDFDF";}else{ $color = "#fff"; }
 			?>
 		<tr>
 			<td style="background-color: <?php echo $color; ?>; font-weight: bold; "><?php echo $this->FormatManager->limitTexto($aclNotPermissions[$i]['AcoAdmin']['aliasMenu'], 25); ?></td>
 			<td style="background-color: <?php echo $color; ?>;"><a href='#' title="<?php echo $aclNotPermissions[$i]['AcoAdmin']['aliasMenu'].': '.$aclNotPermissions[$i]['AcoAdmin']['descricao']; ?>"><?php echo $details; ?>
 				<?php echo $this->FormatManager->limitTexto($aclNotPermissions[$i]['AcoAdmin']['descricao'], 15); ?> </a></td>
 			<td style="background-color: <?php echo $color; ?>;">
			<?php echo $this->Form->create('Permission', array('action' => 'changePermission')); ?>
						<?php echo $this->Form->hidden('permission', array('value'=> 'Y')); ?>
						<?php echo $this->Form->hidden('aco_id', array('value'=> $aclNotPermissions[$i]['AcoAdmin']['id'])); ?>
						<?php echo $this->Form->hidden('aro_id', array('value'=> $aroId)); ?>
						<?php echo $this->Form->submit($imagemAd, array('style'=>'width:15px; ', 'alt'=>'Deletar', 'div'=>false));
							  echo $this->Form->end(); ?>
			 </td>
 		</tr>	
 		<?php endif; ?>
 	<?php endfor;?>
		</table>
	<?php endif; ?>
  </div>

<?php endforeach; ?> 
 </div>
 
</div>
</div>
<?php endif; ?>