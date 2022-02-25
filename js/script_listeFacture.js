jQuery(function($){
    var protect = 0;
    var type = $("#typedocument").val()
    if($("#PROT_CbCreateur").val()!=2)
        $('[data-toggle="tooltip"]').tooltip();
    $("#menu_transform").hide();

    function referencement(){
    }


    function displayListeFacture(){
        $.ajax({
            url: "indexServeur.php?page=displayListeFacture",
            method: 'GET',
            dataType: 'html',
            data : "typeFac="+$("#typedocument").val()+"&client="+$("#CT_Num").val()+"&depot="+$("#depot").val()+"&datedeb="+$("#datedebut").val()+"&datefin="+$("#datefin").val()+"&protNo="+$("#PROT_No").val()+"&type="+$("#type").val(),
            beforeSend : function () {
                // before send, show the loading gif
                $("#tableListeFacture").html("<div style='margin: 0 auto;' class='loader'></div>")
            },
            success: function (data) {
                $("#tableListeFacture").hide().html(data).fadeIn("slow")
            }
        });
    }

    displayListeFacture()

    $("#DOPiece").keyup(function(){
        if($(this).val().length > 3) {
            $.ajax({
                url: "indexServeur.php?page=findDocByPiece&value=" + $(this).val()+"&type_fac="+type+"&PROT_No="+$("#PROT_No").val(),
                method: 'GET',
                dataType: 'html',
                async: false,
                beforeSend : function () {
                    // before send, show the loading gif
                    $("#tableListeFacture > tbody").html("<div style='margin: 0 auto;' class='loader'></div>")
                }
                ,
                success: function (data) {
                    $("#tableListeFacture > tbody").html(data)
                }
            });
        }
    })

    $("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});

    if($("#post").val()==0) {
        $("#datefin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        $("#datedebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }


    $("table.table > tbody > tr #transform").on('click', function() {
        var cbMarq = $(this).parent().parent().find("#cbMarq").html();
        var entete = $(this).parent().parent().find("#entete a").html();
        var doRef = $(this).parent().parent().find("#DO_Ref").html();
        var doDate = $(this).parent().parent().find("#DO_Date").html();
        doDate = doDate.replace("-","").replace("-","")
        doDate = doDate.substr(0,4)+doDate.substr(-2)
        $("#reference").val(doRef)
        $("#date_transform").val(doDate)
        $("#menu_transform").dialog({
            title: "Transformation du document " + entete,
            resizable: false,
            height: "auto",
            width: 600,
            modal: true,
            buttons: {
                "Valider": {
                    class: 'btn btn-primary',
                    text: 'Valider',
                    click: function () {
                        canTransform(cbMarq)
                    }
                }
            }
        });
    });



    $("#client").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&TypeFac="+type+"&select=-1",
        autoFocus: true,
        select: function(event, ui) {
            event.preventDefault();
            $("#client").val(ui.item.label)
            $("#CT_Num").val(ui.item.value)
        },
        focus: function(event, ui) {
        }
    })

    function canTransform(cbMarq){
        $.ajax({
            url: "Traitement/Facturation.php?acte=canTransform&type_trans=" + $("#type_trans").val() + "&type=" + type,
            method: 'GET',
            data: "cbMarq=" + cbMarq,
            dataType: 'html',
            async : false,
            success: function (data) {
                if(data=="")
                    transformeEntete(cbMarq,1)
                else
                    if (confirm("La quantité en stock des "+data+" est inssufisante ! Voulez vous transformer le reste ?")) {
                        transformeEntete(cbMarq,0)
                    }
            }
        })
    }

    function suppr_factureConversion(cbMarq,entete,typeFact,ligne){
        $.ajax({
            url: "Traitement/Facturation.php?acte=suppr_factureConversion",
            method: 'GET',
            data: "cbMarq="+cbMarq,
            dataType: 'html',
            async : false,
            success: function(data) {
                if(data=="")
                    supprFacture(cbMarq,entete,typeFact,ligne)
                else if(data=="securiteAdmin"){
                    alert("Vous n'avez pas les droits sur ce dépôt")
                }
                else{
                    $("<div>"+data+"</div>").dialog({
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
                                        url: "Traitement/Facturation.php?acte=transformDoc&type="+typeFact,
                                        method: 'GET',
                                        data: "cbMarq=" + cbMarq,
                                        dataType: 'html',
                                        async : false,
                                        success: function (data) {
                                            dialog.dialog( "close" )
                                            location.reload()
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
            }
        })
    }

    function supprFacture(cbMarq,entete,typeFact,ligne){
        $("<div>Voulez vous supprimer la facture "+entete+" ?</div>").dialog({
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            title: "Suppression de la facture",
            buttons: {
                "Oui": {
                    class: 'btn btn-primary',
                    text: 'Oui',
                    click: function () {
                        $.ajax({
                            url: "Traitement/Facturation.php?acte=suppr_facture&type="+typeFact,
                            method: 'GET',
                            data: "cbMarq=" + cbMarq,
                            dataType: 'html',
                            success: function (data) {

                            }
                        })
                        ligne.hide("slow");
                        $( this ).dialog( "close" )
                        supprLigne()
                    }
                },
                "Non": {
                    class: 'btn btn-primary',
                    text: 'Non',
                    click: function () {
                        $( this ).dialog( "close" )
                    }
                }
            }
        })
    }

    function supprLigne(){
        $("tr[id^='article_']").each(function(){
            $(this).unbind()
            var ligne = $(this);
            var cbMarq = $(this).find("#cbMarq").html()
            var entete = $(this).find("#entete a").html()
            $(this).find("td[id^='supprFacture']").click(function () {
                $(this).unbind()
                suppr_factureConversion(cbMarq,entete,type,ligne)
            });
        })
    }
    supprLigne()

    function transformeEntete(cbMarq,canTransformFact){
        $.ajax({
            url: "Traitement/Facturation.php?acte=transBLFacture&type_trans="+$("#type_trans").val()+"&type="+type,
            method: 'GET',
            data: "cbMarq="+cbMarq+"&date="+$("#date_transform").val()+"&conserv_copie=0&reference="+$("#reference").val()+"&canTransform="+canTransformFact,
            dataType: 'html',
            async : false,
            success: function(data) {
                location.reload()
            }
        });
    }
    referencement();

    $(".dynatable-page-link").on('click', function(){
        referencement();
    });
    
    $("#dynatable-query-search-table").keyup(function(e){
        referencement(); 
    });

    if ($("#flagDelai").val() != -1)
        $("#date_transform").datepicker({
            minDate: -$("#flagDelai").val(),
            maxDate: $("#flagDelai").val(),
            dateFormat: "ddmmy",
            altFormat: "ddmmy",
            autoclose: true
        });
    else
        if($("#date_transform").val()=="")
            $("#date_transform").datepicker({dateFormat:"ddmmy"}).datepicker("setDate",new Date());

    if($("#ClotureVente").val()!="undefined"){
        $("#ClotureVente").click(function(){
            $("#FormClotureVente").dialog({
                resizable: false,
                height: "auto",
                width: 500,
                modal: true,
                async: false,
                title : "Cloture vente",
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function () {
                            $.ajax({
                                url: "traitement/Facturation.php?acte=clotureVente",
                                method: 'GET',
                                dataType: 'html',
                                data: "CA_Num=" + $("#affaire").val(),
                                async: false,
                                success: function (data) {
                                    if (data == "")
                                        alert("La cloture s'est bien déroulée !");
                                    else
                                        alert(data);
                                }
                            });
                            $(this).dialog("close");
                        }
                    }
                }
            });


        });
    }

});