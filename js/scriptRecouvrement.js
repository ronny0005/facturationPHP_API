jQuery(function ($) {
    var lien="../../ServeurFacturationPHP/index.php?";
    $("#dateReglementEntete_deb").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#dateReglementEntete_fin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});

    if($("#dateRec").is('[readonly]')==false)
        if ($("#flagDelai").val() != -1)
            $("#dateRec").datepicker({
                minDate: -$("#flagDelai").val(), dateFormat: "ddmmy", altFormat: "ddmmy",
                autoclose: true
            });
        else
            $("#dateRec").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});


    $("#dateRemiseBon").datepicker({dateFormat: "yy-mm-dd", altFormat: "yy-mm-dd"});
    $("#dateRemiseBon").datepicker({dateFormat:"yy-mm-dd"}).datepicker("setDate",new Date());
    if($("#dateRec").is('[readonly]')==false)
        $("#dateRec").datepicker({dateFormat:"ddmmy"}).datepicker("setDate",new Date());
    else
        $("#dateRec").val($.datepicker.formatDate('ddmmy',new Date()));
    if($_GET("dateReglementEntete_deb")==null)
        $("#dateReglementEntete_deb").datepicker({dateFormat:"ddmmy"}).datepicker("setDate",new Date());

    if($_GET("dateReglementEntete_fin")==null)
        $("#dateReglementEntete_fin").datepicker({dateFormat:"ddmmy"}).datepicker("setDate",new Date());

    var cat_tarif = 0;
    var ligneReglement="";
    var totalttc = 0;
    var totalht = 0;
    var totaltva = 0;
    var totalprecompte = 0;
    var totalmarge = 0;
    var nbarticle = 0;
    var nbreglement = 0;
    var someRC=0;
    var someRG=0;
    var somAvance=0;
    var somTtc=0;
    var somResteAPayer=0;
    var souche ="";
    var modificationReglt = false;
    var affaire="";
    var vehicule="";
    var depot="";
    var co_no="";
    var Val_RG_Piece="";
    var Mtt_RG_Piece="";
    var envoi=0;
    var mtt_reglement =0;
    var affiche =0;
    var total_reste_a_payer=0;
    var ca_souche=-1;
    var protect = 0;
    var admin=0;
    var jeton=0;
    var profilCaisse=0;
    var profilDaf=0;

    var cmp = 0;

    var rgType = 0;
    if($_GET("typeRegl")=="Fournisseur") rgType = 1;
    if($_GET("typeRegl")=="Collaborateur") rgType = 2;

    $(".custom-combobox").each(function(){
        if(cmp==0) $(this).attr("class", "comboclient");
        cmp=cmp+1;
    });

    $("#client").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&typeTiers="+rgType,
        autoFocus: true,
        select: function(event, ui) {
            event.preventDefault();
            $("#client").val(ui.item.label)
            $("#CT_Num").val(ui.item.value)
            $("#client_ligne").val(ui.item.value);

        },
        focus: function(event, ui) {
        }
    });

    function verifEntete() {
        if ($("#client option:selected").val() != "" && $("#depot").val() != "") {
            return true;
        }
        return false;
    }

    $('.message a').click(function () {
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });


    function protection(){
        $.ajax({
            url: "indexServeur.php?page=connexionProctection",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    var fich = $_GET("type");
                    admin = this.PROT_Right;
                    //if(this.ProfilName=="VENDEUR")
                    protect=1;
                    /*if(admin==1)
                        protect=0;
                    if(this.PROT_Administrator==1 || this.PROT_Right==1)
                        protect=1;*/
//                    if(this.PROT_DOCUMENT_REGLEMENT==1)
                    //                       $("#form-valider :input").prop("disabled", true);

                });
            }
        });
    }
    protection();


    //$("#confirm_change").hide();
    if($_GET("client")==null){
        $(".comboclient :input").val("");
    }

    // $("#choose_caissier").hide();
    $("#caisse").change(function(){
        infoCaisse();
        //if($_GET("typeRegl")!="Collaborateur")
        rafraichir_liste_collab();
    });
    rafraichir_liste_collab();

    $('#imprimer').click(function(){
        var tabRgNo = []
        $("tr[id^='reglement_']").each(function () {
            if($(this).find("#checkRgNo").is(':checked') )
                tabRgNo.push($(this).find("#RG_No").html())
        })

        var impression="export/exportReglementZumi.php?RG_No="+tabRgNo.join("|")+"&CT_Num="+$("#CT_Num").val()+"&datedeb="+returnDate($("#dateReglementEntete_deb").val())+"&datefin="+returnDate($("#dateReglementEntete_fin").val())+"&type="+$("#type").val()+"&mode_reglement="+$("#mode_reglement").val()+"&caisse="+$("#caisse").val()+"&typeRegl="+$_GET("typeRegl");
        window.open(impression);
    });

    function afficheReglement(date,montant,libelle,rg_no){
        var typeregl=0;
        if($_GET("typeRegl")!=undefined){
            typeregl=1;
        }
        if($("#filtre_lieu").val()==1){
            var rgType = 0;
            if($_GET("typeRegl")!="Client") rgType = 1;
            $("#confirm_change").dialog({
                resizable: false,
                height: "auto",
                width: 200,
                modal: true,
                buttons: {
                    "Oui": {
                        class: 'btn btn-primary',
                        text: 'Oui',
                        click: function () {
                            $.ajax({
                                url: "indexServeur.php?page=addReglement&bonCaisse="+typeregl+"&RG_No="+rg_no+"&CT_Num=" + $("#CT_Num").val() + "&CA_No=" + $("#caisse").val()+ "&date=" + date+ "&montant=" + montant+ "&libelle=" + libelle+"&impute=0&RG_Type="+rgType,
                                method: 'GET',
                                dataType: 'json',
                                async : false,
                                success: function(data) {
                                    window.location.replace("indexMVC.php?module=1&action=4&co_no="+$("#co_no").val()+"&client="+$("#CT_Num").val()+"&caisse="+$("#caisse").val()+"&type="+$("#type").val()+"&filtre_lieu="+$("#filtre_lieu").val()+"&rechercher=Rechercher&acte=ajoutOK");
                                },
                                error: function (resultat, statut, erreur) {
                                    alert(resultat.responseText);
                                }
                            });
                        }
                    },
                    "Non": {
                        class: 'btn btn-primary',
                        text: 'Non',
                        click: function () {
                            $( this ).dialog( "close" );
                        }
                    }
                }
            });
        }
    }


    if($_GET("acte")=="ajoutOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Le règlement a bien été transféré !</div>');
    }

    // $("#tableFacture").hide();
    $('#ajouter').click(function () {
        if (verifEntete()) {
            AjoutArticle();
        }
    })

    $('#recherche').click(function () {
        //    rechercher();
        $("#form-client").submit();
    })

    $('#validerRec').click(function () {
        valideNouveauRegl()
    })

    $("#dateRec").keydown(function (e){
        if(e.keyCode == 13)
            valideNouveauRegl()
    })

    $("#libelleRec").keydown(function (e){
        if(e.keyCode == 13)
            valideNouveauRegl()
    })

    $("#montantRec").keydown(function (e){
        if(e.keyCode == 13)
            valideNouveauRegl()
    })

    function returnDate(str){
        return "20"+str.substring(4,6)+"-"+str.substring(2,4)+"-"+str.substring(0,2);
    }

    function returnDateReverse(str){
        return str.substring(8,10)+str.substring(5,7)+str.substring(2,4);
    }

    function reverseDate(str){
        return newdate = str.split("-").reverse().join("-");
    }

    $("#client").focusout(function(){
        if($("#CT_Num").val()==-1 && $("#client").val()!="")
            $.ajax({
                url: 'indexServeur.php?page=getTiersByIntituleRglt',
                method: 'GET',
                dataType: 'json',
                data : 'CT_Intitule='+$("#client").val()+'&TypeRglt='+$_GET("typeRegl"),
                async: false,
                success: function (data) {
                    $("#CT_Num").val(data[0].CT_Num)
                }
            });
        else
            if($("#CT_Num").val()!=-1 && $("#client").val()=="")
                $("#CT_Num").val(-1)
    });

    $("#mode_reglementRec").change(function(){
        if($("#mode_reglementRec").val()!="01") {
            $.ajax({
                url: 'indexServeur.php?page=getJournauxTreso',
                method: 'GET',
                dataType: 'json',
                async: false,
                success: function (data) {
                    $("#journal").empty();
                    $.each(data, function (index, item) {
                        $("#journal").append(new Option(item.JO_Num + " - " + item.JO_Intitule, item.JO_Num));
                    });
                }
            });
        }
        else{
            $.ajax({
                url: 'indexServeur.php?page=getJournaux',
                method: 'GET',
                dataType: 'json',
                data : "JO_Sommeil=1",
                async: false,
                success: function (data) {
                    $("#journal_choix").empty();
                    $.each(data, function (index, item) {
                        $("#journal").append(new Option(item.JO_Num + " - " + item.JO_Intitule, item.JO_Num));
                    });
                }
            });
        }
    })

    function valideNouveauRegl(){
        if($("#caisse").val()!=0){
            if($("#montantRec").val().replace(/ /g,"")!="" && $("#dateRec").val()!="" ){
                if($("#CT_Num").val()!="-1" && $("#CT_Num").val()!="" ){
                    if(modificationReglt==false) {
                        if($("#mode_reglementRec").val()!="01") {
                            $.ajax({
                                url: 'indexServeur.php?page=getJournauxTreso',
                                method: 'GET',
                                dataType: 'json',
                                async: false,
                                success: function (data) {
                                    $("#journal_choix").empty();
                                    $.each(data, function (index, item) {
                                        $("#journal_choix").append(new Option(item.JO_Num + " - " + item.JO_Intitule, item.JO_Num));
                                    });
                                    $("#journal_choix").val($("#journal").val());

                                    if($("#journal_choix").val()==null)
                                        $("#journal_choix").val($("#journal_choix option:first").val());
                                }
                            });
                        }
                        else{
                            $.ajax({
                                url: 'indexServeur.php?page=getJournaux',
                                method: 'GET',
                                dataType: 'json',
                                data : "JO_Sommeil=1",
                                async: false,
                                success: function (data) {
                                    $("#journal_choix").empty();
                                    $.each(data, function (index, item) {
                                        $("#journal_choix").append(new Option(item.JO_Num + " - " + item.JO_Intitule, item.JO_Num));
                                    });
                                    $("#journal_choix").val($("#journal").val());
                                }
                            });
                        }

                        $("#choose_caissier").dialog({
                            resizable: true,
                            height: "auto",
                            modal: true,
                            buttons: {
                                "Valider": {
                                    class: 'btn btn-primary',
                                    text: 'Valider',
                                    click: function () {
                                        validerRec($("#caissier_choix").val());
                                        $(this).dialog("close");
                                        jeton = 0;
                                    }
                                }
                            }
                        });
                    }else {
                        var typeregl = 0;
                        if ($_GET("typeRegl") == "Collaborateur") {
                            typeregl = 1;
                        }
                        var caisse = $("#caisse").val();
                        var rg_no = ligneReglement.find("#RG_No").html();
                        var rgType = 0;
                        if($_GET("typeRegl")!="Client") rgType = 1;
                        $("#journal_choix").val(ligneReglement.find("#JO_Num").html());
                        $("#caissier_choix").val(ligneReglement.find("#CO_NoCaissier").html());
                        $("#choose_caissier").dialog({
                            resizable: false,
                            height: "auto",
                            width: "500",
                            modal: true,
                            buttons: {
                                "Valider": {
                                    class: 'btn btn-primary',
                                    text: 'Valider',
                                    click: function () {
                                            $.ajax({
                                                url: 'indexServeur.php?page=modifReglement&rg_no=' + rg_no + '&boncaisse=' + typeregl + '&RG_Type=' + rgType + '&CT_Num=' + $("#CT_Num").val() + "&rg_montant=" + $("#montantRec").val().replace(/ /g, "") + "&rg_libelle=" + $("#libelleRec").val() + "&CO_No=" + $("#co_no").val() + "&CA_No=" + caisse + "&rg_date=" + returnDate($("#dateRec").val()) + "&impute=0" + "&mode_reglementRec=" + $("#mode_reglementRec").val() + "&caissier=" + caissier,
                                                method: 'GET',
                                                dataType: 'html',
                                                async: false,
                                                data: "JO_Num=" + $("#journal_choix").val() + "&CO_No=" + $("#caissier_choix").val()+"&protNo="+$("#PROT_No").val(),
                                                success: function (data) {
                                                    if (data == "") {
                                                        ligneReglement.find("#RG_Date").html(returnDate($("#dateRec").val()));
                                                        ligneReglement.find("#RG_Libelle").html($("#libelleRec").val());
                                                        ligneReglement.find("#RG_Montant").html($("#montantRec").val());
                                                        ligneReglement.find("#RA_Montant").html($("#montantRec").val());
                                                        ligneReglement.find("#N_Reglement").html(Math.round($("#mode_reglementRec").val()));
                                                        $("#dateRec").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
                                                        $("#libelleRec").val("");
                                                        $("#montantRec").val("");
                                                        $("#mode_reglementRec").val("01");
                                                        modificationReglt = false;
                                                        $("#mode_reglementRec").prop('disabled', false);
                                                    } else {
                                                        alert(data);
                                                    }
                                                }
                                            });
                                            $(this).dialog("close");
                                        }
                                }
                            }
                        });

                    }
                    $("#client_valide").val($("#client").val());
                } else alert("Veuillez choissir un client !");
            } else alert("Veuillez saisir une date et un montant");
        } else alert("Veuillez choisir une caisse !");
    }

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

    function rechercherFacture(bloque) {
        if($_GET("CT_Num")!=null){
            $("#tableFacture").unbind();
            $("#tableFacture_dialog").unbind();
            $("tr[id^='facture']").each(function(){ $(this).remove(); });
            $("tr[id^='facture_dialog']").each(function(){ $(this).remove(); });

            /*if($("#mode_reglementRec").val()=="05"){
                $("#blocFacture_dialog").hide();
            }else{
                $("#blocFacture_dialog").show();
            }*/

            $("#tableFacture").show();
            infoCaisse();
            var collab = 0;
            if($_GET("typeRegl")=="Collaborateur")
                collab = 1;
            $.ajax({
                url: "indexServeur.php?page=getFactureCORecouvrement&CO_No=" + $("#co_no").val() + "&CT_Num=" + $("#CT_Num").val()+"&souche="+ca_souche+"&collab="+collab,
                method: 'GET',
                dataType: 'json',
                async : false,
                success: function (data) {
                    total_reste_a_payer=0;
                    somAvance=0;
                    somTtc=0;
                    somResteAPayer=0;
                    $("#tableFacture_dialog >tbody").html("");
                    $("#tableFacture >tbody").html("");
                    $("#tableFacture").unbind();
                    for(i=0;i<data.length;i++){
                        tableaufacture(i,data[i].cbMarq,data[i].DO_Date,data[i].DO_Piece,data[i].DO_Ref,Math.round(data[i].avance),Math.round(data[i].ttc)/*,data[i].CA_No,data[i].CO_NoCaissier*/,data[i].DO_Type,data[i].DO_Domaine);
                    }

                    $("input[id^='check_facture']").each(function(){
                        $(this).click(function() {
                            var emodeler = $(this).parent().parent();
                            var check=0;
                            if($(this).is(':checked'))
                                check = 1;
                            var ttc = parseFloat(emodeler.find("#ttc").html().replace(/ /g,"").replace(/&nbsp;/g,""));
                            var avanceReglt = parseFloat(emodeler.find("#avance").html().replace(/ /g,"").replace(/&nbsp;/g,""));
                            var libelle = emodeler.find("#libelle").html();
                            var avanceInitRglt = parseFloat(Math.round(emodeler.find("#avanceInit").html().replace(/ /g,"")));
                            calcul_montantRegle(emodeler,check,avanceReglt,ttc,avanceInitRglt);
                        });
                    });

                    $("input[id^='montant_regle']").each(function(){
                        $(this).keyup(function() {
                            var emodeler = $(this).parent().parent();
                            var avanceInit = Math.round(emodeler.find("#avanceInit").html().replace(/ /g,"").replace(/&nbsp;/g,""));
                            var n_mtt_reglement = Mtt_RG_Piece;
                            var mtt_ttc =Math.round(emodeler.find("[id^='ttc']").html().replace(/ /g,"").replace(/&nbsp;/g,""));
                            var mtt_regle = emodeler.find("[id^='montant_regle']").val().replace(/ /g,"").replace(/&nbsp;/g,"");
                            var libelle = emodeler.find("[id^='libelle']").html();
                            if(mtt_regle!=""){
                                if(mtt_regle<=mtt_ttc){
                                    n_mtt_reglement=n_mtt_reglement-mtt_regle;
                                    $('#montant_reglement').html(n_mtt_reglement);
                                    var new_val = 0;
                                    if(emodeler.find("#montant_regle").val().replace(/ /g,"").replace(/&nbsp;/g,"")!="")
                                        new_val= Math.round(emodeler.find("#montant_regle").val().replace(/ /g,"").replace(/&nbsp;/g,""));
                                    //                            var mtt_reglement = Math.round($('#montant_reglement').html());
                                    var n_avance = avanceInit + new_val;
                                    emodeler.find("#avance").html(n_avance);
                                }else {
                                    alert("Le montant de la facutre "+libelle+" doit être inférieure à "+ mtt_ttc+" !");
                                    $(this).find("[id^='montant_regle']").val(mtt_ttc);
                                }
                            }
                            //calculMttRegleRestant();

                        });
                    });
                    $("#tableFacture > tbody").append("<tr id='facture_dialog_Total' style='background-color:grey;color:white;font-weight:bold'><td>Total</td><td></td><td></td><td class='text-right' >"+(somAvance)+"</td><td class='text-right' >"+(somTtc)+"</td><td class='text-right' >"+(somResteAPayer)+"</td></tr>");
                    $("#tableFacture_dialog > tbody").append("<tr id='facture_Total' style='background-color:grey;color:white;font-weight:bold'><td>Total</td><td></td><td></td><td></td><td class='text-right' >"+(somAvance)+"</td><td class='text-right' >"+(somTtc)+"</td><td></td></tr>");
                    if(bloque)
                        bloqueFacture();
                    $("#total_reste").html("Total rete à payer : <b>"+(total_reste_a_payer)+"</b>");
                }
            });
//            $("#tableFacture_dialog").append("</table>");
//            $("#tableFacture").append("</table>");
            $("#tableFacture").show();

        }
    }

    rechercherFacture(true);

    function bloqueFacture(){
        $("#form_facture :input").prop("disabled", true);
    }

    function tableaufacture(cmp,cbMarq,DO_Date,DO_Piece,DO_Ref,avance,ttc,do_type,do_domaine){
        var classe = "";
        total_reste_a_payer = total_reste_a_payer + (ttc-avance);
        somAvance= somAvance+ avance;
        somTtc= somTtc +ttc;
        somResteAPayer= somResteAPayer + (ttc-avance);
        if (cmp % 2 == 0)
            classe = "info";
        else classe = "";
        $("#tableFacture_dialog > tbody").append("<tr id='facture' class= 'facture " + classe + "'>" +
            "<td><input type='checkbox' id='check_facture' value='0'/></td>" +
            "<td>"+$.datepicker.formatDate('dd-mm-yy', new Date(DO_Date))+"</td>" +
            "<td id='libelle'>" + DO_Piece + "</td>\n\
            <td>" + DO_Ref + "</td>" +
            "<td class='text-right' id='avance'>" + (avance)+ "</td>" +
            "<td class='text-right' id='ttc'>" + (ttc) + "</td>" +
            "<td><input type='text' class='form-control' id='montant_regle' disabled/>" +
            "<span style='display: none' id='avanceInit'>" + (avance)+ "</span></td>" +
            "<td style='display: none'><span style='display: none' id='DoType'>" + do_type + "</span><span style='display: none' id='cbMarqEntete'>" + cbMarq + "</span></td>" +
            "<td style='display: none'><span style='display: none' id='DoDomaine'>" + do_domaine + "</span></td>" +
            "</tr>").on('click', '#facture', function () {

        });
        $("#tableFacture > tbody").append("<tr id='facture_dialog' class= 'facture " + classe + "'><td>"+$.datepicker.formatDate('dd-mm-yy', new Date(DO_Date))+"</td><td id='libelleS'>" + DO_Piece + "</td>\n\
            <td>" + DO_Ref + "</td><td id='avanceS' class='text-right' >" + (avance)+ "</td><td id='ttcS' class='text-right' >" + (ttc)+ "</td><td class='text-right' >"+((ttc-avance))+"</td></tr>").on('click', '#facture_', function () {
        });

    }

    function calculMttRegleRestant(){
        var n_mtt_reglement = Mtt_RG_Piece;
        $("tr[id^='facture']").each(function() {
            var mtt_ttc =Math.round($(this).find("[id^='ttc']").html());
            var mtt_regle = $(this).find("[id^='montant_regle']").val();
            var libelle = $(this).find("[id^='libelle']").html();
            if(mtt_regle!=""){
                if(mtt_regle<=mtt_ttc){
                    n_mtt_reglement=n_mtt_reglement-mtt_regle;
                    $('#montant_reglement').html(n_mtt_reglement);
                }else {
                    alert("Le montant de la facutre "+libelle+" doit être inférieure à "+ (mtt_ttc)+" !");
                    $(this).find("[id^='montant_regle']").val((mtt_ttc));
                }
            }
        });
    }

    function infoCaisse(){
        $.ajax({
            url: "indexServeur.php?page=getCaisseByCA_No&CA_No=" + $("#caisse").val(),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function (data) {
                if($("#caisse").val()!=0) {
                    if (data.CA_Souche != 0)
                        ca_souche = data.CA_Souche;
                    $("#journal").val(data.JO_Num);
                }
                else
                    ca_souche = -1;
            }
        });
    }
    infoCaisse();
    function rafraichir_liste_collab(){
        $.ajax({
            url: "indexServeur.php?page=getCaissierByCaisse&CA_No=" + $("#caisse").val(),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $("#caissier_choix").empty();
                $.each(data, function(index, item) {
                    $("#caissier_choix").append(new Option(item.CO_Nom,item.CO_No));
                });
            }
        });
    }

    function calcul_montantRegle(emodeler,check,avance,ttc,avanceInit){
        if(check){
            emodeler.find('#montant_regle').prop("disabled",false);
            var mtt_reglement = ($("#montant_reglement").html().replace(/&nbsp;/g,"").replace(/ /g,""));
            var reste_a_payer = ttc - avance;
            if(mtt_reglement-reste_a_payer>=0){
                mtt_reglement = mtt_reglement-reste_a_payer;
                emodeler.find('#montant_regle').val(ttc-avance);
                avance= ttc;
            }else{
                avance=parseFloat(avance) + parseFloat(mtt_reglement);
                reste_a_payer=mtt_reglement;
                emodeler.find('#montant_regle').val(mtt_reglement);
                mtt_reglement=0;
            }
            emodeler.find("#avance").html(avance);
            $("#montant_reglement").html(mtt_reglement);
        }else{
            emodeler.find('#montant_regle').prop("disabled",true);
            emodeler.find('#montant_regle').val("");
            var mtt_reglement = (Math.round($("#montant_reglement").html().replace(/&nbsp;/g,"").replace(/ /g,"")));
            var mtt_regle = avance-avanceInit;
            var total = mtt_reglement+mtt_regle;
            $("#montant_reglement").html((total));
            emodeler.find("#avance").html((avanceInit));
        }
    }

    $("#valide_facture").click(function(){

    });

    function regle_facture(Val_RG_Piece,cbMarqEntete,mtt_regle){
        var mtt_regl = mtt_regle;
        var type_regl = $_GET("typeRegl");

        $.ajax({
            url: "indexServeur.php?page=addEcheance&protNo="+$("#PROT_No").val()+"&type_regl="+type_regl+"&cr_no="+Val_RG_Piece+"&montant="+mtt_regl+"&cbMarqEntete="+cbMarqEntete,
            method: 'GET',
            dataType: 'html',
            async : false,
            success: function (data) {
                $.ajax({
                    url: "indexServeur.php?page=updateImpute&RG_No="+Val_RG_Piece,
                    method: 'GET',
                    dataType: 'html',
                    async : false,
                    success: function (data) {
                        $.ajax({
                            url: "indexServeur.php?page=updateDrRegleByDOPiece&cbMarq="+cbMarqEntete,
                            method: 'GET',
                            dataType: 'html',
                            async : false,
                            success: function (data) {
                                rechercher();
                                rechercherFacture(true);
                            }
                        })
                    }
                })
            }
        })
    }

    function returnDate(str){
        return "20"+str.substring(4,6)+"-"+str.substring(2,4)+"-"+str.substring(0,2);
    }

    function rechercher() {
        $("#tableRecouvrement").unbind("click");
        var collab = 0;
        var typeSelectType = 0;
        if($_GET("typeRegl")=="Collaborateur") collab = 1;
        if($_GET("typeRegl")!="Client") typeSelectType = 1;
        $.ajax({
            url: 'indexServeur.php?page=getReglementByClient&collaborateur='+collab+'&caissier='+$("#caissier").val()+'&CT_Num=' + $("#CT_Num").val()+'&datedeb=' + returnDate($("#dateReglementEntete_deb").val())+'&datefin=' + returnDate($("#dateReglementEntete_fin").val())+'&CA_No=' + $("#caisse").val()+'&type='+$("#type").val()+'&treglement='+$("#mode_reglement").val(),
            method: 'GET',
            dataType: 'json',
            data : "typeSelectRegl="+typeSelectType,
            async : false,
            success: function (data) {
                someRG=0;
                someRC=0;
                $(".reglement").remove();
                for(i=0;i<data.length;i++)
                    tableauRecouvrement(i,data[i].RG_No,data[i].RG_Date,data[i].RG_Libelle,Math.round(data[i].RG_Montant),Math.round(data[i].RC_Montant),data[i].CA_Intitule,data[i].CO_Nom,data[i].RG_Impute,data[i].RG_Piece,data[i].N_Reglement,data[i].CO_NoCaissier,data[i].JO_Num,data[i].DO_Modif,data[i].cbCreateur);
                $("#tableRecouvrement").append("<tr class='reglement' style='background-color:grey;color:white;font-weight:bold'><td>Total</td><td></td><td></td><td></td><td></td><td class='text-right'>"+someRG+"</td><td class='text-right'>"+someRC+"</td><td class='text-right'>"+(someRG-someRC)+"</td><td></td><td></td><td></td></tr>");
                //if(admin==1 || $("#caisse").is(":disabled"))
                actionReglement ();
            }
        });
    }

    function tableauRecouvrement(classe,RG_No,RG_Date,RG_Libelle,RG_Montant,RC_Montant,CA_No,CO_NoCaissier,RG_Impute,RG_Piece,N_Reglement,CO_No,JO_Num,DO_Modif,cbCreateur){
        if (i % 2 == 0)
            classe = "info";
        var texteSuppr="";
        var texteProtected="";
        if($("#protectionPage").html()==true)
            texteProtected="<td id='modifRG_Piece'><i class='fa fa-pencil fa-fw'></i></td>";
        if($("#protectionSupprPage").html()==true)
            texteSuppr = "<td id='supprRG_Piece'><i class='fa fa-trash-o'></i></td>";

        $("#tableRecouvrement").append("<tr class= 'reglement " + classe + "' id='reglement_" + RG_No + "'>"+texteProtected+texteSuppr+"<td id='RG_Piece' style='color:blue;text-decoration: underline;'>"+RG_Piece+"</td><td id='RG_Date'>" + $.datepicker.formatDate('yy-mm-dd', new Date(RG_Date)) + "</td>\n\
                                        <td id='RG_Libelle'>" + RG_Libelle + "</td><td id='RG_Montant' class='text-right'>" + (RG_Montant) + "</td><td id='RC_Montant' class='text-right'>" + (RC_Montant) + "</td><td id='RA_Montant' class='text-right'>" + ((RG_Montant-RC_Montant)) + "</td>\n\
                                         <td id='CA_NoTable'>" + CA_No + "</td>" +
            "<td><span style='display:none' id='N_Reglement'>"+N_Reglement+"</span>" + CO_NoCaissier + "</td><td>"+cbCreateur+"</td>"+
            "<td style='display:none' id='RG_No'>"+RG_No+"</td><td style='display:none' id='RG_Impute'>"+RG_Impute+"</td><td style='display:none' id='CO_NoCaissier'>"+CO_No+"</td>"+
            "<td style='display:none' id='JO_Num'>"+JO_Num+"</td><td style='display:none' id='DO_Modif'>"+DO_Modif+"</td></tr>").on('click', '#reglement_'+RG_No, function () {
        });
        someRC=someRC+RC_Montant;
        someRG=someRG+RG_Montant;
    }
    //$("#blocFactureRGNO").hide();
    function actionReglement (){
        $("tr[id^='reglement']").each(function() {
            $(this).find("#RG_Piece").unbind();
            $(this).find("#RG_Piece").click(function(){
                var RC_Montant = $(this).parent().find("#RC_Montant").html().replace(/ /g,"").replace(/&nbsp;/g,"");
                var RA_Montant = $(this).parent().find("#RA_Montant").html().replace(/ /g,"").replace(/&nbsp;/g,"");
                var RG_No = $(this).parent().find("#RG_No").html();
                var N_Reglement = $(this).parent().find("#N_Reglement").html();
                var RG_Impute = $(this).parent().find("#RG_Impute").html();
                var CA_NoTable = $(this).parent().find("#CA_NoTable").html();
                Mtt_RG_Piece=$(this).parent().find("#RG_Montant").html().replace(/ /g,"").replace(/&nbsp;/g,"")-$(this).parent().find("#RC_Montant").html().replace(/ /g,"").replace(/&nbsp;/g,"");
                Val_RG_Piece=$(this).parent().find("#RG_No").html();
                $("#Val_RG_Piece").val(Val_RG_Piece);


                $("<div></div>").dialog({
                    resizable: true,
                    height: "auto",
                    modal: true,
                    buttons: {
                        "Remboursement règlement": {
                            class: 'btn btn-primary col',
                            text: 'Remboursement règlement',
                            click: function () {
                                if ($("#flagCtrlTtCaisse").val() == 0) {
                                    if ($("#protectionPage").html() == true) {
                                        $(this).dialog("close");
                                        $("#dateRemboursement").datepicker({
                                            dateFormat: "ddmmy",
                                            altFormat: "ddmmy"
                                        });
                                        $("#dateRemboursement").datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
                                        $("#mttRemboursement").val(RA_Montant);
                                        $("#blocRemboursementRglt").dialog({
                                            resizable: false,
                                            height: "auto",
                                            width: 300,
                                            title: "Information remboursement",
                                            modal: true,
                                            buttons: {
                                                "Valider": {
                                                    class: 'btn btn-primary',
                                                    text: 'Valider',
                                                    click: function () {
                                                        if (parseFloat($("#mttRemboursement").val().replace(/ /g, "").replace(/ /g, "&nbsp;")) <= parseFloat(RA_Montant)) {
                                                            $.ajax({
                                                                url: 'indexServeur.php?page=remboursementRglt',
                                                                method: 'GET',
                                                                dataType: '',
                                                                async: false,
                                                                data: "RG_No=" + RG_No + "&RG_Montant=" + $("#mttRemboursement").val().replace(/ /g, "") + "&RG_Date=" + returnDate($("#dateRemboursement").val()),
                                                                success: function (data) {
                                                                    location.reload(true);
                                                                },
                                                                error: function (resultat, statut, erreur) {
                                                                    alert(resultat.responseText);
                                                                }
                                                            });
                                                            $(this).dialog("close");
                                                        } else {
                                                            alert("le montant du remboursement ne peut pas dépasser " + RA_Montant);
                                                        }
                                                    }
                                                },
                                                "Annuler": {
                                                    class: 'btn btn-primary',
                                                    text: 'Annuler',
                                                    click: function () {
                                                        $(this).dialog("close");
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }
                            }
                        },
                        "Régler facture": {
                            class: 'btn btn-primary col',
                            text: 'Régler facture',
                            click: function () {
                                if ($("#protectionPage").html() == true) {
                                    $(this).dialog("close");
                                    if (RA_Montant > 0)
                                        if (/*protect == 1 && */(N_Reglement != 10 || ((N_Reglement != "5" && N_Reglement != "10") && RG_Impute == "0") || (N_Reglement == "5" && CA_NoTable != ""))) {
                                            if ($_GET("typeRegl") == "Collaborateur" && Mtt_RG_Piece != 0) {
                                                $("<div></div>").dialog({
                                                    resizable: false,
                                                    height: "auto",
                                                    width: 500,
                                                    modal: true,
                                                    buttons: {
                                                        "Régler une facture": {
                                                            class: 'btn btn-primary',
                                                            text: 'Régler une facture',
                                                            click: function () {
                                                                afficheDialogue()
                                                                $(this).dialog("close")
                                                            }
                                                        },
                                                        "Générer un bon de caisse": {
                                                            class: 'btn btn-primary',
                                                            text: 'Générer un bon de caisse',
                                                            click: function () {
                                                                $(this).dialog("close");
                                                                $("#dateRemiseBon").datepicker({
                                                                    dateFormat: "yy-mm-dd",
                                                                    altFormat: "yy-mm-dd"
                                                                });
                                                                $("#dateRemiseBon").datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
                                                                var rgType = 0;
                                                                if ($_GET("typeRegl") != "Client") rgType = 1;

                                                                $("#blocDateRemiseBon").dialog({
                                                                    resizable: false,
                                                                    height: "auto",
                                                                    width: 300,
                                                                    title: "Date remise de bon de caisse",
                                                                    modal: true,
                                                                    buttons: {
                                                                        "Valider": {
                                                                            class: 'btn btn-primary',
                                                                            text: 'Valider',
                                                                            click: function () {
                                                                                $.ajax({
                                                                                    url: 'indexServeur.php?page=addReglement&boncaisse=' + 1 + '&RG_Type=' + rgType + '&CT_Num=' + $("#CT_Num").val() + "&montant=" + Mtt_RG_Piece + "&libelle=Remise_bon_de_caisse_" + RG_No + "_" + $(".comboclient").val() + "&CO_No=" + $("#co_no").val() + "&CA_No=0&date=" + $("#dateRemiseBon").val() + "&impute=0&mode_reglementRec=10&caissier=0&RG_NoLier=" + RG_No,
                                                                                    method: 'GET',
                                                                                    dataType: 'json',
                                                                                    async: false,
                                                                                    success: function (data) {
                                                                                        if ($("#mode_reglementRec").val() == "10") {

                                                                                        }
                                                                                        location.reload(true);
                                                                                        rechercher();
                                                                                        rechercherFacture(true);
                                                                                        $("#dateRec").val("");
                                                                                        $("#libelleRec").val("");
                                                                                        $("#montantRec").val("");
                                                                                    },
                                                                                    error: function (resultat, statut, erreur) {
                                                                                        alert(resultat.responseText);
                                                                                    }
                                                                                });
                                                                                $(this).dialog("close");
                                                                            }
                                                                        }
                                                                    }
                                                                });
                                                                $(this).dialog("close");
                                                            }
                                                        }
                                                    }
                                                });
                                            } else {
                                                afficheDialogue();
                                            }
                                        }
                                }
                            }
                        },
                        "Voir facture réglée": {
                            class: 'btn btn-primary col',
                            text: 'Voir facture réglée',
                            click: function () {
                                $("#blocFactureRGNO").show();
                                $("#ListefactureRGNO").unbind();
                                $("#ListefactureRGNO").html("");
                                $.ajax({
                                    url: "indexServeur.php?page=getFactureRGNo&RG_No=" + RG_No,
                                    method: 'GET',
                                    dataType: 'json',
                                    async: false,
                                    success: function (data) {
                                        $(data).each(function () {
                                            var classe = "";
                                            var texteSuppr = "";
                                            if ($("#protectionSupprPage").html() == true)
                                                texteSuppr = "<td id='supprFacRglt'><i class='fa fa-trash-o'></i></td>";
                                            $("#ListefactureRGNO").append("<tr class='factureRGNO' id='factureRGNO' class= 'facture " + classe + "'><td>" + $.datepicker.formatDate('dd-mm-yy', new Date(this.DO_Date)) + "</td><td id='libelleRGNO'>" + this.DO_Piece + "</td>\n\
                                <td>" + this.DO_Ref + "</td><td class='text-right' id='avanceRGNO'>" + (this.avance) + "</td><td id='ttcRGNO' class='text-right' >" + (this.ttc) + "</td>" + texteSuppr + "<td id='cbMarqEntete' style='display:none'>" + this.cbMarq + "</td></tr>");
                                        });
                                        $("#blocFactureRGNO").dialog({
                                            resizable: false,
                                            height: "auto",
                                            width: "500",
                                            modal: true
                                        });
                                        supprRegltFact(RG_No);
                                    }
                                });
                                $(this).dialog("close");
                            }
                        }
                    }
                });


                if(protect==1 && N_Reglement=="5" && CA_NoTable==""){
                    $("#blocTransfert").dialog({
                        resizable: false,
                        height: "auto",
                        width: 700,
                        modal: true,
                        buttons: {
                            "Valider": {
                                class: 'btn btn-primary',
                                text: 'Valider',
                                click: function () {
                                    $.ajax({
                                        url: "indexServeur.php?page=convertTransToRegl&CA_No=" + $("#caisseTransfert").val() + "&RG_No=" + $("#Val_RG_Piece").val(),
                                        method: 'GET',
                                        dataType: 'html',
                                        async: false,
                                        success: function (data) {
                                            rechercher();
                                            afficheDialogue();
                                        }
                                    });
                                    $(this).dialog("close");
                                }

                            }
                        }
                    });
                }
                if(RG_Impute==0){
                    Val_RG_Piece=$(this).find("#RG_No").html();
                    afficheReglement($(this).find("#RG_Date").html(),$(this).find("#RG_Montant").html(),$(this).find("#RG_Libelle").html(),Val_RG_Piece);
                }
            });
            if($("#protectionPage").html()==true)
                $(this).find("#modifRG_Piece").click(function() {
                    var rg_date = $(this).parent("tr").find("#RG_Date").html();
                    var rg_montant = $(this).parent("tr").find("#RG_Montant").html();
                    var rc_montant = $(this).parent("tr").find("#RC_Montant").html();
                    var rg_libelle = $(this).parent("tr").find("#RG_Libelle").html();
                    var mode_reglementRec = "0" + $(this).parent("tr").find("#N_Reglement").html();
                    var caisse = $(this).parent("tr").find("#CA_NoTable").html();
                    if (rc_montant == 0) {
                        if($(this).parent("tr").find("#DO_Modif").html()==0) {
                            var rgDate = new Date(reverseDate(rg_date));
                            $("#dateRec").val($.format.date(rgDate,"ddMMyy"));
                            $("#libelleRec").val(rg_libelle);
                            $("#montantRec").val(rg_montant);
                            $("#mode_reglementRec").val(mode_reglementRec);
                            $("#caisse option").each(function () {
                                this.selected = $(this).text() == caisse;
                            });
                            ligneReglement = $(this).parent("tr");
                            //$("#mode_reglementRec").prop('disabled', true);
                            modificationReglt = true;
                        }else{
                            alert("La date de modification du document est dépassé ! Veuillez contacter un administrateur.");
                        }
                    }else alert("Désolé ce règlement est lettré !");
                });

            if($("#protectionPage").html()==true)
                $(this).find("#supprRG_Piece").click(function() {
                    var elem = $(this).parent("tr");
                    var rc_montant = $(this).parent("tr").find("#RC_Montant").html();
                    var piece = $(this).parent("tr").find("#RG_Piece").html();
                    var rgNo = $(this).parent("tr").find("#RG_No").html();
                    if(rc_montant==0) {
                        $("<div>Voulez vous supprimer le règlement " + piece + " ?</div>").dialog({
                            resizable: false,
                            height: "auto",
                            width: 500,
                            modal: true,
                            buttons: {
                                "Oui": {
                                    class: 'btn btn-primary',
                                    text: 'Oui',
                                    click: function () {
                                        $.ajax({
                                            url: "indexServeur.php?page=supprReglement&RG_No=" + rgNo,
                                            method: 'GET',
                                            async: false,
                                            dataType: 'html',
                                            success: function (data) {
                                                if (data == "")
                                                    elem.fadeOut(300, function () {
                                                        this.remove();
                                                    });
                                                else
                                                    alert(data);
                                            }
                                        });
                                        $(this).dialog("close");
                                    }
                                },
                                "Non": {
                                    class: 'btn btn-primary',
                                    text: 'Non',
                                    click: function () {
                                        $(this).dialog("close");
                                    }
                                }
                            }
                        });
                    } else {
                        alert("Ce reglement est lettré, la suppression n'est pas disponible !");
                    }
                });
        });
    }

    actionReglement ();

    $("#montantRec").inputmask({
        'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: false
    });

    function supprRegltFact(RG_No) {
        $("td[id^='supprFacRglt']").each(function () {
            var elem = $(this).parent();
            $(this).click(function () {
                $("<div>Voulez vous supprimer cette facture du règlement ?</div>").dialog({
                    resizable: false,
                    height: "auto",
                    width: 700,
                    modal: true,
                    buttons: {
                        "Valider": {
                            class: 'btn btn-primary',
                            text: 'Valider',
                            click: function () {
                                var do_piece = elem.find("#libelleRGNO").html();
                                var cbMarqEntete = elem.find("#cbMarqEntete").html();
                                $.ajax({
                                    url: 'indexServeur.php?page=removeFacRglt&RG_No=' + RG_No + '&DO_Piece=' + do_piece + "&cbMarqEntete=" + cbMarqEntete,
                                    method: 'GET',
                                    dataType: 'html',
                                    async: false,
                                    success: function (data) {
                                        if (data == "") {
                                            elem.fadeOut(300, function () {
                                                $(this).remove();
                                            });
                                            rechercher();
                                            rechercherFacture(true);
                                        } else {
                                            alert(data);
                                        }

                                    }
                                });
                                $(this).dialog("close");

                            }
                        },
                        "Annuler": {
                            class: 'btn btn-primary',
                            text: 'Annuler',
                            click: function () {
                                $(this).dialog("close");
                            }
                        }
                    }
                });
            });
        });
    }

    function afficheDialogue(){
        affiche=1;
        rechercherFacture(false);
        envoi = 1;
        $("#montant_reglement").html((Mtt_RG_Piece));
        mtt_reglement = Mtt_RG_Piece;
        var provRG=$("#Val_RG_Piece").val();
        $("#blocFacture_dialog").dialog({
            resizable: true,
            height: "auto",
            width: "700",
            modal: true,
            buttons: {
                "Valider": {
                    class: 'btn btn-primary',
                    text: 'Valider',
                    click: function () {
                        $("#tableFacture_dialog").each(function () {
                            $(this).find("tr[id='facture']").each(function () {
                                var cbMarqEntete = $(this).find("[id^='cbMarqEntete']").html();
                                var mtt_regle = $(this).find("[id^='montant_regle']").val().replace(/ /g, "").replace(/&nbsp;/g, "");
                                if (mtt_regle != "" && $(this).find("[id^='check_facture']").is(':checked')) {
                                    regle_facture(provRG, cbMarqEntete, mtt_regle);
                                }
                            });
                        });
                        rechercherFacture(true);
                        $(this).dialog("close");
                    }
                }
            }
        });
    }

    function vide() {
        $(".article").remove();
        $("#date").val('');
        $("#client").val('');
        $("#designation").val('');
        $("#qte").val('');
    }
    function validerRec(caissier) {
        var typeregl=0;
        if($_GET("typeRegl")=="Collaborateur"){
            typeregl=1;
            //caissier = $("#client").val();
        }
        var caisse = $("#caisse").val();
        var rgType = 0;
        if($_GET("typeRegl")!="Client") rgType = 1;

//        $("#client_ligne").val($("#CT_Num").val());
        $("#dateReglementEntete_deb_ligne").val($("#dateReglementEntete_deb").val());
        $("#dateReglementEntete_fin_ligne").val($("#dateReglementEntete_fin").val());
        $("#mode_reglement_ligne").val($("#mode_reglement").val());
        $("#journal_ligne").val($("#journal").val());
        $("#caisse_ligne").val($("#caisse").val());
        $("#type_ligne").val($("#type").val());
        $("#caissier_ligne").val(caissier);
        $("#journal_ligne").val($("#journal_choix").val());
        $("#boncaisse_ligne").val(typeregl);
        $("#rgnolier_ligne").val(0);
        $("#typeRegl_ligne").val($_GET("typeRegl"));
        $("#formValider").submit();
        /*
        $.ajax({
            url: 'indexServeur.php?page=addReglement&boncaisse='+typeregl+'&RG_Type='+rgType+'&JO_Num='+$("#journal_choix").val()+'&CT_Num=' + $("#client").val()+"&montant="+ $("#montantRec").val().replace(/ /g,"")+"&libelle="+$("#libelleRec").val()+"&CO_No="+$("#co_no").val()+"&CA_No="+caisse+"&date="+returnDate($("#dateRec").val())+"&impute=0"+"&mode_reglementRec="+$("#mode_reglementRec").val()+"&caissier="+caissier,
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function (data) {
                if($("#mode_reglementRec").val()=="10"){

                }
                rechercher();
                rechercherFacture(true);
                $("#dateRec").val("");
                $("#libelleRec").val("");
                $("#montantRec").val("");
            },
            error: function (resultat, statut, erreur) {
                alert(resultat.responseText);
            }
        });
        */
    }
    $("#collaborateur").combobox();


});