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

    $("tr[id^='ligneTENo']").each(function () {
        $(this).find("#blocValue").each(function () {
            $(this).click(function(){
                var PROT_No = $(this).parent().find("#PROT_No").html();
                var PROT_No_Profil = $(this).parent().find("#PROT_No_Profil").html();
                var check = 0;
                if($(this).find(":input").prop('checked'))check=1;
                var TE_No = $(this).find("#TE_No").html();
                var pageData = 'configMail';
                if($("#boolenvoiMail").val()==0) pageData = 'configSMS';
                    $.ajax({
                        url: 'indexServeur.php',
                        method: 'GET',
                        dataType: 'html',
                        data: 'page='+pageData+'&PROT_No=' + PROT_No + "&TE_No=" + TE_No+"&PROT_No_Profil="+PROT_No_Profil+"&Check="+check,
                        async: false,
                        success: function (data) {
                            if(PROT_No==0){
                                $("span[id^='PROT_No_Profil']").each(function(){
                                    if($(this).html()==PROT_No_Profil) {
                                        var element = $(this).parent().parent();
                                        element.find("td:eq("+TE_No+")").find(":input").prop( "checked", check);
                                    }
                                });
                            }
                        }
                    });
            });
        });
    });
});