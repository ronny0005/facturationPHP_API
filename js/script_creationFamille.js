jQuery(function($){
        var modification=0;
        var prixCond=0;
        var protect=0;

    $("#CodeSelect").combobox();
    $("#CodeSelect").parent().find(".custom-combobox :input").attr("id", "codeSelection");
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
    
    $('#ajouter').click(function(){
        ajouterFamille();
    });
        
    function protection(){
    $.ajax({
       url: "indexServeur.php?page=connexionProctection",
       method: 'GET',
       dataType: 'json',
        success: function(data) {
            $(data).each(function() {
                protect=this.PROT_FAMILLE;
                if(protect==1){
                    $('#reference').prop('disabled', true);
                    $('#designation').prop('disabled', true);
                    $('#catalniv1').prop('disabled', true);
                    $('#catalniv2').prop('disabled', true);
                    $('#ajouter').prop('disabled', true);
                }
            });
        }
    });
    }
    
    protection();  
    
    function ajouterFamille(){
        if($_GET("FA_CodeFamille")!=null){
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_famille&FA_CodeFamille='+$_GET("FA_CodeFamille")+'&intitule='+$("#designation").val()+'&niv=1&catal1='+$("#catalniv1").val()+'&catal2='+$("#catalniv2").val()+'&catal3='+$("#catalniv3").val()+'&catal4='+$("#catalniv4").val()+'&val='+$("#catalniv1").val()+"&PROT_No="+$("#PROT_No").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    window.location.replace("indexMVC.php?module=3&action=6&acte=modifOK&codeFAM="+data.codeFAM);
                }
            });
        }   else{ 
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_famille&FA_CodeFamille='+$("#reference").val()+'&intitule='+$("#designation").val()+'&niv=1&catal1='+$("#catalniv1").val()+'&catal2='+$("#catalniv2").val()+'&catal3='+$("#catalniv3").val()+'&catal4='+$("#catalniv4").val()+'&val='+$("#catalniv1").val()+"&PROT_No="+$("#PROT_No").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    window.location.replace("indexMVC.php?module=3&action=6&acte=ajoutOK&codeFAM="+data.codeFAM);
                },
                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                } 
            }); 
        }
    }
    
    $('#catalniv1 option').click(function() {
        $('#catalniv2').html("<option value=0></option>");
        $.ajax({
            url: 'traitement/Creation.php?acte=modif_famille&valide=0&FA_CodeFamille='+$_GET("FA_CodeFamille")+'&niv=1&catal1='+$("#catalniv1").val()+'&val='+$("#catalniv1").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    $('#catalniv2').append("<option value="+this.CL_No+">"+this.CL_Intitule+"</option>");
                    $('#catalniv2').prop('disabled', false);
                });
                $("#catalniv2").bind("click");
                $("#catalniv2").click(function(){
                   clikCatalogue2(); 
                });
            }
        });
    });    

    function clikCatalogue2(){
        $('#catalniv3').html("<option value=0></option>");
        $.ajax({
            url: 'traitement/Creation.php?acte=modif_famille&valide=0&FA_CodeFamille='+$_GET("FA_CodeFamille")+'&niv=2&catal1='+$("#catalniv2").val()+'&val='+$("#catalniv2").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    $('#catalniv3').append("<option value="+this.CL_No+">"+this.CL_Intitule+"</option>");
                    $('#catalniv3').prop('disabled', false);
                });
                $("#catalniv3").unbind("click");
                $("#catalniv3").click(function(){
                   clikCatalogue3(); 
                });
            }
        });
    }
    
    function clikCatalogue3(){
        $('#catalniv4').html("<option value=0></option>");
        $.ajax({
            url: 'traitement/Creation.php?acte=modif_famille&valide=0&FA_CodeFamille='+$_GET("FA_CodeFamille")+'&niv=3&catal1='+$("#catalniv3").val()+'&val='+$("#catalniv3").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    $('#catalniv4').append("<option value="+this.CL_No+">"+this.CL_Intitule+"</option>");
                    $('#catalniv4').prop('disabled', false);
                });
            }
        });
    }

    $("#p_catcompta").change(function() {
        var type = $(this).val().slice(-1);
        var fcp_type = 0;
        if(type=="A")
            fcp_type=1;
        var acp_champ = $(this).val().replace(type,"");
        $.ajax({
            url: "indexServeur.php?page=getCatComptaByCodeFamille&ACP_Type="+fcp_type+"&ACP_Champ="+acp_champ+"&FA_CodeFamille="+$("#reference").val(),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $("#table_compteg >tbody").html("");
                var cg_num = " - ";
                var cg_numa = " - ";
                var cgnumIntitule ="";
                var cgnumIntitulea ="";
                var taxe1 = " - ";
                var taxe2 = " - ";
                var taxe3 = " - ";
                var taxeIntitule1 = "";
                var taxeIntitule2 = "";
                var taxeIntitule3 = "";
                var taxe2 = " - ";
                var taxe3 = " - ";
                var taux1 = 0;
                var taux2 = 0;
                var taux3 = 0;
                if(data[0]!=undefined){
                    if(data[0].CG_Num!="")cg_num = data[0].CG_Num;
                    if(data[0].CG_NumA!="")cg_numa = data[0].CG_NumA;
                    if(data[0].Taxe1!="")taxe1 = data[0].Taxe1;
                    if(data[0].Taxe2!="")taxe2 = data[0].Taxe2;
                    if(data[0].Taxe3!="")taxe3 = data[0].Taxe3;
                    cgnumIntitule =data[0].CG_Intitule;
                    cgnumIntitulea =data[0].CG_IntituleA;
                    taxeIntitule1 = data[0].TA_Intitule1;
                    taxeIntitule2 = data[0].TA_Intitule2;
                    taxeIntitule3 = data[0].TA_Intitule3;
                    taux1 = (Math.round(data[0].TA_Taux1*100)/100);
                    taux2 = (Math.round(data[0].TA_Taux2*100)/100);
                    taux3 = (Math.round(data[0].TA_Taux3*100)/100);
                }
                var donnee ="<tr><td id='libCompte'>Compte général</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+cg_num+"</td><td id='intituleCompte'>"+cgnumIntitule+"</td><td id='valCompte'></td></tr>"+
                    "<tr><td id='libCompte'>Section analytique</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+cg_numa+"</td><td id='intituleCompte'>"+cgnumIntitulea+"</td><td id='valCompte'></td></tr>"+
                    "<tr><td id='libCompte'>Code taxe 1</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+ taxe1 +"</td><td id='intituleCompte'>"+ taxeIntitule1 +"</td><td id='valCompte'>"+ taux1 +"</td></tr>"+
                    "<tr><td id='libCompte'>Code taxe 2</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+ taxe2 +"</td><td id='intituleCompte'>"+ taxeIntitule2 +"</td><td id='valCompte'>"+ taux2 +"</td></tr>"+
                    "<tr><td id='libCompte'>Code taxe 3</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+ taxe3 +"</td><td id='intituleCompte'>"+ taxeIntitule3 +"</td><td id='valCompte'>"+ taux3 +"</td></tr>";
                $("#table_compteg >tbody").append(donnee);
                fonctionCodeCompte();
            }
        });
    });

    function getCompteg(emodeler,compte) {
        $.ajax({
            url: "indexServeur.php?page=getCompteg",
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                $("#CodeSelect").empty();
                $("#codeSelection").unbind("keydown");
                $.each(data, function (index, item) {
                    $("#CodeSelect").append(new Option("", ""));
                    $("#CodeSelect").append(new Option(item.CG_Num + " - " + item.CG_Intitule, item.CG_Num));
                });

                $("#codeSelection").keydown(function (event) {
                    if(event.keyCode == 13)
                        selection (emodeler,compte);
                });
            }
        });
    }

    function getTaxe(emodeler,compte) {
        $.ajax({
            url: "indexServeur.php?page=getF_Taxe",
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                $("#CodeSelect").empty();
                $("#CodeSelect").append(new Option("", ""));
                $("#codeSelection").unbind("keydown");
                $.each(data, function (index, item) {
                    $("#CodeSelect").append(new Option(item.TA_Code + " - " + item.TA_Intitule, item.TA_Code));
                });
                $("#codeSelection").keydown(function (event) {
                    if(event.keyCode == 13)
                        selection (emodeler,compte);
                });
            }
        });
    }

    function getTaxeByCode(emodeler,val) {
        $.ajax({
            url: "indexServeur.php?page=getTaxeByTACode&TA_Code="+val,
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                if(val=="") {
                    emodeler.parent().find("#intituleCompte").html("");
                    emodeler.parent().find("#valCompte").html("");
                }else{
                    emodeler.parent().find("#intituleCompte").html(data[0].TA_Intitule);
                    emodeler.parent().find("#valCompte").html(Math.round(data[0].TA_Taux * 100) / 100);
                }
            }
        });
    }

    function getComptegByCode(emodeler,val) {
        $.ajax({
            url: "indexServeur.php?page=getPlanComptableByCGNum&CG_Num="+val,
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                if(val=="") {
                    emodeler.parent().find("#intituleCompte").html("");
                }else{
                    emodeler.parent().find("#intituleCompte").html(data[0].CG_Intitule);
                }
            }
        });
    }

    function insertF_ArtCompta(acp_champ,acp_type,cg_num,cg_numa,ta_code1,ta_code2,ta_code3) {
        $.ajax({
            url: "indexServeur.php?page=insertF_FamCompta",
            method: 'GET',
            dataType: 'json',
            async: false,
            data : 'FA_CodeFamille='+$("#reference").val()+'&FCP_Champ='+acp_champ+'&FCP_Type='+acp_type+'&CG_Num='+cg_num+'&CG_NumA='+cg_numa+'&TA_Code1='+ta_code1+'&TA_Code2='+ta_code2+'&TA_Code3='+ta_code3,
            success: function (data) {
                if(data=="") {
                    alert("la modification a bien été pris en compte !");
                    $("#codeSelection").val("");
                }
                else{
                    alert(data);
                }
            }
        });
    }

    function fonctionCodeCompte() {
        $("td[id^='codeCompte']").each(function () {
            var emodeler = $(this);
            var compte = $(this).parent().find("#libCompte").html();
            var intitule= $(this).parent().find("#intituleCompte").html();
            $(this).click(function () {
                $("#labelCode").html(compte);
                if (compte == "Code taxe 1" || compte == "Code taxe 2" || compte == "Code taxe 3")
                    getTaxe(emodeler,compte);
                else
                    getCompteg(emodeler,compte);
                $("#CodeSelect").val($(this).html());
                $("#codeSelection").val($(this).html()+" - "+intitule);
            });
        });
    }
    fonctionCodeCompte();

    function selection (emodeler,compte){
        var type ="";
        var acp_type=0;
        var acp_champ = "";
        var compteg = "";var comptea = "";var taxe1 = "";var taxe2 = "";var taxe3 = "";
        type = $("#p_catcompta").val().slice(-1);
        if(type=="A")
            acp_type=1;
        acp_champ = $("#p_catcompta").val().replace(type,"");
        var compteval = " - ";
        if($("#CodeSelect").val()!=null) compteval = $("#CodeSelect").val();
        emodeler.parent().find("#codeCompte").html(compteval);
        $("#table_compteg >tbody").find("tr").each(function(){
            if($(this).find("#libCompte").html()=="Compte général"){
                compteg = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Compte analytique"){
                comptea = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Code taxe 1"){
                taxe1 = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Code taxe 2"){
                taxe2 = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Code taxe 3"){
                taxe3 = $(this).find("#codeCompte").html();
            }
        });
        if (compte == "Code taxe 1" || compte == "Code taxe 2" || compte == "Code taxe 3")
            getTaxeByCode(emodeler, $("#CodeSelect").val());
        else
            getComptegByCode(emodeler, $("#CodeSelect").val());
        insertF_ArtCompta(acp_champ,acp_type,compteg,comptea,taxe1,taxe2,taxe3);
    }
    fonctionCodeCompte();

});