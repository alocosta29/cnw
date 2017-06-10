   






       $(function() {
        var name = $( "#name" ),
            email = $( "#email" ),
            password = $( "#password" ),
            allFields = $( [] ).add( name ).add( email ).add( password ),
            tips = $( ".validateTips" );
 
        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }
 
        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }
        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
 
        $( "#dialog-form" ).dialog({
            autoOpen: true,
           
            width: "350",
            modal: true,
            show: "blind",
               
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
        $("#btCloseFlashDivPopUp").click(function() {
        	$( '#dialog-form' ).dialog( 'close' );
        });
        
 
        $( "#dialog-form2" ).dialog({
            autoOpen: false,
            modal: true,
            
            show: "blind",
            hide: "explode",
			width: "800",
			height: "500"
 
        });
		
		
        $( "#pesquisar" )
            .button()
            .click(function() {
                $( "#dialog-form2" ).dialog( "open" );
            });  
        
        
        
        
        
        
        
        
        
        
        
        
        $( "#create-user" )
            .button()
            .click(function() {
                $( "#dialog-form" ).dialog( "open" );
            });
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    });





