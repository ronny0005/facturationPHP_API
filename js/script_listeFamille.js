jQuery(function($){  

 function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace( 
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;	
    }
    return vars;
}

if($_GET("acte")=="ajoutOK"){
    $("#add_err").css('display', 'inline', 'important');
    $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La famille '+$_GET("codeFAM")+' a bien été enregistrée !</div>');
}

if($_GET("acte")=="modifOK"){
    $("#add_err").css('display', 'inline', 'important');
    $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La famille '+$_GET("codeFAM")+' a bien été modifiée !</div>');    
}

if($_GET("acte")=="supprOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La famille '+$_GET("codeFAM")+' a bien été supprimée !</div>');
}


if($_GET("acte")=="supprKO"){
    $("#add_err").css('display', 'inline', 'important');
    $("#add_err").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La suppression de la famille '+$_GET("codeFAM")+' a échoué !</div>');
}


$('#table').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    },
    "initComplete": function(settings, json) {
        $("#table_filter").find(":input").addClass("form-control");
        $("#table_length").find(":input").addClass("form-control");
    }
});
/*
$('#table').dynatable({
    inputs: {
        queryEvent: 'keyup'
    }
}).bind('dynatable:afterProcess', referencement());

*/
    var protect = 0;
  
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_FAMILLE;
                    if(protect==1){
                        $("#nouveau").prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection();
    
function referencement(){
    $("table.table > tbody > tr").on('dblclick', function() {
        document.location.href = "indexMVC.php?module=3&action=7&FA_CodeFamille="+$(this).find("td ").html();
    }); 
}
referencement();
});