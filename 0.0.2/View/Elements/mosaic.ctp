<?php 
if(!empty($destaques)): 
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
        .details{ 
            margin-top: 7px;
            margin-bottom: 15px;
            margin-left: 7px;
            margin-right: 7px; 
  
        
        }	
        h4{ font:300 16px; line-height:100%; color:#fff; text-shadow:1px 1px 0 rgb(0,0,0); }
        a{ text-decoration:none; }
	</style>	
<section class="sec-mosaic">
    
    
    <div class="mosaic-block bar2">
        <a href="<?php echo HOST_REAL.'public/artigo/'.$destaques[0]['Artigo']['id'].'/'.$destaques[0]['Artigo']['alias'];?>" class="mosaic-overlay">
            <div class="details">
                <h4><?php echo $destaques[0]['Artigo']['titulo']; ?></h4><br/>
                <p></p>
            </div>
        </a>
        <div class="mosaic-backdrop"><?php 
        $imgPost = 'img_destak/'.$destaques[0]['Artigo']['user_id'].'/'.$destaques[0]['Artigo']['imagem'];
        echo $this->Html->image($imgPost); ?></div>
    </div>
    
    <?php 
        $listDestaks = $destaques;
        unset($listDestaks[0]);
        sort($listDestaks);
        foreach($listDestaks as $destak): ?>
    
               
    <div class="mosaic-block2 bar2">
       <a href="<?php echo HOST_REAL.'public/artigo/'.$destak['Artigo']['id'].'/'.$destak['Artigo']['alias'];?>" class="mosaic-overlay">
           <div class="details">
               <h4><?php echo $destak['Artigo']['titulo']; ?></h4><br/>
               <p></p>
           </div>
       </a>
       <div class="mosaic-backdrop">
       <?php 
        $imgPost = 'img_destak/'.$destak['Artigo']['user_id'].'/'.$destak['Artigo']['imagem'];
        echo $this->Html->image($imgPost); ?>
       </div>
   </div>
    <?php endforeach; ?>  
    
    

 </section>   

        <?php endif; ?>

    
    
    <?php endif; ?>