<?php 

$params = $this->request->params;
if($params['controller'] == 'pages' and !empty($params['pass'][0]) and $params['pass'][0] == 'home'):

echo $this->Html->css(array('mosaic.css'));
echo $this->Html->script(array('mosaic.1.0.1'));
?>

    <script type="text/javascript">  
			jQuery(function($){
				$('.bar2').mosaic({
					animation	:	'slide'		//fade or slide
				});
		    });
	</script>
    <style type="text/css">
        /*Demo Styles*/
        .clearfix{ display: block; height: 0; clear: both; visibility: hidden; }	
        .details{ margin:15px 20px; }	
        h4{ font:300 16px 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height:160%; letter-spacing:0.15em; color:#fff; text-shadow:1px 1px 0 rgb(0,0,0); }
        a{ text-decoration:none; }
	</style>	
<section class="sec-mosaic">
<div class="mosaic-block bar2">
			<a href="http://www.nonsensesociety.com/2010/12/i-am-not-human-portraits/" target="_blank" class="mosaic-overlay">
				<div class="details">
					<h4>I Am Not Human - Unique Self Portraits</h4><br/>
					<p>via the Nonsense Society (photo credit: Dan Deroches)</p>
				</div>
			</a>
            <div class="mosaic-backdrop"><?php echo $this->Html->image('modelo.png'); ?></div>
		</div>
               
         <div class="mosaic-block2 bar2">
             
			<a href="http://www.nonsensesociety.com/2010/12/i-am-not-human-portraits/" target="_blank" class="mosaic-overlay">
				<div class="details">
					<h4>I Am Not Human - Unique Self Portraits</h4><br/>
					<p>via the Nonsense Society (photo credit: Dan Deroches)</p>
				</div>
			</a>
            <div class="mosaic-backdrop"><?php echo $this->Html->image('modelo.png'); ?></div>
		</div>
                    
        <div class="mosaic-block2 bar2">
			
            <a href="http://www.nonsensesociety.com/2010/12/i-am-not-human-portraits/" target="_blank" class="mosaic-overlay">
				
                <div class="details">
                    
					<h4>I Am Not Human - Unique Self Portraits</h4><br/>
					<p>via the Nonsense Society (photo credit: Dan Deroches)</p>
				</div>
			</a>
            <div class="mosaic-backdrop"><?php echo $this->Html->image('modelo.png'); ?></div>
		</div>
         <div class="mosaic-block2 bar2">
			<a href="http://www.nonsensesociety.com/2010/12/i-am-not-human-portraits/" target="_blank" class="mosaic-overlay">
				<div class="details">
					<h4>I Am Not Human - Unique Self Portraits</h4><br/>
					<p>via the Nonsense Society (photo credit: Dan Deroches)</p>
				</div>
			</a>
            <div class="mosaic-backdrop"><?php echo $this->Html->image('modelo.png'); ?></div>
		</div>
                    <div class="mosaic-block2 bar2">
			<a href="http://www.nonsensesociety.com/2010/12/i-am-not-human-portraits/" target="_blank" class="mosaic-overlay">
				<div class="details">
					<h4>I Am Not Human - Unique Self Portraits</h4><br/>
					<p>via the Nonsense Society (photo credit: Dan Deroches)</p>
				</div>
			</a>
            <div class="mosaic-backdrop"><?php echo $this->Html->image('modelo.png'); ?></div>
		</div>
 </section>   
        <?php endif; ?>