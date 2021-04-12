jQuery(function($) {

    var select2Url = "getTiersByNumIntitule"
    if($("#typeInterrogation").val()!="Tiers")
        select2Url = "getComptegByCGNum"

    function refreshTable() {
        $.ajax({
            url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=afficheLigneTiers',
            method: 'GET',
            dataType: 'html',
            data: 'CT_Num=' + $("#ctNum").val() + '&dateDebut=' + $("#dateDebut").val() + '&dateFin=' + $("#dateFin").val() + '&typeEcriture=' + $("#typeEcriture").val()+"&typeInterrogation="+$("#typeInterrogation").val(),
            async: false,
            success: function (data) {
                $("#interrogationTiers > tbody").html(data)
                updateTotaux()
                soldeLettrage()
            }
        });
    }

    $("#ctNum").select2({
        theme: "bootstrap"
        , allowClear: true
        , dropdownAutoWidth: true
        , placeholder: ''
        , ajax: {
            url: 'indexServeur.php?page='+select2Url,
            dataType: "json",
            type: "GET",
            data: function (params) {

                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.label,
                            id: item.value
                        }
                    })
                };
            }
        }
    }).on("select2:select", function (e) {
        refreshTable()
        getLettrage()
    });

    $("#dateFin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(new Date().getFullYear(), 11, 31));
    $("#dateDebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(new Date().getFullYear(), 0, 1));

    $("#dateDebut").change(function () {
        refreshTable()
    })

    $("#dateFin").change(function () {
        refreshTable()
    })

    $("#typeEcriture").change(function () {
        refreshTable()
    })

    $('#interrogationTiers').DataTable({
        scrollY: "300px",
        scrollCollapse: true,
        fixedColumns: true,
        paging: false,
        searching: false,
        info: false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
        , "initComplete": function (settings, json) {
        }
    });

    function getTotalJournal(ecSens,lettrage) {
        var result=0;
        $.ajax({
            url: 'indexServeur.php?page=getTotalJournal',
            method: 'GET',
            dataType: 'json',
            data:   'JO_Num=&Mois=0&Annee=' + $("#AnneeExercice").val() + '&EC_Sens=' + ecSens +"&typeInterrogation="+$("#typeInterrogation").val()
                +'&CT_Num=' + $("#ctNum").val() + '&dateDebut=' + $("#dateDebut").val() + '&dateFin=' + $("#dateFin").val() + '&lettrage=' + lettrage ,
            async: false,
            success: function (data) {
                result = data.EC_Montant
            }
        })
        return result;
    }

    function getLettrage() {
        $.ajax({
            url: 'indexServeur.php?page=getLettrage',
            method: 'GET',
            dataType: 'json',
            data:   'CT_Num=' + $("#ctNum").val() + '&dateDebut=' + $("#dateDebut").val() + '&dateFin=' + $("#dateFin").val() +"&typeInterrogation="+$("#typeInterrogation").val(),
            async: false,
            success: function (data) {
                $("#lettre").val(data.EC_Lettrage)
            }
        })
    }
    getLettrage()

    function updateTotaux(){
        $("#totauxDebit").val(getTotalJournal(0,$("#typeEcriture").val()))
        $("#totauxCredit").val(getTotalJournal(1,$("#typeEcriture").val()))
        var solde = getTotalJournal(2,$("#typeEcriture").val());
        $("#soldeCompteCredit").val(null)
        $("#soldeCompteDebit").val(null)
        if(solde>0)
            $("#soldeCompteCredit").val(Math.abs(solde))
        if(solde<0)
            $("#soldeCompteDebit").val(Math.abs(solde))
    }
    updateTotaux()

    function soldeLettrage(){
        $("input[type=checkbox]").each(function () {
            $(this).click(function(){
                calculSoldeLettrage()
            })
        })
    }
    soldeLettrage()

    function listCbMarqCheck(){

        var listCbMarq = []
        $(":checkbox:checked").each(function () {
            listCbMarq.push($(this).parent().parent().find("#cbMarq").html());
        })
        return listCbMarq.join(",")
    }

    $("#fonctions").change(function(){
        if($(this).val() == 3)
            lettrageEcriture(1)
        if($(this).val() == 4)
            lettrageEcriture(0)
    })

    function calculSoldeLettrage(){
        $.ajax({
            url: 'indexServeur.php?page=calculSoldeLettrage',
            method: 'GET',
            dataType: 'json',
            data:   'listCbMarq='+listCbMarqCheck(),
            async: false,
            success: function (data) {
                $("#soldeLettrageDebit").val(data[0].EC_MontantCredit)
                $("#soldeLettrageCredit").val(data[0].EC_MontantDebit)
            }
        })
    }

    function lettrageEcriture(annuler){
        var lettrage = $("#lettre").val()
        if(annuler==0)
            lettrage = ""
        $.ajax({
            url: 'indexServeur.php?page=pointerEcriture',
            method: 'GET',
            dataType: 'json',
            data:   'listCbMarq='+listCbMarqCheck()+"&annuler="+annuler+"&ecLettrage="+lettrage,
            async: false,
            success: function (data) {
                if(data.Result==0)
                    alert("le solde lettrage n'est pas egale à zéro !")
                else {
                    refreshTable()
                    getLettrage()
                }
            }
        })
    }


    $("#soldeLettrageDebit, #soldeLettrageCredit, #totauxDebit, #totauxCredit, #soldeCompteCredit, #soldeCompteDebit").inputmask({
        'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: false,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: true
    });
})
