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
    
    $("table.table > tbody > tr #protright").on('change', function() {
        $.ajax({
            url: 'traitement/Creation.php?acte=modif_groupe&cmd='+$(this).parent().parent().find("#cmd").val()+'&protno='+$(this).parent().parent().find("#protno").val()+'&protright='+$(this).parent().parent().find("#protright").val()+"&u="+$(this).parent().parent().find("#u").val()+"&gu="+$(this).parent().parent().find("#gu").val(),
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                if(data.length==0){
                    window.location.replace("indexMVC.php?module=8&action=3&id="+$("#protno").val()+"&u="+$("#u").val()+"&gu="+$("#gu").val()+"");
                }else alert("Erreur à l'insertion !");
            } 
        });
    });
//    $('form.ajax1').click(function(e){
//        e.preventDefault();
//        var datas = $(this).serialize();
//            $.ajax({
//                url: 'traitement/Creation.php?acte=modif_groupe&cmd='+$("#cmd").val()+'&protno='+$("#protno").val()+'&protright='+$("#protright").val()+"&u="+$("#u").val()+"&gu="+$("#gu").val(),
//                method: 'POST',
//                dataType: 'json',
//                data: datas,
//                success: function(data) {
//                    if(data.length==0){
//                        window.location.replace("indexMVC.php?module=8&action=3&id="+$("#protno").val()+"&u="+$("#u").val()+"&gu="+$("#gu").val()+"");
//                    }else alert("Erreur à l'insertion !");
//                } 
//            });
//    });
        
     
       
});