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

    $('#ajouterUser').click(function(e){
        e.preventDefault();
        ajouterUser();
    });

    async function ajouterUser(){
        if($_GET("id")==null){
            $("#add_err").css('display', 'none', 'important');
            await $.ajax({
                url: 'traitement/Creation.php?acte=ajout_user',
                method: 'GET',
                dataType: 'json',
                data : $("#formUser").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=8&action=1&Prot_No="+data.Prot_No);
                }
            });
        }else {
            $("#add_err").css('display', 'none', 'important');
            await $.ajax({
                url: 'traitement/Creation.php?acte=modif_user',//&username='+$("#username").val()+'&description='+$("#description").val()+'&id='+$_GET("id")+'&password='+$("#password").val()+'&email='+$("#email").val()+'&groupeid='+$("#groupeid").val()+'&profiluser='+$("#profiluser").val()+'&changepass='+$("#changepass").val()+'&depot='+$("#depot").val()+'&caisse='+$("#caisse").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formUser").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=8&action=1&Prot_No="+data.Prot_No);
                }
                ,error : function(data) {
                }
            });
        }
    }

    tablePrincipal = "";
    function setSelectedPrincipaux(){
        $(tablePrincipal).each(function() {
            $('#depotprincipal option[value="'+$(this)[0].DE_No+'"]').attr("selected", "selected");
        //    $('#depotprincipal option[value="'+$(this)[0].DE_No+'"]');
        });
    }

    function getPrincipal(){
        $.ajax({
            url: "indexServeur.php?page=getPrincipalDepot",
            method: 'GET',
            dataType: 'json',
            data: "id="+$("#id").val(),
            success: function(data) {
                tablePrincipal = data;
            }
        });
    }

    getPrincipal();

    $("#clearEmpl").click(function(){
        clearEmpl()
    })
    function clearEmpl(){
        $("#emplacement option:selected").removeAttr("selected");
    }

    function getDepotSoucheCaisse(caisse,depot,souche){
        $.ajax({
           url: "indexServeur.php?page=getCaisseDepotSouche",
           method: 'GET',
           dataType: 'json',
           data: "CA_No="+caisse+"&DE_No="+depot+"&CA_Souche="+souche,
           success: function(data) {
                $(data).each(function() {
                    $("#depot").val(this.DE_No);
                    $("#caisse").val(this.CA_No);
                    $("#souche").val(this.CA_Souche);
                });
            }
        });
    }

    function initEmplacement(){
        listId = [];
        $("#emplacement").empty()
        $("#depotprincipal :selected").each(function() {
            listId.push($(this).val())
        })

        $.ajax({
            url: "indexServeur.php?page=setListEmplacement",
            method: 'GET',
            dataType: 'json',
            data: "listId="+listId+"&PROT_No="+$("#id").val(),
            success: function(data) {
                $.each(data, function(i, item) {
                    var selected = "";
                    if(item.IsSelect == 1) selected = "selected";
                    var option = "<option value='"+item.DP_No+"' "+selected+">"+item.DP_Intitule+"</option>"
                    $("#emplacement").append(option)
                })
            }
        })
    }

    initEmplacement()

    $("#depot").change(function(){
        $("#depotprincipal").empty();
        $("#depot > option:selected").each(function(){
            $("#depotprincipal").append(new Option($(this).text(),$(this).val()));
        });
        setSelectedPrincipaux();
    });

    $("#depot").change(function(){
//       getDepotSoucheCaisse(0,$("#depot").val(),0);
    })

})