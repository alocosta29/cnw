<link rel="stylesheet" type="text/css" href="css/menuEsquerdo.css">

<?php echo $this->Html->css(array('Manager.estiloMobile/menuEsquerdo.css')); ?>

<script type="text/javascript">
    $(document).ready(function(){
        var accordion_head = $('.accordion > li > a'),
            accordion_body = $('.accordion li > .sub-menu');
 			accordion_head.on('click', function(event) {
       
            if ($(this).attr('class') != 'active'){
                accordion_body.slideUp();
                $(this).next().stop(true,true).slideToggle('slow');
               accordion_head.removeClass('active');
                $(this).addClass('active');
            }
        });
    });
</script>

<?php 
if(isset($this->params['MenuEsquerdo']) and $this->params['MenuEsquerdo'] <> false):
?>
<br>
<ul class="accordion">
<?php 
$i=0;
foreach($this->params['MenuEsquerdo'] as $menuEsquerdo):
$i++;	
	 ?>

<?php if($this->params['plugin'] == $menuEsquerdo['Aco']['plugin'] and $this->params['controller'] == $menuEsquerdo['Aco']['controller']  and $this->params['action'] == $menuEsquerdo['Aco']['alias'])
{
	
}else{
 echo '<li id='.$i.'>'.$this->AclLink->link($menuEsquerdo['Aco']['aliasMenu'], array('plugin'=>$menuEsquerdo['Aco']['plugin'], 'controller'=>$menuEsquerdo['Aco']['controller'], 'action'=>$menuEsquerdo['Aco']['action'])).'</li>'; 	
}
?>
<?php endforeach; ?>
</ul>
<?php endif; ?>