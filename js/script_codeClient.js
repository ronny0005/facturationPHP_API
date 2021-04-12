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
    
    $('#nouveau').click(function(){
        $("#blocCode").append('<div id="groupCode" style="clear:both"><div class="form-group col-lg-3" ><label> Code : </label>'+
                            '<input maxlength="13" type="text" name="code[]" class="form-control" id="code" placeholder="Code" /></div>'+
                    '<div class="form-group col-lg-3" ><label> Libellé : </label>'+
                '<input maxlength="50" type="text" name="libelle[]" class="form-control" id="libelle" placeholder="Libellé"/></div>'+
               '<div class="form-group col-lg-3" ><label> Type : </label><select name="type[]" class="form-control" id="type">'+
                        '<option value="0">Client</option><option value="1">Fournisseur</option></select></div>'+
                        '<div class="form-group col-lg-3" ><i class="fa fa-trash-o"></i></div>'+
                '</div>').on('click','.fa-trash-o', function () {
                    $(this).parent().parent().remove();
                });
    });
    
    $('.fa-trash-o').click(function(){
        $(this).parent().parent().remove();
    });
    $('#valider').click(function(){
        $.ajax({
            url: 'indexServeur.php?page=ajoutCodeClient',
            method: 'GET',
            dataType: 'html',
            data : $("#codeClient").serialize(),
            success: function(data) {
                window.location.replace("indexMVC.php?module=1&action=1");
            } 
        });
    });
});