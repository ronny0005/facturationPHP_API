jQuery(function($) {

    $.fn.select2.defaults.set( "theme", "bootstrap" );
    $.fn.select2.defaults.set( "maximumSelectionSize", "6" );

    $("#CT_NumAncien, #CT_NumNouveau").select2().on("select2:select", function (e) {
    });


    $('#valider').click(function () {
        if($('#CT_NumAncien').select2('data')[0].id!=$('#CT_NumNouveau').select2('data')[0].id)
            $("#formulaire").submit();
    });
});