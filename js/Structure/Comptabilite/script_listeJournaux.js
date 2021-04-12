jQuery(function($){

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
    
    if($_GET("acte")=="ajoutOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>'+$_GET("JO_Num")+' a bien été enregistré !</div>');
    }

    if($_GET("acte")=="modifOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>'+$_GET("JO_Num")+' a bien été modifié !</div>');
    }

    if($_GET("acte")=="supprOK"){
            $("#add_err").css('display', 'inline', 'important');
            $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>'+$_GET("JO_Num")+' a bien été supprimé !</div>');
    }

    if($_GET("acte")=="supprKO"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La suppression de '+$_GET("JO_Num")+' a échoué !</div>');
    }

    $('#tableJournal').DataTable({
        "language":     {
                "url":  "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        },
        "initComplete": function(settings, json) {
            $("#tableJournal_filter").find(":input").addClass("form-control");
            $("#tableJournal_length").find(":input").addClass("form-control");
        }
    });
/*
    $("#annee_exercice", "#type" , "#codeJournal","#codeMois").autocomplete({
        autoFocus: true,
        closeOnSelect: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#filter").submit();
        }
    });
 */
    $("#annee_exercice").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        , placeholder: ''
    }).on("select2:select", function (e) {
        $("#filter").submit();
    });
    $("#type").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        , placeholder: ''
    }).on("select2:select", function (e) {
        $("#filter").submit();
    });
    $("#codeJournal").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        , placeholder: ''
    }).on("select2:select", function (e) {
        $("#filter").submit();
    });
    $("#codeMois").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        , placeholder: ''
    }).on("select2:select", function (e) {
        $("#filter").submit();
    });

    $(".select2-selection__clear").click(function(){
        $("#filter").submit()
    })

});