<style>
	#mask {
	  position:absolute;
	  left:0;
	  top:0;
	  z-index:90;
	  background-color:#000;
	  display:none;
	}

	#maskW {
	  position:absolute;
	  left:0;
	  top:0;
	  z-index:100000000000000000000000000000000000000;
	  background-color:#FFF;
	  display:none;
	}
	#loading{
		width:200px;
		padding:10px;
		border:0px solid #06F;
		color:#06F;
		font-family: 'Trebuchet MS', 'Comic Sans MS', 'Arial', 'Sans-Serif';
		font-size:14pt;
		position:fixed;
		z-index:110;
		display:none;
	}
	</style>
	
	<script>
		//--- monta a janela transparent tela cheia
		function winMask()
		{
			$('#maskW').hide();
			$('#loading').hide();
			
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			
			$('#mask').css({'width':maskWidth,'height':maskHeight, 'opacity': 0.0});
		
			$('#mask').fadeIn(1000);	
			$('#mask').show();
		}
		
		function winMaskW()
		{
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			var pathImgLoading = $('#imgloading').attr('src');
			
			$('#maskW').css({'width':maskWidth,'height':maskHeight, 'opacity': 0.0});
		
			$('#maskW').fadeIn(1000);
			
			var winH = $(window).height();
			var winW = $(window).width();
				
			var boxH = $('#loading').height();
			var boxW = $('#loading').width();
				
			$('#loading').css('top',winH/2-boxH/2);
			$('#loading').css('left', winW/2-boxW/2);
		
			
			$.browser={};
			(function(){
				$.browser.msie=false;
				$.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
					$('#loading').html('<img src="'+pathImgLoading+'"/>');
					$('#loading').css('display', '');
				}}
			)();
			
			
			$('#loading').show();
			
			
		}

		window.onbeforeunload = function (evt) {
		  if (typeof evt == 'undefined') {
		    evt = window.event;
		  }
		  if (evt) {
		    winMaskW();//evt.returnValue = message;
		  }
		  //return winMaskW();//message;
		}




	</script>
	
	
	<?php 
/**
 * Mascara para cobrir a tela
 */
?>
<div id="mask"></div>

<?php 
/**
 * Mascara branca para cobrir a tela
 */
?>
<div id="maskW"></div>
<div id="loading"><?php echo $this->Html->image('Manager.loading.gif', array('id'=>'imgloading')); ?></div>

	
	