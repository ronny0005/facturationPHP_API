jQuery(function ($) {
    $('.clockpicker').clockpicker({
        donetext: 'Valider'
    });


    $("#valider").click(function(){
        if($("#jourFin").val()<$("#jourDebut").val()){
            alert('La sélection des jours n\'est pas correct !');
        }else{
            $("form").submit();
        }
    });


    $("#user").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {
        $("#PROT_NoUser").val($('#user').select2('data')[0].id);
        setInfo();
    });

    function init(jour){
        $("#check"+jour+"").prop('checked', false);
        heureDebut = "00:00";
        heureFin = "00:00";
        $("#heureDebut"+jour).val(heureDebut);
        $("#heureFin"+jour).val(heureFin);
    }
    function eachDay(){
        init("Lundi")
        init("Mardi")
        init("Mercredi")
        init("Jeudi")
        init("Vendredi")
        init("Samedi")
        init("Dimanche")
    }

    $("#PROT_NoUser").val($('#user').select2('data')[0].id);
    function setInfo(){
        eachDay()
        $.ajax({
            url: "indexServeur.php?page=getCalendarUser",
            method: 'GET',
            dataType: 'json',
            async: false,
            data : "PROT_No="+$('#user').select2('data')[0].id+"&Jour=0",
            success: function (data) {
                if(data!="") {
                    data.forEach(function(element) {
                        jour = getJour(element.ID_JourDebut);
                        $("#check"+jour+"").prop('checked', true);
                        heureDebut = ("00" + element.ID_HeureDebut).substr(-2) + ":" + ("00" + element.ID_MinDebut).substr(-2);
                        heureFin = ("00" + element.ID_HeureFin).substr(-2) + ":" + ("00" + element.ID_MinFin).substr(-2);
                        $("#heureDebut"+jour).val(heureDebut);
                        $("#heureFin"+jour).val(heureFin);
                    });
                }else{
                    $("td[id^='suppr_']").each
                    $("[id^='check']").each(function(){
                        $(this).prop('checked', false);
                    })
                    $("[id^='heureDebut']").each(function(){
                        $(this).val("00:00");
                    })
                    $("[id^='heureFin']").each(function(){
                        $(this).val("00:00");
                    })
                }
            }
        });
    }
    setInfo();

    function getJour(value){
        switch (value) {
            case "1":
                return "Lundi"
                break;
            case "2":
                return "Mardi"
                break;
            case "3":
                return "Mercredi"
                break;
            case "4":
                return "Jeudi"
                break;
            case "5":
                return "Vendredi"
                break;
            case "6":
                return "Samedi"
                break;
            case "7":
                return "Dimanche"
                break;
        }
    }
});
