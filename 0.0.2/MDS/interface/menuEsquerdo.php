<link rel="stylesheet" type="text/css" href="css/menuEsquerdo.css">

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


<ul class="accordion">
    
    
    
    
    <li id="2" class="cloud">
    <a href="#" >Ficha cadastral </a>
    <ul class="sub-menu">
 		<li><a href='sair.htm'>Dados cadastrais</a></li>
 		<li><a href='sair.htm'>Documentação </a></li>
 		<li><a href='sair.htm'>Foto </a></li>
    </ul>
   	</li>
   	

	<li id="3" class="cloud">
    <a href="#" >Ficha funcional</a>
    <ul class="sub-menu">
 		<li><a href='sair.htm'>Alteração funcional</a></li>
    </ul>
   	</li>

	   	<li id="one">
			<a href='sair.htm'>Lançar férias</a>
    </li>
 
</ul>