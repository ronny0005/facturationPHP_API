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
    
    $('#ajouterClient').click(function(){
        ajouterClient();
    });
 
    
if($_GET("acte")=="ajoutOK"){
    $("#add_err").css('display', 'inline', 'important');
    $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>'+$_GET("CA_No")+' a bien été enregistré !</div>');
}

if($_GET("acte")=="modifOK"){
    $("#add_err").css('display', 'inline', 'important');
    $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>'+$_GET("CA_No")+' a bien été modifié !</div>');
}

if($_GET("acte")=="supprOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>'+$_GET("CA_No")+' a bien été supprimé !</div>');
}


if($_GET("acte")=="supprKO"){
    $("#add_err").css('display', 'inline', 'important');
    $("#add_err").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La suppression de '+$_GET("CA_No")+' a échoué !</div>');
}

    $("#table").DataTable(
        {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            },
            fixedHeader: {
                header: true,
                footer: true
            },
            "initComplete": function(settings, json) {
                $("#table_filter").find(":input").addClass("form-control");
                $("#table_length").find(":input").addClass("form-control");
            }

        }
    );



});