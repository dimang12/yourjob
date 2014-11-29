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

function setValueToField(d, cls){
    $( cls + ' .form-control').each(function(k,v){
        n = $(v).attr('name');
        $(v).val(d[n]);
    });
}

function getValueFromField(cls){
    var values = '';
    $(cls + ' .form-control').each(function(k,v){
        n = $(v).attr('name');
        values+= n+'='+$(v).val()+'&';
    });
    return values;
}

function popitup(url) {
    newwindow=window.open(url,'name','height=450,width=600,top=300px,left=350px');
    if (window.focus) {newwindow.focus()}
    return false;
}