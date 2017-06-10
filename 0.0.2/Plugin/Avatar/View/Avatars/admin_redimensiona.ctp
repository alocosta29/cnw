<?php echo $this->Html->script(array('Avatar.crop/jquery.min.js', 'Avatar.crop/jquery.Jcrop.min.js')); ?>
<script type="text/javascript">
    jQuery(function($){
      // Create variables (in this scope) to hold the API and image size
      var jcrop_api, boundx, boundy;
      $('#target').Jcrop({
        onChange: updatePreview,
        onSelect: updatePreview,
       	aspectRatio: 1 / 1,
      },function(){
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        // Store the API in the jcrop_api variable
        jcrop_api = this;
         jcrop_api.setOptions({ allowMove: true });
            jcrop_api.setOptions({ allowResize: true });
      });
      function updatePreview(c)
      {
        if (parseInt(c.w) > 0)
        {
          var rx = 100 / c.w;
          var ry = 100 / c.h;
		jQuery('#fotoX').val(c.x);
		jQuery('#fotoY').val(c.y);
		//jQuery('#fotoX2').val(c.x2);
		//jQuery('#fotoY2').val(c.y2);
		//$('#x2').val(c.x2);
		//$('#y2').val(c.y2);
		jQuery('#fotoW').val(c.w);
		jQuery('#fotoH').val(c.h);
          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
      };
    });
  </script>
  
  <div class="assist">  
      
      <?php echo '<br>'.$this->element('Articles.linksEditPerfil'); ?>   
      
      <br><br>
  	<table border="0" cellpadding="2px">
		<tr><td>Miniatura preview</td></tr>
		<tr>
			<td><?php echo $this->Html->image($image['thumb'].$registro['Avatar']['avatar'], array('style'=>'border-radius: 300px; width: 150px; ')); ?></td>
			<td></td>
		</tr>
	</table>	
  	</div>
<div class="main">
    <h2>Redimensionar avatar</h2>
   
    <?php echo $this->Form->create('Avatar', array('class'=>'default2', 'type'=>'file'));?>
        <fieldset>
            <legend><?php echo __('Selecione uma parte da imagem e pressione "REDIMENSIONAR"'); ?></legend>
            <?php echo $this->Html->image($image['normal'].$registro['Avatar']['avatar'], array('id'=>'target')); ?>
            <?php //echo $this->Html->image('imagem.jpg', array('id'=>'jcrop')); ?>
            <input name="data[Avatar][x]" id="fotoX" type="hidden">
            <input name="data[Avatar][y]" id="fotoY" type="hidden">
            <input name="data[Avatar][x2]" id="fotoX2" type="hidden">
            <input name="data[Avatar][y2]" id="fotoY2" type="hidden">
            <input name="data[Avatar][w]" id="fotoW" type="hidden">
            <input name="data[Avatar][h]" id="fotoH" type="hidden">	
            <?php echo $this->Form->end(__('Redimensionar'));?>
        <?php $voltar = $this->Html->image('voltar.png', array('title'=>'Voltar')); ?>

    </fieldset>
</div>