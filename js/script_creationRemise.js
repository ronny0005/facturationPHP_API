jQuery(function($){
        var protect=0;
        var type =0;
    var modificationArticle = 0;
    var modificationClient = 0;
    var modificationJusqua = 0;
    var modificationRemise = 0;
    var position = 0;

    $("#TF_DateDeb").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#TF_DateFin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
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
    
    $('#ajouterDepot').click(function(){
        ajouterDepot();
    });

    $("#a_appliquer").change(function(){
        setDate();
    });

    function setDate(){
        $("#TF_DateDeb").val("");
        $("#TF_DateFin").val("");
        if($("#a_appliquer").val()==0) {
            $("#TF_DateDeb").prop("disabled",true);
        }
        else
            $("#TF_DateDeb").prop("disabled",false);

        if($("#a_appliquer").val()==0 || $("#a_appliquer").val()==1) {
            $("#TF_DateFin").prop("disabled",true);
        }
        else
            $("#TF_DateFin").prop("disabled",false);
    }
    setDate();

    $("#Objectif").change(function(){
        montantGlobal();
    });

    $("#Calcul").change(function(){
        montantGlobal();
    });
    montantGlobal();

    $("#ChoixJusqua").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        'rightAlign': true,
        'digitsOptional': false,
        'placeholder': '0.00'
    });

    function montantGlobal(){
        if($("#Objectif").val()==0)
            $("#Calcul").prop("disabled",true);
        else
            $("#Calcul").prop("disabled",false);

        if($("#Calcul").val()==0)
            $("#Objectif").prop("disabled",true);
        else
            $("#Objectif").prop("disabled",false);

    }

    function ajouterRemise(){
        var TF_No = $_GET("TF_No");
        var typeData = "ajout_remise";
        var msgData = "ajoutOK";
        if(TF_No!=null) {
            typeData = "modif_remise";
            msgData = "modifOK";
        }
        $.ajax({
            url: 'traitement/Creation.php?acte='+typeData,
            method: 'GET',
            dataType: 'json',
            data : $("#formRemise").serialize(),
            success: function(data) {
                window.location.replace("indexMVC.php?module=3&action=10&acte="+msgData+"&TF_No="+data.TF_No);
            }
        });
    }

    function listeCharge(type,valeur){
        var typeData="ListeFamilleRemise";
        if(type==1)
            typeData="listeArticleRemise";
        if(type==2)
            typeData="listeCategRemise";
        if(type==3)
            typeData="ListeClientRemise";
        if(type==1 || type==0) {
            $("#ChoixArticleSelect").html("");
            $("#comboArticleSelect").val("");
        }
        else {
            $("#ChoixClientSelect").html("");
            $("#comboClientSelect").val("");
        }
        var selected="";
        $.ajax({
            url: 'traitement/Creation.php?acte='+typeData,
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                $.each(data, function (index, item) {
                    selected = "";

                    if(type==1 || type==0) {
                        if (type == 1) {
                            if(valeur==item.AR_Ref)
                                selected="selected";
                            $("#ChoixArticleSelect").append("<option value='" + item.AR_Ref + "' "+selected+">" + item.AR_Ref + " - " + item.AR_Design + "</option>");
                        }
                        else {
                            if(valeur==item.FA_CodeFamille)
                                selected="selected";
                            $("#ChoixArticleSelect").append("<option value='" + item.FA_CodeFamille + "' "+selected+">" + item.FA_CodeFamille + " - " + item.FA_Intitule + "</option>");
                        }
                    }else {
                        if (type == 3) {
                            if(valeur==item.CT_Num)
                                selected="selected";
                            $("#ChoixClientSelect").append("<option value='" + item.CT_Num + "' " + selected + ">" + item.CT_Num + " - " + item.CT_Intitule + "</option>");
                        } else {
                            if(valeur==item.id)
                                selected="selected";
                            $("#ChoixClientSelect").append("<option value='" + item.id + "' " + selected + ">" + item.CT_Intitule + "</option>");
                        }
                    }
                });

                if(valeur !=""){
                    if(type==1 || type==0) {
                        $("#comboArticleSelect").val($("#ChoixArticleSelect").find("option:selected").text());
                    }
                    else{
                        $("#comboClientSelect").val($("#ChoixClientSelect").find("option:selected").text());
                    }
                }
            }
        });
    }

    listeCharge($("#ChoixArticle").val(),"");
    listeCharge($("#ChoixClient").val(),"");

    $("#ChoixArticle").change(function(){
        listeCharge($(this).val(),"");
    });
    $("#ChoixClient").change(function(){
        listeCharge($(this).val(),"");
    });

    $("#ArticleRemise").combobox();
    $("#ChoixClientSelect").combobox();
    $("#ChoixArticleSelect").combobox();
    var cmp = 0;

    $(".custom-combobox").each(function () {
        if (cmp == 0){
            $(this).find(":input").attr("id", "comboArticleSelect");
            $("#comboArticleSelect").parent().css("width","75%");
            $("#comboArticleSelect").parent().css("float", "left");
        }
        if (cmp == 1){
            $(this).find(":input").attr("id", "comboClientSelect");
            $("#comboClientSelect").parent().css("width","75%");
            $("#comboClientSelect").parent().css("float", "left");
        }
        if (cmp == 2){
            $(this).find(":input").attr("id", "comboArticleRemise");
        }
        cmp = cmp + 1;
    });

    $("#ListArticle").click(function(){
        $(this).prop("disabled","true");
        modificationArticle = 1;
        $("#ChoixArticle").val($(this).val());
        var data = $(this).find("option:selected").text();
        var tableData = data.split(":");
        listeCharge($(this).val(),tableData[1].trim());
    });

    $("#ListJusquaMontant").click(function(){
        $(this).prop("disabled","true");
        modificationJusqua = 1;
        $("#ChoixJusqua").val($(this).find("option:selected").text());
    });

    $("#ListJusquaRemise").click(function(){
        $(this).prop("disabled","true");
        modificationRemise = 1;
        $("#ChoixJRemise").val($(this).find("option:selected").text());
    });

    $("#ListClient").click(function(){
        $(this).prop("disabled","true");
        modificationClient = 1;
        $("#ChoixClient").val($(this).val());
        var data = $(this).find("option:selected").text();
        var tableData = data.split(":");
        listeCharge($(this).val(),tableData[1].trim());
    });

    $("#comboArticleSelect").keydown(function (event) {
        var saisie= "Article : ";
        if(event.keyCode == 13){
            var bool = verif($("#ListArticle option"),$("#ChoixArticleSelect").val());
            if(bool==true){
                alert("L'élément "+$("#ChoixArticleSelect").val()+" est déjà affecté !");
            }else {
                if ($("#ChoixArticle").val() == 0)
                    saisie = "Famille : ";
                saisie = saisie + $("#ChoixArticleSelect").val();
                if(modificationArticle==1) {
                    $("#ListArticle").prop("disabled", false);
                    $("#ListArticle").find("option:selected").html("<option value ='" + $("#ChoixArticle").val() + "'>" + saisie + "</option>");
                }
                else
                    $("#ListArticle").append("<option value ='" + $("#ChoixArticle").val() + "'>" + saisie + "</option>");
                $(this).val("");
                modificationArticle=0;
            }
        }
    });

    $("#comboClientSelect").keydown(function (event) {
        var saisie= "Client : ";
        if(event.keyCode == 13){
            var bool = verif($("#ListClient option"),$("#ChoixClientSelect").val());
            if(bool==true){
                alert("L'élément "+$("#ChoixClientSelect").val()+" est déjà affecté !");
            }else {
                if ($("#ChoixClient").val() == 2)
                    saisie = "Catégorie : ";
                saisie = saisie + $("#ChoixClientSelect").val();
                if(modificationClient==1) {
                    $("#ListClient").prop("disabled", false);
                    $("#ListClient").find("option:selected").html("<option value ='" + $("#ChoixClient").val() + "'>" + saisie + "</option>");
                }
                else
                    $("#ListClient").append("<option value ='" + $("#ChoixClient").val() + "'>" + saisie + "</option>");
                $(this).val("");
                modificationClient=0;
            }
        }
    });

    $("#ChoixJusqua").keydown(function (event) {
        if (event.keyCode == 13) {
            if(modificationJusqua==1) {
                $("#ListJusquaMontant").prop("disabled", false);
                $("#ListJusquaMontant").find("option:selected").html("<option value ='" + $("#ListJusquaMontant").find("option:selected").val() + "'>" + $("#ChoixJusqua").val() + "</option>");
            }
            else
                $("#ListJusquaMontant").append("<option value ='0'>" + $("#ChoixJusqua").val() + "</option>");
            $(this).val("");
            modificationJusqua=0;
        }
    });

    $("#ChoixJRemise").keydown(function (event) {
        if (event.keyCode == 13) {
            if(modificationRemise==1) {
                $("#ListJusquaRemise").prop("disabled", false);
                $("#ListJusquaRemise").find("option:selected").html("<option value ='" + $("#ListJusquaRemise").find("option:selected").val() + "'>" + $("#ChoixJRemise").val() + "</option>");
            }
            else
                $("#ListJusquaRemise").append("<option value ='0'>" + $("#ChoixJRemise").val() + "</option>");
            $(this).val("");
            modificationRemise =0;
        }
    });

    function verif(element,valtest){
        var cherche = "";
        var bool = false;
        element.each(function(){
            cherche = $(this).text().split(":");
            if(cherche[1].trim()==valtest.trim()){
                bool =true;
            }
        });
            return bool;
    }

    $("#ajouterRemise").click(function(){
        var listArticle ="";
        var listClient ="";
        var ListeMontantRemise ="";
        var ListValRemise ="";
        $("#ListArticle option").each(function()
        {
            listArticle = listArticle+","+$(this).text();
        });
        $("#ListClient option").each(function()
        {
            listClient = listClient+","+$(this).text();
        });
        $("#ListJusquaMontant option").each(function()
        {
            ListeMontantRemise = ListeMontantRemise+","+$(this).text().replace(" ","");
        });
        $("#ListJusquaRemise option").each(function()
        {
            ListValRemise  = ListValRemise +","+$(this).text();
        });
        var tf_interes = 2;
        var tf_domaine = 0;
        var tf_base = 0;
        var tf_type = 1;
        var typeAjout = "ajout_Remise";
        var cbMarq = 0;
        if($_GET("cbMarq")!=undefined) {
            typeAjout="modif_Remise";
            cbMarq = $_GET("cbMarq");
        }
        $.ajax({
            url: 'traitement/Creation.php?acte='+typeAjout+'&ListeArticle='+listArticle+"&ListeClient="+listClient+"&cbMarq="+cbMarq
                    +"&TF_Interes="+tf_interes+"&TF_Domaine="+tf_domaine+"&TF_Base="+tf_base+"&TF_Type="+tf_type+"&ListeMontantRemise="+ListeMontantRemise+"&ListValRemise="+ListValRemise ,
            method: 'GET',
            dataType: 'json',
            data : $("#formEnteteRemise").serialize(),
            success: function(data) {
                window.location.replace("indexMVC.php?module=3&action=18&acte=modifOK&TF_No="+data.TF_No);
            }
        });
    });

});