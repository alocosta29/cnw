<!-- 
	Parametros para Elemento:
		id da tabela -> $ID
-->
<?php
if(!isset($col) or empty($col)):
    $col = 0;  
endif;

if(!isset($col) or empty($order)):
    $order = 'asc';  
endif;

?>


<?php
	// inclui os objetos necessários para dataTable funcionar
	echo $this->Html->css('DataTableCss/jquery.dataTables.css');
	echo $this->Html->css('DataTableCss/buttons.dataTables.css');
	echo $this->Html->css('DataTableCss/responsive.dataTables.css');
	
	// os scripts devem seguir a ordem de import para funciona
	echo $this->Html->script('DataTableJs/jquery.dataTables.js');
	echo $this->Html->script('DataTableJs/dataTables.buttons.js');
        echo $this->Html->script('DataTableJs/dataTables.responsive.js');
	echo $this->Html->script('DataTableJs/buttons.flash.js');
	echo $this->Html->script('DataTableJs/jszip.js');
	echo $this->Html->script('DataTableJs/pdfmake.js');
	echo $this->Html->script('DataTableJs/vfs_fonts.js');
	echo $this->Html->script('DataTableJs/buttons.html5.js');
	echo $this->Html->script('DataTableJs/buttons.print.js');
	echo $this->Html->script('DataTableJs/buttons.colVis.js');

?>

<script>
// Regras das tabelas
$.extend( true, $.fn.dataTable.defaults, {
    "searching": true,
    "ordering": true,
    "pageLength": 20,
    "language": {
		"sProcessing":   "A processar...",
		"sLengthMenu":   "Mostrar _MENU_ registos",
		"sZeroRecords":  "Não foram encontrados resultados",
		"sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registos",
		"sInfoEmpty":    "Mostrando de 0 até 0 de 0 registos",
		"sInfoFiltered": "(filtrado de _MAX_ registos no total)",
		"sInfoPostFix":  "",
		"sSearch":       "Procurar:",
		"sUrl":          "",
		"oPaginate": {
		    "sFirst":    "Primeiro",
		    "sPrevious": "Anterior",
		    "sNext":     "Seguinte",
		    "sLast":     "Último"
		},
		"buttons": {
            copyTitle: 'Copiado para memória',
            copySuccess: {
                _: 'Foram copiados %d registros',
                1: '1 registro copiado'
            }
        }
	}, 
	"dom": '<"top"Bf>rt<"bottom"ip><"clear">',
    "buttons": [
		// {extend: 'print', 	  text: 'Imprimir'},
		 {
		 	extend: 'excelHtml5', 	  
		 	text: 'Excel',
		 	exportOptions: {
        		columns: ':visible'
        	} 
		 },
		 {
            extend: 'pdfHtml5',
            text: 'PDF',
	        exportOptions: {
	        	columns: ':visible'
	        }
	     },
		 {
	 		extend: 'copyHtml5',  	  
	 		text: 'Copiar',
	 		exportOptions: {
        		columns: ':visible'
        	}
		 },
		 {extend: 'colvis',   text: 'Exibir/Ocultar Colunas', columns: ':not(.noVis)'},
    ], 
    "columnDefs": [ {
         targets: 0,
         className: 'noVis'
    } ]
});

$(document).ready(function() {
    $('<?php echo '#'.$id; ?>').DataTable({
                "order": [[ '<?php echo $col; ?>', "<?php echo $order; ?>" ]],
                   responsive: false
                });
} );
</script>