jQuery(function($){  
   /*$('#table').dynatable({
    inputs: {

        queryEvent: 'keyup'
    }
}).bind('dynatable:afterProcess', referencement());
*/
    var lien = 2;
    var typeTiers = "0";
    var sommeil = 0;
    if($_GET("sommeil")!=undefined)
        sommeil = $_GET("sommeil");
    if($_GET("action")=="8"){
        lien=9;
        typeTiers = "1";
    }

    if($_GET("action")=="16"){
        lien=17;
        typeTiers = "2";
    }

        var donnee = [
            {"data": "CT_Num",
                "render": function(data, type, row, meta) {
                    if (type === 'display') {
                        data = '<a href="indexMVC.php?module=3&action='+lien+'&CT_Num=' + data + '">' + data + '</a>';
                    }
                    return data;
                }
            },
            {"data": "CT_Intitule"},
            {"data": "CG_NumPrinc"},
            {"data": "LibCatTarif"},
            {"data": "LibCatCompta"},
        ];
        var suppr = {"data" : "CT_Num","render": function(data, type, row, meta) {
                if (type === 'display') {
                    data = "<a href='Traitement\\Creation.php?acte=suppr_client&type="+typeTiers+"&CT_Num="+data+"' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer " + data+" ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a>";
                }//
                return data;
            }}

    if($("#supprProtected").val()==1)
        donnee.push(suppr);

    if($("#flagCreateur").val()==1) {
        donnee.push({
            "data": "PROT_User",
            "render": function (data, type, row, meta) {
                if (data == null) return "";
                else
                    return data;
            }
        });
    }

    $('#users').DataTable({
            "responsive": true,
            "columns": donnee,
            "processing": true,
            "serverSide": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            },
            "ajax": {
                url: 'traitement/Creation.php?acte=listeClient&CT_Type='+typeTiers+'&CT_Sommeil='+sommeil,
                type: 'POST'
            },
            "initComplete": function(settings, json) {
                $("#users_filter").find(":input").addClass("form-control");
                $("#users_length").find(":input").addClass("form-control");
                $("#searchBar").append($("#users_filter"))
                $("#numberRow").append($("#users_length"))
            }
        });
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


$("#sommeil").change(function(){
    window.location.replace("indexMVC.php?module="+$_GET("module")+"&action="+$_GET("action")+"&sommeil="+$(this).val());
});

if($_GET("acte")=="ajoutOK"){
    if($_GET("action")=="4") {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Le client '+$_GET("CT_Num")+' a bien été enregistré!</div>');
    }
    else {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Le fournisseur '+$_GET("CT_Num")+' a bien été enregistré!</div>');
    }
}


if($_GET("acte")=="modifOK"){
    if($_GET("action")=="4") {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Le client '+$_GET("CT_Num")+' a bien été modifié!</div>');
    }
    else {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Le fournisseur '+$_GET("CT_Num")+' a bien été modifié!</div>');
    }
}

if($_GET("acte")=="supprOK"){
    if($_GET("action")=="4") {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Le client '+$_GET("CT_Num")+' a bien été supprimé !</div>');
    }
    else {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Le fournisseur '+$_GET("CT_Num")+' a bien été supprimé !</div>');
    }
}


if($_GET("acte")=="supprKO"){
    if($_GET("action")=="4") {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La suppression du client '+$_GET("CT_Num")+' a échoué !</div>');
    }
    else {
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La suppression du fournisseur '+$_GET("CT_Num")+'  a échoué !</div>');
    }
}
function referencement(){
    $("table.table > tbody > tr").on('dblclick', function() {
        var type =2;
        if($_GET("action")==8) type=9;
        document.location.href = "indexMVC.php?module=3&action="+type+"&CT_Num="+$(this).find("td a").html();
    }); 
}

referencement();
$("#dynatable-query-search-table").keyup(function(e){
    referencement(); 
});

var protect = 0;
  
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    if($_GET("action")=="8")
                    protect=this.PROT_FOURNISSEUR;
                        else
                    protect=this.PROT_CLIENT;
                    if(protect==1){
                        $("#nouveau").prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection();    
});