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

    if($_GET("action")==2 || $_GET("action")==41){
        $("#DateFin").parent().hide();
    }

    if($_GET("action")==43 || $_GET("action")==23){
        $("#DateFin").parent().hide();
        $("#DateDebut").parent().hide();
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


    if($_GET("action") == 36) {
        var today = new Date();
        var yyyy = today.getFullYear();
        if($("#POST_Data").val()==0) {
            $("#DateDebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(yyyy + '-01-01'));
            $("#DateFin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(yyyy + '-12-31'));
        }
    }

    $("a").each(function() {
        var href =$(this).attr("href");
        if(href!=undefined)
            if(href.indexOf("$$")!=-1)
            {
                var source= href.substr(0,href.indexOf("?"));
                source = source+"?module="+$_GET("module")+"&action="+$_GET("action")+"&";
                var last = href.substr(href.indexOf("?")+1,href.length);
                $(this).attr("href",source.concat(last));
                var img = $(this).find("img");
                if(img.attr("alt") == "Non trié"  || img.attr("alt") == "Unsorted"){
                    img.remove()
                    $(this).append("<span class='fa fa-arrows-v'/>")
                }
                if(img.attr("alt") == "Trié par ordre croissant" || img.attr("alt") == "Sorted Ascending"){
                    img.remove()
                    $(this).append("<span class='fa fa-caret-up'/>")
                }
                if(img.attr("alt") == "Trié par ordre décroissant"  || img.attr("alt") == "Sorted Descending"){
                    img.remove()
                    $(this).append("<span class='fa fa-caret-down'/>")
                }
            }
    })

    $("#ComptegDebut").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        ,placeholder: "Tout les comptes"
        ,ajax: {
            url: "indexServeur.php?page=getComptegByCGNum",
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

    });

    $("#Emplacement").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        ,placeholder: "Tout les emplacements"
        ,ajax: {
            url: "indexServeur.php?page=getEmplacement&protNo="+$("#PROT_No").val(),
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

    });

    $("#ComptegFin").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        ,placeholder: "Tout les comptes"
        ,ajax: {
            url: "indexServeur.php?page=getComptegByCGNum",
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

    });

    $("#ArticleDebut").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        ,placeholder: "Tout les articles"
        ,ajax: {
            url: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&rechEtat=1",
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

    });

    $("#ArticleFin").select2({
        theme: "bootstrap"
        ,allowClear: true
        ,dropdownAutoWidth: true
        ,placeholder: "Tout les articles"
        ,ajax: {
            url: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&rechEtat=1",
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

    });

    function setTiers(typeTiers){
        $("#ClientDebut").select2({
            theme: "bootstrap"
            ,allowClear: true
            ,dropdownAutoWidth: true
            ,placeholder: "Tout"
            ,ajax: {
                url: 'indexServeur.php?page=getTiersByNumIntitule&typeTiers='+typeTiers,
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

        });

        $("#ClientFin").select2({
            theme: "bootstrap"
            ,allowClear: true
            ,dropdownAutoWidth: true
            ,placeholder: "Tout"
            ,ajax: {
                url: "indexServeur.php?page=getTiersByNumIntitule&typeTiers="+typeTiers,
                dataType: "json",
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

        });

        $("#FournisseurDebut").select2({
            theme: "bootstrap"
            ,allowClear: true
            ,dropdownAutoWidth: true
            ,placeholder: "Tout"
            ,ajax: {
                url: 'indexServeur.php?page=getTiersByNumIntitule&typeTiers=1',
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

        });

        $("#FournisseurFin").select2({
            theme: "bootstrap"
            ,allowClear: true
            ,dropdownAutoWidth: true
            ,placeholder: "Tout"
            ,ajax: {
                url: "indexServeur.php?page=getTiersByNumIntitule&typeTiers=1",
                dataType: "json",
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

        });
    }

    setTiers((($("#TypeTiers").val()==undefined || $("#TypeTiers").val()==-1)  ? 0 : $("#TypeTiers").val()))

    $("#TypeTiers").change(function(){
        setTiers((($("#TypeTiers").val()==undefined  || $("#TypeTiers").val()==-1) ? 0 : $("#TypeTiers").val()))
    })

    $("#choix_inv").change(function(){
        choixInv()
    })

    function choixInv(){
        if($("#choix_inv").val()!=undefined)
            if($("#choix_inv").val()==2) {
                $("#datedebut").prop("disabled", false)
            }
            else {
                $("#datedebut").prop("disabled", true)
            }
    }
    choixInv()

    $("#A_Analytique").change(function(){
        listAnalytique($("#A_Analytique").val())
    })

    function listAnalytique (analytique){
        $("#CA_Num option").remove()
        $.ajax({
            url: "indexServeur.php?page=sectionByPlan&nAnalytique="+analytique,
            method: 'GET',
            dataType: 'html',
            success: function (data) {
                $("#CA_Num").append(data);
            }
        })
    }

    listAnalytique($("#A_Analytique").val())

    function setDateIndique(){
        if($("#ChoixInventaire").val()==0){

            $("#DateDebut").prop('enabled', true);
            $("#DateDebut").val("010120")
            $("#DateFin").val("010120")
            $("#dateIndique").val(0);
            $("#DateDebut").parent().hide();
            $("#DateFin").parent().hide();
        }
        if($("#ChoixInventaire").val()==1){
            $("#DateDebut").prop('enabled', false);
            $("#DateDebut").val($.datepicker.formatDate('ddmmy', new Date()));
            $("#dateIndique").val(1)
            $("#DateDebut").parent().show();
            $("#DateFin").parent().hide();
        }
    }
    if($_GET("action") == 12)
        setDateIndique();
    if($("#POST_Data").val()!=1)
        setDateIndique();

    $("#ChoixInventaire").change(function(){
        setDateIndique()
    });

});