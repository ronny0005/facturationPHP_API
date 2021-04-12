jQuery(function($){

        var protect=0;
        var type =0;
            
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
    
    $('#Ajouter').click(function(){
        Ajouter();
    });
        
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DEPOT;
                    if(protect==1){
                        $('#intitule').prop('disabled', true);
                        $('#adresse').prop('disabled', true);
                        $('#complement').prop('disabled', true);
                        $('#cp').prop('disabled', true);
                        $('#region').prop('disabled', true);
                        $('#pays').prop('disabled', true);
                        $('#responsable').prop('disabled', true);
                        $('#cat_compta').prop('disabled', true);
                        $('#code_depot').prop('disabled', true);
                        $('#tel').prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection();  

    function Ajouter(){
        if($_GET("TA_Code")==null){
            var num ='';
            $.ajax({
                url: 'traitement/Structure/Comptabilite/Taxe.php?acte=ajout',
                method: 'GET',
                dataType: 'json',
                data : $("#formTaxe").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=5&acte=ajoutOK&TA_Code="+data.TA_Code);
                } 
            }); 
        }else {
            var num ='';
            var ta_code=$_GET("TA_Code");
            $.ajax({
                url: 'traitement/Structure/Comptabilite/Taxe.php?acte=modif&TA_Code='+ta_code,
                method: 'GET',
                dataType: 'json',
                data : $("#formTaxe").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=9&action=5&acte=modifOK&TA_Code="+data.TA_Code);
                } 
            });
        }
    }     
});