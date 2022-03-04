jQuery(function($) {
    var latitude = 0;
    var longitude = 0;
    var pmin = 0;
    var pmax = 0;
    var qtegros= 0;
    var protect = 0;
    var modification = false;
    var listeFacture = "";
    var impressionFacture = "";
    var impressionFactureTTC = "";
    var societe = "";
    var profilvendeur = 0;
    var EC_MontantImpute = 0;
    var totalMontantA = 0;
    var EC_QteImpute = 0;
    var totalQteA = 0;
    var cbMarqLigne = 0;
    var admin = $("#isAdmin").val();
    var typeStock = 0;
    var isModif = $("#isModif").val()
    var isVisu = $("#isVisu").val()
    var protectDate = $("#protectDate").val()
    //var protectionprix = 0;
    var negatif = true;
    var prot_no = $("#PROT_No").val()
    let doModif = $("#DO_Modif").val()
    var typeFacture = $("#typeDocument").val()
    var typeFac = typeFacture;

    if((typeFacture=="Vente" || typeFacture=="BonLivraison" || typeFacture=="VenteC" || typeFacture=="Achat" || typeFacture=="AchatC")&& $("#qte_negative").val()!=0)
        negatif = false;


    $("#libelleCtNum").click(function(){
        fiche_client($(this).html());
    });

    function getDateecheanceSelect(){
        $.ajax({
            url: "indexServeur.php?page=getDateEcheanceSelectSage&N_Reglement="+$("#mode_reglement_val").val()+"&MR_No="+$("#modele_reglement_val").val()+"&Date="+returnDate($("#dateentete").val()),
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function(data) {
                $("#date_ech").val(data[0].date_ech);
            },
            error: function (data){
                $("#date_ech").val($("#dateentete").val());
            }
        });
    }

    $("#modele_reglement_val").change(function(){
        getDateecheanceSelect();
    });

    $("#getBarCode").click(function() {
        $("#barCode").show("slow")
    })

    function getContrib() {
        $.ajax({
            url: "indexServeur.php?page=getNumContribuable",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $(data).each(function () {
                    societe = this.D_RaisonSoc;
                });
            }
        });
    }

    getContrib();

    $("#prix, #mtt_avance").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: negatif
    });

    $("#quantite").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: false
    });

    $("#quantite_stock").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: true
    });

    function entete_document(){
        if(!$("#souche").is(':disabled'))
            if((isVisu == 0 && $("#cbMarqEntete").val()==0))
                $.ajax({
                    url: 'traitement/Facturation.php?acte=entete_document',
                    method: 'GET',
                    dataType: 'json',
                    async:false,
                    data : 'do_souche='+$("#souche").val()+'&type_fac='+typeFacture,
                    success: function(data) {
                        $("#n_doc").val(data.DC_Piece);
                        setArticle()
                    }
                });
    }
    entete_document();

    function bloque_entete() {
        $("#client").prop('disabled', true);
        $("#souche").prop('disabled', true);
        $("#dateentete").prop('disabled', true);
        $("#caisse").prop('disabled', true);
        $("#affaire").prop('disabled', true);
    }

    if(typeFacture == "Ticket" && isVisu==0 /**&& isModif==0*/) {
        clientCaisse();
    }

    function clientCaisse(){
        $.ajax({
            url: "indexServeur.php?page=getCaisseByCA_No&CA_No="+$("#caisse").val(),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $("#CT_Num").val(data[0].CT_Num);
                $("#libelleCtNum").html(data[0].CT_Num);
                $("#client").val(data[0].CT_Intitule);
            }
        });
    }

    function getDepotSoucheCaisse(caisse, depot, souche, affaire) {
        if (societe != "SECODI SECODI" || admin != 1) {
            $.ajax({
                url: "indexServeur.php?page=getSoucheDepotCaisse",
                method: 'GET',
                dataType: 'json',
                async: false,
                data: "type=" + typeFacture + "&prot_no=" + $("#prot_no").val() + "&ca_no=" + caisse + "&DE_No=" + depot + "&souche=" + souche + "&CA_Num=" + affaire,
                success: function (data) {
                    $(data).each(function () {
                        if (this.DE_No != null) {
                            $("#depot").val(this.DE_No);
                            $("#depotLigne").val(this.DE_No);
                            $("#reference").html("");
                            $("#designation").html("");
                        }
                        if (this.CA_No != null)
                            $("#caisse").val(this.CA_No);
                        if(this.CA_No==0)
                            $("#caisse").val("")
                        if (this.CA_Souche != null)
                            $("#souche").val(this.CA_Souche);
                        if (this.CA_Num != null)
                            $("#affaire").val(this.CA_Num);
                        if (this.CA_CatTarif != null && this.CA_CatTarif != 1)
                            $("#cat_tarif").val(this.CA_CatTarif);
                        if($("#cat_tarif").val()==null)
                            $("#cat_tarif").val($("#cat_tarif option:first").val());
                        if((typeFacture=="Vente" || typeFacture=="VenteT" || typeFacture=="VenteC")
                            && $("#modifClient").val()!=0){
                            if($("#cbMarqEntete").val()==0)
                                clientCaisse();
                        }
                    });
                    entete_document();
                },
                error: function (data) {
                    if (depot == 0) {
                        $("#depot").val(1);
                        $("#reference").html("");
                        $("#designation").html("");
                    }
                    if (caisse == 0)
                        $("#caisse").val(1);
                    if (souche == -1)
                        $("#souche").val(0);
                    if (affaire == "")
                        $("#affaire").val("");
                }
            });
        }
        entete_document();
    }

    if($("#cbMarqEntete").val()==0)
        getDepotSoucheCaisse(0, $("#depot").val(), -1, "");

    function setArticle(){
        $("#reference").autocomplete({
            source: "indexServeur.php?page=getArticleByRefDesignation&type=" + typeFacture + "&DE_No=" + $("#depotLigne").val(),
            autoFocus: true,
            closeOnSelect: true,
            select: function (event, ui) {
                event.preventDefault();
                $("#designation").val(ui.item.AR_Design)
                $("#reference").val(ui.item.AR_Ref)
                $("#AR_Ref").val(ui.item.AR_Ref)

                var refsaisie = $(this).val()
                valideReference($("#AR_Ref").val())
                $("#quantite").focus()
            }
        })
    }
    setArticle()

    $("#reference").focusin(function(){
        setArticle()
    })

    $("#depotLigne").change(function(){
        alimente_qteStock($("#AR_Ref").val());
    })

    $("#depot").change(function() {

        setArticle();
        $("#depotLigne").val($(this).val())

        getDepotSoucheCaisse(0, $("#depot").val(), -1, "");
        if ($("#cbMarqEntete").val()==0 && ($("#typeDocument").val() == "BonLivraison" || $("#typeDocument").val() == "Vente")) {
            $("#reference").html("");
            $("#designation").html("");
        }

        $.ajax({
            url: "traitement/Facturation.php?acte=maj_Depot",
            method: 'GET',
            dataType: 'json',
            data: "DE_No="+$(this).val()+"&cbMarq="+$("#cbMarqEntete").val()+"&protNo="+prot_no,
            success: function (data) {

            }
        })
    })

    $( "#ref" ).focusout(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=ajout_reference&reference="+$("#ref").val()+"&cbMarq="+$("#cbMarqEntete").val()+"&protNo="+prot_no,
            method: 'GET',
            dataType: 'json',
            success: function(data) {

            }
        });
    });

    $("#caisse").change(function () {
        if (($("#caisse").val() != "" && $("#typeDocument").val() == "Achat") || $("#typeDocument").val() != "Achat")
            getDepotSoucheCaisse($("#caisse").val(), 0, -1, "");
    })

    $("#souche").change(function () {
        getDepotSoucheCaisse(0, 0, $("#souche").val(), "");
    })

    $("#affaire").change(function () {
        getDepotSoucheCaisse(0, 0, -1, $("#affaire").val());
    })

    function returnDate(str){
        return "20"+str.substring(4,6)+"-"+str.substring(2,4)+"-"+str.substring(0,2);
    }

    function $_GET(param) {
        var vars = {};
        window.location.href.replace(location.hash, '').replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function (m, key, value) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );
        if (param) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }

    if ($("#flagDelai").val() != -1)
        $("#dateentete").datepicker({
            minDate: -$("#flagDelai").val(),
            maxDate: $("#flagDelai").val(),
            dateFormat: "ddmmy",
            altFormat: "ddmmy",
            autoclose: true
        });
    else
        $("#dateentete").datepicker({
            dateFormat: "ddmmy", altFormat: "ddmmy",
            autoclose: true
        });

    if ($("#cbMarqEntete").val() == 0) {
        $("#dateentete").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        if(typeFacture=="Vente" && $("#gen_ecart_rglt").val()==0)
            $("#date_ech").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        if(typeFacture=="Vente" && $("#gen_ecart_rglt").val()==0 && $("#date_rglt").is('[readonly]')==false)
            $("#date_rglt").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }

    $('#credit').click(function () {
        if ($('#credit').is(':checked')) {
            $('#comptant').prop('checked', false);
            $('#mtt_avance').attr("readonly", false);
            $('#mtt_avance').val("0");
        } else {
            if (!$('#comptant').is(':checked'))
                $('#credit').prop('checked', true);
        }
    });

    $('#comptant').click(function () {
        if ($('#comptant').is(':checked')) {
            $('#credit').prop('checked', false);
            $('#mtt_avance').attr("readonly", true);
            reste_a_payer();
        } else {
            if (!$('#credit').is(':checked'))
                $('#comptant').prop('checked', true);
        }
    });

    if(typeFacture=="Vente" && $("#gen_ecart_rglt").val()==0)
        $("#date_ech").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"})

    if(typeFacture=="Vente" && $("#gen_ecart_rglt").val()==0 && $("#date_rglt").is('[readonly]')==false)
        $("#date_rglt").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"})

    $( "#collaborateur" ).change(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=maj_collaborateur&collab="+$("#collaborateur").val()+"&entete="+$("#n_doc").val()+"&cbMarq="+$("#cbMarqEntete").val()+"&protNo="+prot_no,
            method: 'GET',
            dataType: 'json',
            success: function(data) {

            }
        });
    });

    $("#client").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&TypeFac="+typeFac,
        autoFocus: true,
        select: function(event, ui) {
            event.preventDefault();
            $("#client").val(ui.item.label)
            $("#CT_Num").val(ui.item.value)
            $("#libelleCtNum").html(ui.item.value);
            $("#cat_compta").val(ui.item.N_CatCompta)
            $("#collaborateur").val(ui.item.CO_No)
            if(ui.item.CO_No!=0)
                $("#collaborateur").val(ui.item.CO_No);
            if($("#collaborateur").val()==null)
                $("#collaborateur").val(0);
            $("#cat_compta").val(ui.item.N_CatCompta);
            if(ui.item.N_CatTarif!=1)
                $("#cat_tarif").val(ui.item.N_CatTarif);
            if($("#cat_compta").val()==null)
                $("#cat_compta").val($("#cat_compta option:first").val());
            if($("#cat_tarif").val()==null)
                $("#cat_tarif").val($("#cat_tarif option:first").val());
        },
        focus: function(event, ui) {
        }
    }).keypress(function (e, data, ui) {
        if (e.which == 13) {

            $.ajax({
                url: 'indexServeur.php?page=getClientByCTNum&CT_Num=' + $("#CT_Num").val(),
                method: 'GET',
                async : false,
                dataType: 'json',
                success: function (data) {
                    if(data[0].CO_No!=0)
                        $("#collaborateur").val(data[0].CO_No);
                    if($("#collaborateur").val()==null)
                        $("#collaborateur").val(0);
                    $("#cat_compta").val(data[0].N_CatCompta);
                    if(data[0].N_CatTarif!=1)
                        $("#cat_tarif").val(data[0].N_CatTarif);
                    if($("#cat_compta").val()==null)
                        $("#cat_compta").val($("#cat_compta option:first").val());
                    if($("#cat_tarif").val()==null)
                        $("#cat_tarif").val($("#cat_tarif option:first").val());
                    ajout_entete();
                    //updateLibPied();
                }
            });
        }
    });

    $("#ref").keydown(function (event){
        if(event.keyCode == 13)
        ajout_entete();
    })

    $("#cat_tarif").change(function(){
        if($("#reference").val()!="")
            valideReference($("#reference").val());
        majCatCompta();
    });

    $("#cat_compta").change(function(){
        if($("#reference").val()!="")
            valideReference($("#reference").val());
        updateLibPied();
        majCatCompta();
    });

    function ajout_entete(){
        if($("#cbMarqEntete").val()==0)
            if((typeFacture=="Ticket") || ($("#do_statut").val()==0 || $("#do_statut").val()==1 || $("#do_statut").val()==2)){
                if($("#CT_Num").val()!=""){
                    if($('#dateentete').val()!=""){
                        var type = typeFacture;
                        var dataTrans = "";
                        if(type=="AchatPreparationCommande") {
                            var select =0;
                            if ($('input#transDoc').is(':checked'))
                                select = 1;
                            dataTrans = "&DO_Coord03="+select;
                        }
                        var DO_Coord04 = "";
                        if($("#nomClient").val()!=null) DO_Coord04 = $("#nomClient").val();
                        if( DO_Coord04 == "") DO_Coord04 = $("#DoCoord04").val()
                        $.ajax({
                            url: "traitement/Facturation.php?acte=ajout_entete&type_fac="+typeFacture+"&do_piece="+$("#n_doc").val()+"&souche="+$("#souche").val()+"&de_no="+$("#depot").val()+"&date="+returnDate($("#dateentete").val())+"&client="+$("#CT_Num").val()+"&reference="+$("#ref").val()+"&co_no="+$("#collaborateur").val()+"&cat_compta="+$("#cat_compta").val()+"&cat_tarif="+$("#cat_tarif").val()+"&ca_no="+$("#caisse").val()+"&affaire="+$("#affaire").val()+"&do_statut="+$("#do_statut").val()+"&userName="+$("#userName").html()+"&DO_Coord04="+DO_Coord04+"&machineName="+$("#machineName").html()+dataTrans,
                            method : 'GET',
                            async : false,
                            dataType : 'json',
                            data : "protNo="+prot_no+"&DO_Coord01="+$("#DoCoord01").val()+"&DO_Coord02="+$("#DoCoord02").val()+"&DO_Coord03="+$("#DoCoord03").val()+"&DO_Coord04="+DO_Coord04,
                            success : function(data) {
                                $(data).each(function () {
                                    $("#n_doc").val(this.entete);
                                    $("#cbMarqEntete").val(this.cbMarq);
                                    bloque_entete();
                                    $("#reference").prop('disabled', false);
                                    $("#prix").prop('disabled', false);
                                    $("#remise").prop('disabled', false);
                                    $("#depot").prop('disabled', true);
                                    $("#quantite").prop('disabled', false);
                                    $("#reference").focus()
                                })
                            },
                            error : function(resultat, statut, erreur){
                                alert(resultat.responseText);
                            }
                        });
                    } else
                        alert("Saisissez une date !");
                } else
                    alert("Saisissez un tiers !");

            }else {
                alert("Choississez un statut valide !");
            }
    }

    $("#infoCompl").click(function(){
        $("#InfoComplFields").dialog({
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            title: "Informations complémentaire",
            buttons: {
                "Valider": {
                    class: 'btn btn-primary',
                    text: 'Valider',
                    click: function () {
                        $("#DoCoord01").val($("#inputDoCoord01").val())
                        $("#DoCoord02").val($("#inputDoCoord02").val())
                        $("#DoCoord03").val($("#inputDoCoord03").val())
                        $("#DoCoord04").val($("#inputDoCoord04").val())
                        $(this).dialog("close");
                    }
                }
            }
        });
    })

    function valideReference(reference){
        if(typeFacture=="Achat" || typeFacture=="AchatRetour" || typeFacture=="PreparationCommande" || typeFacture=="AchatPreparationCommande")
            valideReferenceAchat(reference);
        else
            valideReferenceVente(reference);
    }

    function valideReferenceVente(reference){
        $.ajax({
            url: "indexServeur.php?page=getPrixClient&AR_Ref="+reference+"&N_CatTarif="+$("#cat_tarif").val()+"&N_CatCompta="+$("#cat_compta").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                pmin = Math.round(data[0].Prix_Min*100)/100;
                pmax = Math.round(data[0].Prix_Max*100)/100;
                qtegros= Math.round(data[0].Qte_Gros*100)/100;
                var tmp=pmax;
                if(pmin>pmax){
                    pmax=pmin;
                    pmin=tmp;
                }
                alimente_qteStock(reference);
                if(!modification)
                    $("#prix").val(Math.round((data[0].Prix)*100)/100);
                $("#taxe1").val(data[0].taxe1);
                $("#taxe2").val(data[0].taxe2);
                $("#taxe3").val(data[0].taxe3);
            }

        });
    }

    function alimente_qteStock(reference){
        $.ajax({
            url: 'indexServeur.php?page=isStock&AR_Ref='+reference+'&DE_No='+$("#depotLigne").val(),
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                $("#quantite_stock").val("")
                $(data).each(function () {
                    $("#quantite_stock").val(Math.round(this.AS_QteSto * 100) / 100);
                })
            }
        });
    }

    function fichierTraitement() {
        var fich = typeFacture;
        var racine = "";
        var racineTTC = "";
        var societeParam = "/";

        racineTTC = "export/CMI/exportFactureTTC.php?";
        listeFacture = "listeFacture-" + fich;
        if (societe == "CMI CAMEROUN SARL")
            societeParam = "/CMI/";
        racine = "export" + societeParam + "exportFacture.php?";

        impressionFacture = racine + "&type=" + fich;
        impressionFactureTTC = racineTTC  + "&type=" + fich;
    }
    fichierTraitement()

    $('#imprimer').click(function(){
        fichierTraitement();
        if((typeFac=="Devis" || typeFac=="BonLivraison" || typeFacture=="Livraison" || typeFac=="VenteAvoir")){
            choixFormat();
        } else{
            if((isVisu ==0) || ($("#PROT_Reglement").val() !=2)) {
                if(($("#reste_a_payer").val()!=0 || (isModif== 0 && isVisu ==0 )))
                    valider(true);
                else
                    choixFormat();
            }
            else
                choixFormat();
        }

    });

    $('#valider').click(function(){
        if((typeFacture=="Devis" || typeFacture=="Avoir" || typeFacture=="BonLivraison"))
            window.location.replace(listeFacture);
        else
            valider(true);
    });

    function reste_a_payer() {
        $.ajax({
            url: "traitement/Facturation.php?acte=reste_a_payer",
            method: 'GET',
            dataType: 'json',
            data : "EntetecbMarq="+$("#cbMarqEntete").val(),
            success: function (data) {
                $("#reste_a_payer_text").html("Le reste à payer est de <b>" + (data.reste_a_payer).toLocaleString() + "</b>");
                $("#reste_a_payer").val(data.reste_a_payer);
                if(!$("#comptant").is(':checked') && (typeFacture=="Achat" ||typeFacture=="AchatRetour" || typeFacture=="PreparationCommande" || typeFacture=="AchatPreparationCommande"))
                    $("#mtt_avance").val(0);
                else
                    $("#mtt_avance").val((data.reste_a_payer));
            }
        });
    }
    reste_a_payer()

    function getdateecheance(){
        $.ajax({
            url: "indexServeur.php?page=getDateEcheanceSage&CT_Num="+$("#CT_Num").val()+"&Date="+returnDate($("#dateentete").val()),
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function(data) {
                $("#date_ech").val(data[0].date_ech);
            },
            error: function (data){
                $("#date_ech").val($("#dateentete").val());
            }
        });

    }

    $("#date_rglt").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());

    $("#date_ech").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());

    //$("#date_rglt").unbind();

    function valider(imprime){
        $("#valideRegle").val(1);
        reste_a_payer();
        if(typeFacture=="Achat" || typeFacture=="AchatRetour"){
            $('#comptant').prop('checked', false);
            $('#credit').prop('checked', true);
            $('#mtt_avance').attr("readonly", false);
            $('#mtt_avance').val(0);
        }
        else {
            $('#comptant').prop('checked', true);
            $('#credit').prop('checked', false);
            $('#mtt_avance').attr("readonly", true);
            reste_a_payer();
        }

        getdateecheance();

        $("#libelle_rglt").val(("Rglt "+$("#n_doc").val()+"_"+$("#ref").val()).substr(0,34));
        //$("#mode_reglement").val(1);
        $(".valideReglement").dialog({
            resizable: true,
            height: "auto",
            modal: true,
            async: false,
            title : "Mode de règlement",
            buttons: {
                "Valider": {
                    class: 'btn btn-primary',
                    text: 'Valider',
                    click: function () {
                        if ($("#date_rglt").val() != "" && $("#date_ech").val() != "") {
                            var valideButton = $(this);
                            var totalttc = $("#reste_a_payer").val();
                            var montant_avance = $("#mtt_avance").val();
                            $.ajax({
                                url: "indexServeur.php?page=ResteARegler&cbMarq="+ $("#cbMarqEntete").val() + "&avance=" + (montant_avance).replace(/ /g, ""),
                                method: 'GET',
                                async: false,
                                dataType: 'json',
                                success: function (data) {
                                    if (totalttc != 0)
                                        if (data[0].VAL != 0) {
                                            $("#valideRegltImprime").val(imprime);
                                            $("#cbMarqEntete").val($("#cbMarqEntete").val());
                                            valideButton.dialog("close");
                                            $.ajax({
                                                url: "traitement/Facturation.php?acte=regle",
                                                method: 'GET',
                                                async: false,
                                                dataType: 'html',
                                                data : $("#valideRegltForm").serialize(),
                                                success: function (dataVal) {
                                                    if(dataVal=="") {
                                                        if (imprime)
                                                            choixFormat();
                                                        else
                                                            $("#redirectFacture").submit();
                                                    }else{
                                                        alert(dataVal);
                                                    }
                                                }
                                            })
                                        } else {
                                            alert("L'avance ne doit pas dépassé " + parseFloat(totalttc).toLocaleString());
                                        }
                                }
                            });
                        }else {
                            alert("Veuillez saisir une date d'échéance et une date de règlement");
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

    function doImprim() {
        if(typeFacture=="Devis") {
            $.ajax({
                url: "traitement/Facturation.php?acte=doImprim&cbMarq=" + $("#cbMarqEntete").val(),
                method: 'GET',
                dataType: 'json',
                async: false,
                success: function (data) {
                }
            });
        }
        $("#DO_Imprim").val("1");
    }

    function choixFormat(){
        doImprim();
        if(societe == "CMI CAMEROUN SARL" && typeFacture!="Achat"){
            if((typeFacture=="Vente" || typeFacture=="VenteC"  ||typeFacture=="VenteT" ||  typeFacture=="Devis") && $("#cat_tarif").val()==1) {
                $("<div></div>").dialog({
                    resizable: false,
                    height: "auto",
                    width: "400",
                    modal: true,
                    title: "Choix du format",
                    buttons: {
                        "A4 CLIENT SOCIETE": {
                            class: 'btn btn-primary',
                            text: 'A4 CLIENT SOCIETE',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                                $("#redirectFacture").submit();
                            }
                        },
                        "A5 CLIENT SOCIETE": {
                            class: 'btn btn-primary',
                            text: 'A5 CLIENT SOCIETE',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                                $("#redirectFacture").submit();
                            }
                        }
                    }
                });
            }else
            if((typeFacture=="Vente" || typeFacture=="VenteC"  ||typeFacture=="VenteT" || typeFacture=="Devis") && $("#cat_tarif").val()==2){
                $("<div></div>").dialog({
                    resizable: false,
                    height: "auto",
                    width: "400",
                    modal: true,
                    title: "Choix du format",
                    buttons: {
                        "A4 CLIENT DIVERS": {
                            class: 'btn btn-primary',
                            text: 'A4 CLIENT DIVERS',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=CMI&type=CLIENT_DIVERS", '_blank');
                                $("#redirectFacture").submit();
                            }
                        },
                        "A5 CLIENT DIVERS": {
                            class: 'btn btn-primary',
                            text: 'A5 CLIENT DIVERS',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=CMI&type=CLIENT_DIVERS", '_blank');
                                $("#redirectFacture").submit();
                            }
                        }
                    }
                });
            }else{
                $("<div></div>").dialog({
                    resizable: false,
                    height: "auto",
                    width: "400",
                    modal: true,
                    title: "Choix du format",
                    buttons: {
                        "A4 CLIENT SOCIETE": {
                            class: 'btn btn-primary',
                            text: 'A4 CLIENT SOCIETE',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                                $("#redirectFacture").submit();
                            }
                        },
                        "A4 CLIENT DIVERS": {
                            class: 'btn btn-primary',
                            text: 'A4 CLIENT DIVERS',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=CMI&type=CLIENT_DIVERS", '_blank');
                                $("#redirectFacture").submit();
                            }
                        },
                        "A4 PROFORMA": {
                            class: 'btn btn-primary',
                            text: 'A4 PROFORMA',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=CMI&type=PROFORMA", '_blank');
                                $("#redirectFacture").submit();
                            }
                        },
                        "A5 CLIENT SOCIETE": {
                            class: 'btn btn-primary',
                            text: 'A5 CLIENT SOCIETE',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                                $("#redirectFacture").submit();
                            }
                        },
                        "A5 CLIENT DIVERS": {
                            class: 'btn btn-primary',
                            text: 'A5 CLIENT DIVERS',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=CMI&type=CLIENT_DIVERS", '_blank');
                                $("#redirectFacture").submit();
                            }
                        },
                        "A5 PROFORMA": {
                            class: 'btn btn-primary',
                            text: 'A5 PROFORMA',
                            click: function () {
                                window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                                $("#redirectFacture").submit();
                            }
                        }
                    }
                });
            }

        }else{

            var words = societe.split(' ');
            if(societe=="BOUM CONSTRUCTION SARL"){
                if($("#cat_tarif").val()!=3){
                    $("<div></div>").dialog({
                        resizable: false,
                        height: "auto",
                        width: "100",
                        modal: true,
                        title: "Choix du format",
                        buttons: {
                            "A4": {
                                class: 'btn btn-primary',
                                text: 'A4',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?facture=0&cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=" + words[0] + "&type=A4", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A4", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            },
                            "A5": {
                                class: 'btn btn-primary',
                                text: 'A5',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?facture=0&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=" + words[0] + "&type=A5", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            },
                            "A4 Facture": {
                                class: 'btn btn-primary',
                                text: 'A4 Facture',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?facture=1&cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=" + words[0] + "&type=A4", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A4", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            },
                            "A5 Facture": {
                                class: 'btn btn-primary',
                                text: 'A5 Facture',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?facture=1&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=" + words[0] + "&type=A5", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            },
                            "Bon livraison": {
                                class: 'btn btn-primary',
                                text: 'BON LIVRAISON',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?facture=1&cbMarq=" + $("#cbMarqEntete").val() + "&format=LIVRAISON&societe=" + words[0] + "&type=BON", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            }
                        }
                    });
                }else{
                    $("<div></div>").dialog({
                        resizable: false,
                        height: "auto",
                        width: "100",
                        modal: true,
                        title: "Choix du format",
                        buttons: {
                            "Bon livraison": {
                                class: 'btn btn-primary',
                                text: 'BON LIVRAISON',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?facture=1&cbMarq=" + $("#cbMarqEntete").val() + "&format=LIVRAISON&societe=" + words[0] + "&type=BON", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            }
                        }

                    });

                }
            }else {
                if (societe=="LIDEL SARL") {
                    $("<div></div>").dialog({
                        resizable: false,
                        height: "auto",
                        width: "100",
                        modal: true,
                        title: "Choix du format",
                        buttons: {
                            "A4": {
                                class: 'btn btn-primary',
                                text: 'A4',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=" + words[0] + "&type=A4", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A4", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            },
                            "A5": {
                                class: 'btn btn-primary',
                                text: 'A5',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=" + words[0] + "&type=A5", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            },
                            "Ticket": {
                                class: 'btn btn-primary',
                                text: 'Ticket',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=Ticket&societe=" + words[0] + "&type=A5", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            }
                        }
                    });
                } else {
                    $("<div></div>").dialog({
                        resizable: false,
                        height: "auto",
                        width: "100",
                        modal: true,
                        title: "Choix du format",
                        buttons: {
                            "A4": {
                                class: 'btn btn-primary',
                                text: 'A4',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A4&societe=" + words[0] + "&type=A4", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A4", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            },
                            "A5": {
                                class: 'btn btn-primary',
                                text: 'A5',
                                click: function () {
                                    if (societe != "CMI CAMEROUN SARL")
                                        window.open("export/exportSSRS.php?cbMarq=" + $("#cbMarqEntete").val() + "&format=A5&societe=" + words[0] + "&type=A5", '_blank');
                                    else
                                        window.open(impressionFacture + "&cbMarq=" + $("#cbMarqEntete").val() + "&format=A5", '_blank');
                                    $("#redirectFacture").submit();
                                }
                            }
                        }

                    });
                }
            }
        }
    }


    function ajout_ligne(e){
        if(e.keyCode == 13 && isVisu ==0){
            var me = $(this);
            e.preventDefault();
            if ( me.data('requestRunning') ) {
                alert("visu_ajout_ligne")
                return;
            }
            me.data('requestRunning', true);

            var valfloat = parseFloat(Math.round(($("#prix").val()).replace(/ /g,"")*100)/100);
            var pmin_c = parseFloat(pmin);
            var pmax_c = parseFloat(pmax);
            var qtegros_c = parseFloat(qtegros);

            if($("#quantite").val().replace(/ /g,"")!=0) {
                var acte = "ajout_ligne";
                if (modification) {
                    modification = false;
                    acte = "modif";
                    var ajoutParam="";

                    $.ajax({
                        url: "traitement/Facturation.php?&type_fac=" + typeFacture + "&cat_tarif=" + $("#cat_tarif").val() + "&cat_compta=" + $("#cat_compta").val()  + "&acte=" + acte  + "&quantite=" + $("#quantite").val().replace(/ /g,"")  + "&prix=" + ($("#prix").val()).replace(/ /g,"") + "&remise=" + $("#remise").val() + "&cbMarq=" + $("#cbMarq").val() + "&userName=" + $("#userName").html() + "&machineName=" + $("#machineName").html(),
                        method: 'GET',
                        async: false,
                        dataType: 'json',
                        data : "cbMarqEntete="+$("#cbMarqEntete").val()+ajoutParam+"&PROT_No="+$("#PROT_No").val()+"&depotLigne="+$("#depotLigne").val(),
                        success: function (data) {
                            $("#ADL_Qte").val(0);
                            if(typeFacture=="Vente") {
                                stockMinDepasse($("#AR_Ref").val(),$("#depot").val());
                            }
                            if (typeFacture == "AchatPreparationCommande") {
                                $.ajax({
                                    url: 'traitement/Facturation.php?acte=modif_ligneAL',
                                    method: 'GET',
                                    dataType: 'html',
                                    data: 'CA_Num=' + $("#affaire").val() + '&EA_Quantite=' + data.DL_Qte + '&EA_Montant=' + data.DL_MontantHT + '&cbMarq=' + $("#cbMarq").val() + "&N_Analytique=1",
                                    async: false,
                                    success: function (data) {
                                    }
                                });
                            }
                            if (data.message != null) {
                                modification = true;
                                alert(data.message);
                            } else {
                                alimLigne();
                                $('#reference').prop('disabled', false);
                                $('#reference').val("");
                                $('#AR_Ref').val("");
                                $('#designation').val("");
                                $("#reference").focus()
                                calculTotal();
                                if (data.DL_NoColis != "")
                                    $("#cat_compta").val(data.DL_NoColis);
                                getSaisieComtpable(0);
                                if (typeFacture == "AchatPreparationCommande")
                                    optionLigneA();
                                tr_clickArticle();
                                $("#cbMarq").val("");
                            }
                        },
                        complete: function() {
                            me.data('requestRunning', false);
                        },
                        error: function (resultat, statut, erreur) {
                            modification = true;
                            alert(resultat.responseText);
                        }
                    });
                } else {
                    var cbmarq = "";
                    var remise_modif = "";
                    var ajoutParam="";
                    $.ajax({
                        url: "traitement/Facturation.php?&type_fac=" + typeFacture + "&cat_tarif=" + $("#cat_tarif").val() + "&cat_compta=" + $("#cat_compta").val() + "&acte=" + acte + "&entete=" + $("#n_doc").val() + "&quantite=" + $("#quantite").val().replace(/ /g,"") + "&DE_No=" + $("#depot").val() + "&designation=" + $("#AR_Ref").val() + "&prix=" + ($("#prix").val()).replace(/ /g,"") + "&remise=" + $("#remise").val() + "&cbMarq=" + $("#cbMarq").val() + "&userName=" + $("#userName").html() + "&machineName=" + $("#machineName").html(),
                        method: 'GET',
                        async: false,
                        dataType: 'json',
                        data : "cbMarqEntete="+$("#cbMarqEntete").val()+ajoutParam+"&PROT_No="+$("#PROT_No").val()+"&depotLigne="+$("#depotLigne").val(),
                        success: function (data) {
                            $("#ADL_Qte").val(0);
                            if(typeFacture=="Vente") {
                                stockMinDepasse($("#AR_Ref").val(),$("#depot").val());
                            }
                            if (typeFacture == "AchatPreparationCommande") {
                                $.ajax({
                                    url: 'traitement/Facturation.php?acte=ajout_ligneA',
                                    method: 'GET',
                                    dataType: 'html',
                                    data: 'CA_Num=' + $("#affaire").val() + '&EA_Quantite=' + data.dl_Qte + '&EA_Montant=' + data.dl_MontantHT + '&cbMarq=' + data.cbMarq + "&N_Analytique=1"+ajoutParam,
                                    async: false,
                                    success: function (data) {
                                    }
                                });
                            }

                            if (data.message != null) {
                                alert(data.message);
                            } else {
                                alimLigne();
                                calculTotal();
                                getSaisieComtpable(0);
                                tr_clickArticle();
                                if (typeFacture == "AchatPreparationCommande")
                                    optionLigneA();
                            }
                        },
                        complete: function() {
                            me.data('requestRunning', false);
                        },
                        error: function (resultat, statut, erreur) {
                            alert(resultat.responseText);
                            alimLigne();
                            calculTotal();
                            getSaisieComtpable(0);
                            tr_clickArticle();
                            if (typeFacture == "AchatPreparationCommande")
                                optionLigneA();
                        }
                    });
                    $("#reference").focus()
                }
            }else{
                alert("la quantité doit être différent de 0 !");
                me.data('requestRunning', false);
            }
            reste_a_payer()
        }
    }


    function modifarticle(elem){
        if (isVisu  != 1 || (typeFacture == "Livraison" && doModif == 0)) {
            var cbMarq = elem.find("#cbMarq").html();
            var DL_Qte = elem.find("#DL_Qte").html();
            DL_Qte = DL_Qte.replace(",",".");
            DL_Qte = DL_Qte.replace(/ /g,"");
            var AR_Ref = elem.find("#AR_Ref").html();
            var DL_Design = elem.find("#DL_Design").html();
            var DL_Remise = elem.find("#DL_Remise").html();
            var DL_MontantTTC = elem.find("#DL_MontantTTC").html();
            DL_MontantTTC = DL_MontantTTC.replace(",",".");
            DL_MontantTTC = DL_MontantTTC.replace(/ /g,"");
            var DL_PrixUnitaire = elem.find("#DL_PrixUnitaire").html();
            DL_PrixUnitaire = DL_PrixUnitaire.replace(",",".");
            DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g,"");
            var DL_PUTTC = elem.find("#PUTTC").html();
            DL_PUTTC = DL_PUTTC.replace(",",".");
            DL_PUTTC = DL_PUTTC.replace(/ /g,"");
            var DL_CMUP = elem.find("#DL_CMUP").html();
            DL_CMUP = DL_CMUP.replace(",",".");
            DL_CMUP = DL_CMUP.replace(/ /g,"");
            var pu = Math.round(DL_PrixUnitaire * 100) / 100;
            var ttc = Math.round(DL_PUTTC * 100) / 100;

            typeArticle(AR_Ref, $("#cat_tarif").val(), $("#cat_compta").val(), pu, ttc, $("#prix"), DL_Qte);
            $('#reference').val(AR_Ref);
            $("#depotLigne").val(elem.find("#depotLigne").html());
            $('#AR_Ref').val(AR_Ref);
            $('#designation').val(DL_Design);
            $('#remise').val(DL_Remise);
            $('#quantite').val(DL_Qte);
            $('#ADL_Qte').val(DL_Qte);
            $('#APrix').val(pu);
            $('#prix').val(ttc);
            $('#cbMarq').val(cbMarq);
            alimente_qteStock(AR_Ref);
            $('#reference').prop("disabled", true);
            $('#designation').prop("disabled", true);
            $("#quantite").focus()
            modification = true;
        }
    }

    function typeArticle(ar_ref,cattarif,catcompta,pu,ttc,conteneur,qte){
        var page = "getPrixClientHT";
        var type=0;
        var fournisseur =0;
        if(typeFacture=="Achat" || typeFacture=="AchatRetour") fournisseur=1;
        $.ajax({
            url: "indexServeur.php?page="+page+"&AR_Ref="+ar_ref+"&N_CatTarif="+cattarif+"&Prix=0&N_CatCompta="+catcompta+"&remise=0&fournisseur="+fournisseur+"&qte="+qte,
            method: 'GET',
            async: 'GET',
            async : false,
            dataType: 'json',
            success: function(data) {
                type= data[0].AR_PrixTTC;
                if(type==1) conteneur.val(ttc);
                else conteneur.val(pu);
            }
        });
    }

    function tr_clickArticle() {
        $("tr[id^='article']").each(function () {
            $(this).unbind();
            var cbMarq = $(this).find("#cbMarq").html();
            var cbMarqArticle = $(this).find("#cbMarqArticle").html();
            var DL_Qte = $(this).find("#DL_Qte").html();
            var AR_Ref = $(this).find("#AR_Ref").html();
            var DL_Design = $(this).find("#DL_Design").html();
            var DL_Remise = $(this).find("#DL_Remise").html();
            var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
            var DL_CMUP = $(this).find("#DL_CMUP").html();
            var DL_PieceBL = $(this).find("#DL_PieceBL").html();
            var depotLigne = $(this).find("#depotLigne").html();
            $(this).dblclick(function () {
                modifarticle($(this));
            });

            $(this).find("td[id^='modif_']").click(function () {
                modifarticle($(this).parent('tr'));
            });

            $(this).find("#suppr_"+cbMarq).click(function(){
                if(DL_PieceBL=="")
                    suppression(cbMarq,AR_Ref,DL_Qte/*,,DL_CMUP*/);
                else
                    supprTransformation(cbMarq,DL_PieceBL)
            });

            $(this).find("#AR_Ref").click(function(){
                fiche_article(cbMarqArticle);
            });

        });
    }
    tr_clickArticle();

    $(this).find("td[id^='editLivraison']").click(function () {
        if(admin == 1)
            listeElementLivraison(cbMarq,admin)
    });

    function listeElementLivraison(cbMarq,administrator){
        $.ajax({
            url: "Traitement/Facturation.php?acte=listeElementLivraison&cbMarq="+cbMarq+"&admin="+administrator,
            method: 'GET',
            data: "cbMarq=" + cbMarq,
            dataType: 'html',
            async : false,
            success: function (data) {
                $(data).dialog({
                    resizable: false,
                    height: "auto",
                    width: "400",
                    modal: true,
                    title: "Liste qté livrée",
                    buttons: {
                        "Valider": {
                            class: 'btn btn-primary',
                            text: 'Valider',
                            click: function () {
                                $("[id^='itemQteLivree']").each(function(){
                                    qteLivreeData = $(this).find("#qteLivree").val()
                                    prevQteLivreeData = $(this).find("#prevQte").html()
                                    cbMarqLigne = $(this).find("#cbMarq").html()
                                    if(prevQteLivreeData!=qteLivreeData) {
                                        $.ajax({
                                            url: "Traitement/Facturation.php?acte=updateQteLivree&cbMarq=" + cbMarqLigne + "&PROT_No=" + prot_no + "&qte=" + qteLivreeData,
                                            method: 'GET',
                                            dataType: 'html',
                                            async: false,
                                            success: function (data) {
                                                if (data != "")
                                                    alert(data)
                                                else {
                                                    alert("La modification a été effectuée !")
                                                    location.reload()
                                                }
                                            }
                                        })
                                    }
                                })
                            }
                        },
                        "Annuler": {
                            class: 'btn btn-primary',
                            text: 'Annuler',
                            click: function () {
                                $(this).dialog("close")
                            }
                        }
                    }
                })

                $("[id^='qteLivree']").each(function(){
                    $(this).inputmask({   'alias': 'decimal',
                        'groupSeparator': ' ',
                        'autoGroup': true,
                        'digits': 2,
                        rightAlign: true,
                        'digitsOptional': false,
                        'placeholder': '',
                        allowPlus: true,
                        allowMinus: negatif
                    });
                })

                $("[id^='deleteQteLivree']").each(function() {
                    cbMarq = $(this).parent().parent().find("#cbMarq").html()

                    $(this).click(function () {
                        $("<div></div>").dialog({
                            resizable: false,
                            height: "auto",
                            width: "400",
                            modal: true,
                            title: "Voulez vous supprimer cette entrée ?",
                            buttons: {
                                "Oui": {
                                    class: 'btn btn-primary',
                                    text: 'Oui',
                                    click: function () {
                                        $.ajax({
                                            url: "Traitement/Facturation.php?acte=deleteQteLivree&cbMarq=" + cbMarq + "&PROT_No=" + prot_no,
                                            method: 'GET',
                                            dataType: 'html',
                                            async: false,
                                            success: function (data) {
                                                $(this).dialog("close")
                                                location.reload()
                                            }
                                        })
                                    }
                                }
                                ,"Non": {
                                    class: 'btn btn-primary',
                                    text: 'Non',
                                    click: function () {
                                        $(this).dialog("close")
                                    }
                                }
                            }
                        })
                    })
                })
            }
        })
    }

    function supprTransformation(cbMarq,DL_PieceBL){
        $("<div>Voulez vous recréer cette ligne dans le document "+DL_PieceBL+" ?</div>").dialog({
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            title: "Transformation document",
            buttons: {
                "Oui": {
                    class: 'btn btn-primary',
                    text: 'Oui',
                    click: function () {
                        var dialog = $( this )
                        $.ajax({
                            url: "Traitement/Facturation.php?acte=transformDocLigne&cbMarqEntete="+$("#cbMarqEntete").val(),
                            method: 'GET',
                            data: "cbMarq=" + cbMarq,
                            dataType: 'html',
                            async : false,
                            success: function (data) {
                                dialog.dialog( "close" )
                            }
                        })

                    }
                },
                "Non": {
                    class: 'btn btn-primary',
                    text: 'Non',
                    click: function () {
                        supprFacture(cbMarq,entete,typeFact,ligne)
                        $( this ).dialog( "close" )
                    }
                }
            }
        })
    }

    function fiche_article(cbMarqArticle){
        window.open('ficheArticle-'+cbMarqArticle, "Fiche Article", "height=800,width=800");
    }
    function fiche_client(CT_Num){
        window.open('indexMVC.php?module=3&action=2&CT_Num='+CT_Num, "Fiche Client", "height=800,width=800");
    }

    function optionLigneA(){
        $("td[id^='lignea_']").each(function(){
            $(this).unbind();
        });

        $("td[id^='lignea_']").click(function() {
            EC_MontantImpute = $(this).parent('tr').find("#DL_MontantHT").html();
            EC_QteImpute = $(this).parent('tr').find("#DL_Qte").html();
            cbMarqLigne = $(this).parent('tr').find("#cbMarq").html();
            formAnalytique(cbMarqLigne);
            $("#formAnalytique").dialog({
                resizable: false,
                height: "auto",
                width: 1000,
                modal: true,
                title : "Ligne",
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function() {
                            if(EC_MontantImpute==totalMontantA && EC_QteImpute==totalQteA){
                                $( this ).dialog( "close" );
                                getSaisieComtpable(0);
                            }
                            else
                                alert("La saisie n'est pas équilibrée !");
                        }
                    }
                }
            });
        });
    }
    optionLigneA();

    function getSaisieComtpable(insert) {
        if (/*typeFacture == "Vente" || */typeFacture == "PreparationCommande" || typeFacture == "AchatPreparationCommande") {
            var transDoc = 0;
            var valECNo = 0;
            if($("#transDoc").is(':checked'))
                transDoc=1;
            $.ajax({
                url: "traitement/Facturation.php?acte=saisie_comptable",
                method: 'GET',
                dataType: 'json',
                data: "cbMarq=" + $("#cbMarqEntete").val() +"&TransDoc="+transDoc,
                async: false,
                success: function (data) {
                    $("#tableEC > tbody").html("");
                    var compteur = 0;
                    $(data).each(function () {
                        var dateEch = "";
                        if (this.EC_Echeance != "") {
                            var d = new Date(this.EC_Echeance);
                            dateEch = (("00" + d.getDay()).substr(-2) + "/" + ("00" + d.getMonth()).substr(-2) + "/" + d.getFullYear());
                        }
                        var dataTab = "<tr><td>" + this.JO_Num + "</td><td>" + this.Annee_Exercice + "</td><td>" + this.EC_Jour + "</td><td>" + this.EC_RefPiece + "</td><td>" + this.EC_Reference + "</td>" +
                            "<td>" + this.CG_Num + "</td><td>" + this.CT_Num + "</td><td>" + this.EC_Intitule + "</td><td>" + dateEch + "</td>" +
                            "<td>" + (Math.round(this.EC_MontantDebit * 100) / 100) + "</td><td>" + (Math.round(this.EC_MontantCredit * 100) / 100) + "</td></tr>";
                        $("#tableEC > tbody").append(dataTab);
                        if (insert == 1) {
                            $.ajax({
                                url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=ajout',
                                method: 'GET',
                                dataType: 'json',
                                data: "nomFichier=" + this.nomFichier + '&JO_Num=' + this.JO_Num + '&Annee_Exercice=' + this.Annee_Exercice + '&EC_Jour=' + this.EC_Jour + '&EC_Piece=' + this.EC_Piece + '&EC_RefPiece=' + this.EC_RefPiece
                                    + '&EC_Reference=' + this.EC_Reference + '&CG_Num=' + this.CG_Num + '&CG_NumCont=' + this.CG_Num + '&CT_Num=' + this.CT_Num
                                    + '&CT_NumCont=' + this.CT_Num + '&EC_Intitule=' + this.EC_Intitule + '&N_Reglement=1&EC_Echeance=' + this.EC_Echeance + '&EC_MontantCredit=' + this.EC_MontantCredit +
                                    '&EC_MontantDebit=' + this.EC_MontantDebit + '&TA_Code=' + this.TA_Code,
                                async: false,
                                success: function (data) {
                                    if(compteur==0)
                                        valECNo = data.EC_No;
                                },
                                error: function(){
                                    //alert("ndem total");
                                }
                            });
                        }

                        $.ajax({
                            url: "traitement/Facturation.php?acte=saisie_comptableAnal",
                            method: 'GET',
                            dataType: 'json',
                            data: "cbMarq=" + $("#cbMarqEntete").val(),
                            async: false,
                            success: function (data) {
                                $("#tableAnal > tbody").html("");
                                $(data).each(function () {
                                    if(this.CA_Num!="")
                                        var dataTab = "<tr><td>" + this.JO_Num + "</td><td>" + this.A_Intitule + "</td><td>" + this.CG_Num + "</td><td>" + this.AnneExercice + "</td><td>" + this.CA_Num + "</td><td>" + this.A_Qte + "</td><td>" + (Math.round(this.A_Montant*100)/100) + "</td>" +
                                            "</tr>";
                                    $("#tableAnal > tbody").append(dataTab);

                                    if (insert == 1 && compteur==0) {
                                        $(data).each(function () {
                                            $.ajax({
                                                url: 'traitement/Structure/Comptabilite/SaisieJournalExerciceAnal.php?acte=ajout',
                                                method: 'GET',
                                                dataType: 'html',
                                                data: 'CA_Num=' + this.CA_Num + '&A_Qte=' + this.A_Qte + '&A_Montant=' + this.A_Montant + '&EC_No=' + valECNo + "&N_Analytique=" + this.N_Analytique,
                                                async: false,
                                                success: function (data) {
                                                }
                                            });
                                        });
                                    }
                                });

                                SaisieA=1;
                            },complete: function(){
                            }
                        });
                        compteur=compteur +1;
                        SaisieE=1;

                    });

                    $.ajax({
                        url: "traitement/Facturation.php?acte=saisie_comptableCaisse",
                        method: 'GET',
                        dataType: 'json',
                        data: "cbMarq=" + $("#cbMarqEntete").val() + "&TransDoc="+transDoc,
                        success: function (data) {
                            $(data).each(function () {
                                var dateEch = "";
                                if (this.EC_Echeance != "") {
                                    var d = new Date(this.EC_Echeance);
                                    dateEch = ( ("00" + d.getDay()).substr(-2) + "/" + ("00" + d.getMonth()).substr(-2) + "/" + d.getFullYear());
                                }
                                var d = new Date(this.EC_Echeance);
                                var dataTab = "<tr><td>" + this.JO_Num + "</td><td>" + this.Annee_Exercice + "</td><td>" + this.EC_Jour + "</td><td>" + this.EC_RefPiece + "</td><td>" + this.EC_Reference + "</td>" +
                                    "<td>" + this.CG_Num + "</td><td>" + this.CT_Num + "</td><td>" + this.EC_Intitule + "</td><td>" + dateEch + "</td>" +
                                    "<td>" + (Math.round(this.EC_MontantDebit * 100) / 100) + "</td><td>" + (Math.round(this.EC_MontantCredit * 100) / 100) + "</td></tr>";
                                $("#tableEC > tbody").append(dataTab);
                                if (insert == 1) {
                                    /*$.ajax({
                                        url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=ajout',
                                        method: 'GET',
                                        dataType: 'json',
                                        data: "nomFichier=" + this.nomFichier + '&JO_Num=' + this.JO_Num + '&Annee_Exercice=' + this.Annee_Exercice + '&EC_Jour=' + this.EC_Jour + '&EC_Piece=' + this.EC_Piece + '&EC_RefPiece=' + this.EC_RefPiece
                                        + '&EC_Reference=' + this.EC_Reference + '&CG_Num=' + this.CG_Num + '&CG_NumCont=' + this.CG_Num + '&CT_Num=' + this.CT_Num
                                        + '&CT_NumCont=' + this.CT_Num + '&EC_Intitule=' + this.EC_Intitule + '&N_Reglement=1&EC_Echeance=' + this.EC_Echeance + '&EC_MontantCredit=' + this.EC_MontantCredit +
                                        '&EC_MontantDebit=' + this.EC_MontantDebit + '&TA_Code=' + this.TA_Code,
                                        async: false,
                                        success: function (data) {

                                        }
                                    });*/
                                }
                            });
                        }
                    });
                }
            });
            testCorrectLigneA();
        }
    }

    getSaisieComtpable(0);

    function testCorrectLigneA(){
        if(typeFacture=="PreparationCommande" || typeFacture=="AchatPreparationCommande"){
            $.ajax({
                url: "indexServeur.php?page=testCorrectLigneA&cbMarq="+$("#cbMarqEntete").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(data[0].VALID==1){
                        $('#imprimer').prop('disabled', false);
                        $('#valider').prop('disabled', false);
                    }
                    else{
                        $('#imprimer').prop('disabled', true);
                        $('#valider').prop('disabled', true);
                    }
                    if(admin==0 && visuProtect ==1 || $("#do_imprim").val() == 1) $('#imprimer').prop('disabled', false);
                }
            });
        }
    }
    testCorrectLigneA();
    function alimLigne(){
        $.ajax({
            url: 'traitement/Facturation.php?acte=ligneFacture',
            method: 'GET',
            dataType: 'html',
            async: false,
            data : "cbMarqEntete="+$("#cbMarqEntete").val()+"&typeFac="+typeFac
                +"&flagPxAchat="+$("#flagPxAchat").val()+"&flagPxRevient="+$("#flagPxRevient").val()+"&PROT_No="+prot_no,
            success: function(data) {
                $("#tableLigne > tbody").html(data);
            },
            error : function (data){

            }
        });
    }

    function stockMinDepasse(ar_ref,de_no){
        $.ajax({
            url: "traitement/Facturation.php?&acte=stockMinDepasse&AR_Ref=" + ar_ref + "&DE_No="+de_no,
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function (data) {
                if(data[0].stockMinDepasse==1)
                    alert("le stock minimum de l'article "+ar_ref+ " est dépassé ! (stock min : "+data[0].AS_QteMini+" stock : "+data[0].AS_QteSto+")");
            }
        });
    }

    function actionClient(val) {
        if(isVisu ==0) {
            $("#caisse").prop('disabled', val);
            if ($("#cbMarqEntete").val() != 0)
                $("#dateentete").prop('disabled', val);
            $("#souche").prop('disabled', val);
            $("#depot").prop('disabled', val);
            $("#affaire").prop('disabled', val);
            if (typeFacture != "PreparationCommande" && typeFacture != "AchatPreparationCommande")
                $('#cat_compta').prop('disabled', val);
        }
    }

    function verifSupprAjout(cbMarq,de_intitule,DL_Qte){
        $.ajax({
            url: 'indexServeur.php?page=verifSupprAjout&cbMarq='+cbMarq,
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                console.log(data)
                var stock = Math.round(data[0].AS_QteSto);
                if(stock>=DL_Qte)
                    supprime_ligne(cbMarq);
                else alert("la quantité du depot "+de_intitule+" est inssufisante ! (Qte : "+stock+")");
            },
            error : function (data){
                alert("la quantité du depot "+de_intitule+" est inssufisante ! (Qte : 0)");
            }
        });
    }


    function supprime_ligne (cbMarq/*,AR_Ref,DL_Qte,DL_CMUP,DE_No*/){
        $.ajax({
            url: "traitement/Facturation.php?acte=suppr&type_fac="+typeFacture+"&id="+cbMarq+"&PROT_No="+prot_no,
            method: 'GET',
            async:false,
            dataType: 'html',
            success: function(data) {
                modification=false;
                $('#reference').prop('disabled', false);
                $("#article_"+cbMarq).fadeOut(300, function() { $(this).remove(); });
                calculTotal();
                getSaisieComtpable(0);
            }
        });
    }

    function suppression(cbMarq,AR_Ref,DL_Qte/*,,DL_CMUP*/){
        $("<div>Voulez vous supprimer "+AR_Ref+" ?</div>").dialog({
            resizable: false,
            height: "auto",
            width: 500,
            modal: true,
            buttons: {

                "Oui": {
                    class: 'btn btn-primary',
                    text: 'Oui',
                    click: function() {
                        if(typeFacture=="Achat" || typeFacture=="AchatPreparationCommande"|| typeFacture=="PreparationCommande"){
                            var de_no = $("#depot").val();
                            var texte = $("#depot option:selected").text();
                            verifSupprAjout(cbMarq,texte,DL_Qte/*,AR_Ref,,DL_CMUP,de_no,texte*/);
                        } else
                            supprime_ligne(cbMarq,AR_Ref,DL_Qte,DL_CMUP,$("#depot").val());
                        $( this ).dialog( "close" );
                        $("#reference").focus()
                        $("#reference").prop("disabled",false)
                    }
                },
                "Non": {
                    class: 'btn btn-primary',
                    text: 'Non',
                    click: function () {
                        $(this).dialog("close");
                        $("#reference").focus()
                    }
                }
            }
        });
    }
/*
    $("#tableLigne").DataTable(
        {
            scrollY:        "300px",
            paging:         false,
            searching:      false,
            scrollCollapse: true,
            fixedColumns:   true,
            info:           false,
            "language": {
                "url":      "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        }
    );

    $("#tableRecouvrement").DataTable(
        {
            scrollY:        "300px",
            autoWidth:      true,
            paging:         false,
            searching:      false,
            info:           false,
            scrollCollapse: true,
            fixedColumns:   true,
            "language": {
                "url":      "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        }
    );
*/
    function calculTotal(){
        var montantht=0;
        var tva = 0;
        var precompte = 0;
        var marge = 0;
        var montantttc=0;
        var dataTable=0;
        $.ajax({
            url: "traitement/Facturation.php?acte=liste_article&protNo=0&cbMarq="+$("#cbMarqEntete").val()+"&type_fac="+typeFacture+"&cattarif="+$("#cat_tarif").val()+"&catcompta="+$("#cat_compta").val(),
            method: 'GET',
            async: false,
            dataType: 'html',
            success: function(data) {
                $("#piedPage").html(data);
                if(isVisu==0 && $("#cbMarqEntete").val()!=0) {
                    if (data.length > 0) {
                        $('#imprimer').prop('disabled', false);
                        $('#annuler').prop('disabled', false);
                        $('#valider').prop('disabled', false);
                        $("#reference").prop('disabled', false);
                        //$("#prix").prop('disabled', false);
                        //if(protectionprix==1 || protectionprix==2)
                        //    $("#prix").prop('disabled', true);
                        $("#remise").prop('disabled', false);
                        $("#quantite").prop('disabled', false);

                        actionClient(true);
                        $("#dateentete").prop('disabled', true);
                    } else {
                        $('#imprimer').prop('disabled', true);
                        $('#annuler').prop('disabled', true);
                        $('#valider').prop('disabled', true);
                        if(($("#cbMarqEntete").val()!=0) || (!$("#cbMarqEntete").val() != 0 && protectDate !=0))
                            $("#dateentete").prop('disabled', true);
                        else
                            $("#dateentete").prop('disabled', false);
                        if($("#cbMarqEntete").val()!=0) {
                            $("#reference").prop('disabled', false);
                            $("#prix").prop('disabled', false);
                            $("#remise").prop('disabled', false);
                            $("#quantite").prop('disabled', false);
                        }
                    }
                }
                testCorrectLigneA();
                if(isVisu ==1) $('#imprimer').prop('disabled', false);

                $('#reference').val("");
                $('#AR_Ref').val("");
                $('#designation').val("");
                $("#quantite").val("");
                $("#prix").val("");
                $("#quantite_stock").val("");
                $("#remise").val("");
            }
        });
    }
    calculTotal()
    $("#prix").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event);
    });
    $("#reference").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event);
    });

    $("#remise").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event);
        else isRemise($("#remise"),event);
    });

    function isRemise(donnee,event){
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((donnee.val().length >0 && event.keyCode >= 85 && (donnee.val().indexOf("U")<0 && donnee.val().indexOf("u")<0  && donnee.val().indexOf("%")<0)) ||
            (event.keyCode >= 48 && event.keyCode <= 57 &&(donnee.val().indexOf("U")<0 && donnee.val().indexOf("u")<0  && donnee.val().indexOf("%")<0)) ||
            (event.keyCode >= 96 && event.keyCode <= 105 && (donnee.val().indexOf("U")<0 && donnee.val().indexOf("u")<0 && donnee.val().indexOf("%")<0)) ||
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || (donnee.val().length >0 && donnee.val().indexOf(".")<0 && donnee.val().indexOf(",")<0 && event.keyCode == 188) || (donnee.val().length >0 && donnee.val().indexOf(".")<0  && donnee.val().indexOf(",")<0 && event.keyCode == 110)) {

        } else {
            event.preventDefault();
        }
    }

    $('#quantite').keydown(function (e){
        ajout_ligne(e);
    });
    function valideReferenceAchat(reference){
        $.ajax({
            url: "indexServeur.php?page=getPrixClientAch&CT_Num="+$("#CT_Num").val()+"&AR_Ref="+reference+"&N_CatTarif="+$("#cat_tarif").val()+"&N_CatCompta="+$("#cat_compta").val(),
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function(data) {
                /*if(modification)$( "#reference").val(reference);
                else $( "#reference").val(reference+" - "+data[0].AR_Design);
                */pmin = Math.round(data[0].Prix_Min*100)/100;
                pmax = Math.round(data[0].Prix_Max*100)/100;
                var tmp=pmax;
                if(pmin>pmax){
                    pmax=pmin;
                    pmin=tmp;
                }
                alimente_qteStock(reference);
                if(!modification) $("#prix").val(Math.round((data[0].AR_PrixAch)*100)/100);
                $("#taxe1").val(data[0].taxe1);
                $("#taxe2").val(data[0].taxe2);
                $("#taxe3").val(data[0].taxe3);
            }
        });
    }

    function updateLibPied() {
        var typePage = "0";
        if (typeFacture == "Achat" || typeFacture == "AchatRetour") typePage = "1";
        $.ajax({
            url: "indexServeur.php?page=getLibTaxePied&N_CatTarif=" + typePage + "&N_CatCompta=" + $("#cat_compta").val(),
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function (data) {
                if (data[0].LIB1 == null) $("#blocLibTaxe1").hide();
                else {
                    $("#blocLibTaxe1").show();
                    $("#libTaxe1").html(data[0].LIB1);
                }
                if (data[0].LIB2 == null) $("#blocLibTaxe2").hide();
                else {
                    $("#blocLibTaxe2").show();
                    $("#libTaxe2").html(data[0].LIB2);
                }
                if (data[0].LIB3 == null) $("#blocLibTaxe3").hide();
                else {
                    $("#blocLibTaxe3").show();
                    $("#libTaxe3").html(data[0].LIB3);
                }
            }
        });
    }


    function majCatCompta() {
        $.ajax({
            url: "indexServeur.php?page=majCatCompta&N_CatTarif=" + $("#cat_tarif").val() + "&N_CatCompta=" + $("#cat_compta").val(),
            method: 'GET',
            dataType: 'json',
            async: false,
            data: "cbMarq=" + $("#cbMarqEntete").val(),
            success: function (data) {
            }
        });
    }
});
