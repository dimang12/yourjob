$(document).ready(function(){
	$('.carousel').carousel();

    $( "#txtSearch" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: baseUrl + "/application/ajax/search",
                dataType: "json",
                data: {
                    s: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            log( ui.item ?
                "Selected: " + ui.item.label :
                "Nothing selected, input was " + this.value);
        }
//        open: function() {
//            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
//        },
//        close: function() {
//            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
//        }
    });

});