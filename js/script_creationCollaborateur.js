jQuery(function($){
    var protect=0;
            
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
    
    $('#valider').click(function(){
        Valider();
    });
        
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_COLLABORATEUR;
                    if(protect==1){
                        $("#formCollab :input").prop("disabled", true);
                    }
                });
            }
        });
    }
    
    protection();  
    
    function Valider(){
        if($_GET("CO_No")==null){
            $.ajax({
                url: 'traitement/Collaborateur.php?acte=ajout&PROT_No='+$("#PROT_No").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formCollab").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=3&action=12&acte=ajoutOK&CO_No="+data.CO_No);
                },
                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }
            }); 
        }else {
            $.ajax({
                url: 'traitement/Collaborateur.php?acte=modif&PROT_No='+$("#PROT_No").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formCollab").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=3&action=12&acte=modifOK&CO_No="+data.CO_No);
                } 
            });
        }
    }
        
});