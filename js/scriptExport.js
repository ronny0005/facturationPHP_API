jQuery(function($){ 
//var lien="http://localhost:1821/ServeurFacturationPHP/index.php?";
    var lien="../../ServeurFacturationPHP/index.php?";
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
        if($_GET("DO_Piece")!=null){
            
        listeArticle();
        $("#ajouter").hide();
        $("#annuler").hide();
        $("#valider").hide();
        $.ajax({
            url: lien+'page=clients&op='+$_GET("CT_Num"),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                    $(".comboclient").val(data[0].CT_Intitule);
            }
        });
        $(".comboclient").prop('disabled', true);
        
       $.ajax({
            url: lien + 'page=getReglementByClientFacture&CT_Num=' + $_GET("CT_Num")+'&DO_Piece='+$_GET("Do_Piece"),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $(".reglement").remove();
                for(i=0;i<data.length;i++)
                    tableauRecouvrement(i,data[i].RG_No,data[i].RG_Date,data[i].RG_Libelle,Math.round(data[i].RG_Montant),Math.round(data[i].RC_Montant),data[i].CA_No,data[i].CO_NoCaissier);
            }
        });
        $.ajax({
            url: lien+'page=clients&op='+$_GET("CT_Num"),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                cat_tarif=data[0].N_CatTarif;
                cat_compta=data[0].N_CatCompta;
                $("#cat_tarif").val(data[0].LibCatTarif);
                $("#cat_compta").val(data[0].LibCatCompta);
            }
        });
    }
    
    function listeArticle(){
        $.ajax({
            url: lien + 'page=getLigneFacture&DO_Piece=' + $_GET("DO_Piece"),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                for(i=0;i<data.length;i++){
                        var classe = "";
                        if (i % 2 == 0)
                            classe = "info";
                        $( "#table" ).append( "<tr class='article "+classe+"'><td style=''>"+data[i].AR_Ref+"</td>\n\
                                        <td style=''>"+data[i].DL_Design+"</td><td style='text-align:right'>"+Math.round(data[i].DL_Qte)+"</td><td style='text-align:center'>"+data[i].DL_PrixUnitaire+"</td>\n\
<td style='text-align:right'>"+Math.round(data[i].DL_MontantTTC)+"</td></tr>");
                    }
            }
        });
    }

});