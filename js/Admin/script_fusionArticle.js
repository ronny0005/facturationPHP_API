jQuery(function($) {

    $.fn.select2.defaults.set( "theme", "bootstrap" );
    $.fn.select2.defaults.set( "maximumSelectionSize", "6" );

    $("#AR_RefAncien, #AR_RefNouveau").select2().on("select2:select", function (e) {
    });


    $('#valider').click(function () {
        if($('#AR_RefAncien').select2('data')[0].id!=$('#AR_RefNouveau').select2('data')[0].id)
            $("#formulaire").submit();
    });
});