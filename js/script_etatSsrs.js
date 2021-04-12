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

    if($("#montant").val()=="")
        $("#montant").val(0);
    $("#montant").inputmask({   'alias': 'integer',
        'groupSeparator': '',
        'autoGroup': true,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: true
    });

    if($_GET("module")==5 && $_GET("action")==2){
        $("#DateFin").hide();
    }

    $("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#DateDebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#DateFin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    if($_GET("POST_Data")==0) {
        $("#datedebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        $("#DateDebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }
    if($_GET("POST_Data")==0) {
        $("#datefin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        $("#DateFin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }

    $("#ArticleDebut").autocomplete({
        source: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&rechEtat=1",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#ArticleDebutParam").val(ui.item.AR_Design)
            $("#ArticleDebut").val(ui.item.AR_Ref)
        }
    })

    $("#ArticleDebut").focusout(function(){
        if($("#ArticleDebut").val()!="")
            $.ajax({
                url: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&term="+$("#ArticleDebut").val()+"&rechEtat=1",
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data!="")
                        $("#ArticleDebut").val(data[0].AR_Ref)
                    else
                        $("#ArticleDebut").val("")
                }
            })
    })

    $("#ClientDebut").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&type=0",
        autoFocus: true,
        select: function (event, ui) {
            $("#ClientDebutParam").val(ui.item.CT_Num)
            $("#ClientDebut").val(ui.item.CT_Intitule)
        }
    })
/*    $("#ClientDebut").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        ,placeholder: 'Select an item'
        ,ajax: {
            url: '/autocompletePro.php',
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
        }).on("select2:select", function (e) {
        $("#filter").submit();
    });

    $(".select2-selection__clear").click(function(){
        $("#filter").submit()
    })*/

    $("#ClientDebut").focusout(function(){
        if($("#ClientDebut").val()!="")
            $.ajax({
                url: "indexServeur.php?page=getTiersByNumIntitule&type=0&term="+$("#ClientDebutParam").val(),
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data!="")
                        $("#ClientDebut").val(data[0].CT_Intitule)
                    else
                        $("#ClientDebut").val("")
                }
            })
    })

    $("#ClientFin").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&type=0",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#ClientFinParam").val(ui.item.CT_Intitule)
            $("#ClientFin").val(ui.item.CT_Num)
        }
    })

    $("#ClientFin").focusout(function(){
        if($("#ClientFin").val()!="")
            $.ajax({
                url: "indexServeur.php?page=getTiersByNumIntitule&type=0&term="+$("#ClientFin").val(),
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data!="")
                        $("#ClientFin").val(data[0].CT_Num)
                    else
                        $("#ClientFin").val("")
                }
            })
    })

    $("#Agence").autocomplete({
        source: "indexServeur.php?page=getDepotByDENoIntitule&exclude=-1&principal=-1",
        autoFocus: true,
        mustMatch:true,
        matchContains:false,
        minChars:1,
        autoFill:false,
        select: function (event, ui) {
            event.preventDefault();
            $("#Agence").val(ui.item.DE_No)
        }
    })
    $("#Agence").focusout(function(){
        if($("#Agence").val()!="")
            $.ajax({
                url: "indexServeur.php?page=getDepotByDENoIntitule&exclude=-1&principal=-1&term="+$("#Agence").val(),
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data!="")
                        $("#Agence").val(data[0].DE_No)
                    else
                        $("#Agence").val("")
                }
            })
    })
    $("#ArticleFin").autocomplete({
        source: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&rechEtat=1",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#ArticleFin").val(ui.item.AR_Ref)
        }
    });
    $("#ArticleFin").focusout(function(){
        if($("#ArticleFin").val()!="")
            $.ajax({
                url: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&term="+$("#ArticleFin").val()+"&rechEtat=1",
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data!="")
                        $("#ArticleFin").val(data[0].AR_Ref)
                    else
                        $("#ArticleFin").val("")
                }
            })
    })

    function setDateIndique(){
        if($("#choix_inv").val()==1){
            $("#datedebut").prop('disabled', true);
            $("#datedebut").val("");
        }
        if($("#choix_inv").val()==2){
            $("#datedebut").prop('disabled', false);
            $("#datedebut").val($.datepicker.formatDate('ddmmy', new Date()));
        }
    }

    setDateIndique();
    $("#choix_inv").change(function(){
        setDateIndique();
    });

});