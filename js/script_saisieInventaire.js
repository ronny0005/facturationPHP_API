jQuery(function($){ 
    var latitude= 0;
    var longitude= 0;
    var pmin=0;
    var pmax=0;
    var entete="";
    var entete21="";
    var valideinventaire=0;
    var suivant="";
    $("#reference").combobox();

    var cmp = 0;
    $(".custom-combobox").each(function () {
        if (cmp == 0) $(this).find(":input").addClass("comboreference");
        cmp = cmp + 1;
    });

    $(".comboreference").val("");
        
        function isNumber(donnee,event){
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || (donnee.val().indexOf(".")<0 && donnee.val().indexOf(",")<0 && event.keyCode == 188) || (donnee.val().indexOf(".")<0  && donnee.val().indexOf(",")<0 && event.keyCode == 110)) {

        } else {
            event.preventDefault();
        }
    }
    
    
    
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    $("#valeur_ajustee").prop('disabled', true);
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_Right;
                    if(protect==1){
                    }
                });
            }
        });
    }
    
    protection(); 
    
    function isNumber(donnee,event){
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || (donnee.val().indexOf(".")<0 && donnee.val().indexOf(",")<0 && event.keyCode == 188) || (donnee.val().indexOf(".")<0  && donnee.val().indexOf(",")<0 && event.keyCode == 110)) {
        } else {
            event.preventDefault();
        }
    }
    
    $(".comboreference").focusout(function(){
        if($(".comboreference").val()!=""){
            $("table.table > tbody > tr").each(function() {
                if($("#reference").val()==$(this).find("td#tab_ref").html()){
                    $("#designation").val($(this).find("td#tab_design").html());
                    $("#qte").val($(this).find("td#tab_qte").html());
                    $("#pr_unit").val($(this).find("td#tab_prix").html());
                    $("#valeur").val($(this).find("td#tab_mtstk").html());
                    $("#conditionnement").val($(this).find("td#tab_enum").html());
                }
            });
        }
    });
    
    $("table.table > tbody > tr").on("dblclick",function() {
        window.scrollTo(0, 0);
        $("#reference").val($(this).find("td#tab_ref").html());
        $(".comboreference").val($("#reference").val());
        $("#designation").val($(this).find("td#tab_design").html());
        $("#qte").val($(this).find("td#tab_qte").html());
        $("#pr_unit").val($(this).find("td#tab_prix").html());
        $("#valeur").val($(this).find("td#tab_mtstk").html());
        $("#qte_ajustee").val($(this).find("td#tab_qteajust").html());
        $("#pr_ajuste").val($(this).find("td#tab_prajust").html());
        $("#valeur_ajustee").val($(this).find("td#tab_valajust").html());
        $("#conditionnement").val($(this).find("td#tab_enum").html());
    });

    function calculValAjustee(){
        if($("#qte_ajustee").val()>0 && $("#pr_ajuste").val()>0){
            $("#valeur_ajustee").val($("#qte_ajustee").val() * $("#pr_ajuste").val().replace(",", "."));
        }
    }
    
    $("#depot").change(function(){
        window.location.replace("indexMVC.php?module=1&action=3&depot="+$("#depot").val());
    });
    
    $("#qte_ajustee").focusout(function(){
        if($("#qte_ajustee").val()>0){
            calculValAjustee();
            $("#pr_ajuste").prop('disabled', false);
        }
    });
    
    $("#qte_ajustee").keydown(function (e){
        calculValAjustee();
        valide(e);
    });
    
    $("#qte_ajustee").keyup(function (e){
        calculValAjustee();
    });
    $("#pr_ajuste").keyup(function (e){
        calculValAjustee();
        if(($("#qte_ajustee").val()=="" || $("#qte_ajustee").val()==0) && $("#qte").val()==0)
            $("#pr_ajuste").val("");
    });
    $("#pr_ajuste").keydown(function (e){
        isNumber($("#pr_ajuste"),e); 
        if(($("#qte_ajustee").val()=="" || $("#qte_ajustee").val()==0) && $("#qte").val()==0)
            $("#pr_ajuste").val("");
        calculValAjustee();
        valide(e);
    });
    function refSuivante(ref){
        var ajout=0;
        $("table.table > tbody > tr").find("td#tab_ref").each(function(){
            if(ajout==1){
                ajout=0;
                suivant=$(this).html();
            }
            if($(this).html()==ref){
                ajout=1;
            }
        });
    }
        
    
    function valide(e){
        if(e.keyCode == 13){
            refSuivante($(".comboreference").val());
            if($(".comboreference").val()!=""){
                valideinventaire=1;
                $("#depot").prop('disabled', true);
                $("table.table > tbody > tr").each(function() {
            
                    var val="";
                    val = Math.round($("#pr_ajuste").val().replace(",", ".") * $("#qte_ajustee").val()*100)/100; 
                    if($("#pr_ajuste").val()=="" || $("#qte_ajustee").val()=="") val="";
                    if($("#qte_ajustee").val()=="" && $("#qte").val()!=0)
                    val = Math.round($("#pr_ajuste").val() * $("#qte").val()*100)/100;
                    if($(this).find("td#tab_ref").html()==suivant){
                        $("#reference").val($(this).find("td#tab_ref").html());
                        $(".comboreference").val($("#reference").val());
                        $("#designation").val($(this).find("td#tab_design").html());
                        $("#qte").val($(this).find("td#tab_qte").html());
                        $("#pr_unit").val($(this).find("td#tab_prix").html());
                        $("#valeur").val($(this).find("td#tab_mtstk").html());
                        $("#qte_ajustee").val($(this).find("td#tab_qteajust").html());
                        $("#pr_ajuste").val($(this).find("td#tab_prajust").html());
                        $("#valeur_ajustee").val($(this).find("td#tab_valajust").html());
                        $("#conditionnement").val($(this).find("td#tab_enum").html());
                    }
                        
                    if($("#reference").val()==$(this).find("td#tab_ref").html() && ($("#qte_ajustee").val()!="" || $("#pr_ajuste").val()!="")){
                        $(this).find("td#tab_qteajust").html($("#qte_ajustee").val());
                        $(this).find("td#tab_prajust").html($("#pr_ajuste").val().replace(",", "."));
                        $(this).find("td#tab_valajust").html(val);
                        $(this).find("input#valide").val(1);
                        clear();
                    }
                });
            }
        }
    }
    
    function clear(){
        $("#qte_ajustee").val("");
        $("#pr_ajuste").val("");
        $("#valeur_ajustee").val("");
        $("valeur_ajustee").val("");
        $(".comboreference").val("");
        $("#designation").val("");
        $("#qte").val("");
        $("#pr_unit").val("");
        $("#valeur").val("");
        $("#conditionnement").val("");
        
    }
    
    function valideEntreeInventaire(date,depot){
        if(valideinventaire==1){
            $.ajax({
                url: "traitement/SaisieInventaire.php?acte=inventaireEntree&date="+date+"&depot="+depot,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var ente= data.entete;
                    $("table.table > tbody > tr").each(function() {
                        if($(this).find("td#tab_ref").html()!=null){
                            var prix = $(this).find("td#tab_prix").html().replace(",", ".");
                            var qte = $(this).find("td#tab_qte").html();
                            var qteajust = $(this).find("td#tab_qteajust").html();
                            var prixajust = $(this).find("td#tab_prajust").html().replace(",", ".");
                            var ref = $(this).find("td#tab_ref").html();
                            var valide = $(this).find("input#valide").val();
                            if(qteajust=="") qteajust = 0;
                            if(prixajust=="") prixajust = 0;
                            if(qteajust=="" && qte!=0 && prixajust!=0) qteajust = qte;
                            if(prixajust=="" && prix!=0) prixajust = prix;
                            if(qteajust!=0 & valide==1){
                                valideEntreeLigneInventaire(ente,date,depot,prixajust,qteajust,ref);
                            }
                        }
                    });
                }
            });
        }
    }
    
    
    function valideEntreeLigneInventaire(entete,date,depot,prix,qte,reference){
        $.ajax({
            url: "traitement/SaisieInventaire.php?acte=inventaireLigneEntree&entete="+entete+"&date="+date+"&depot="+depot+"&quantite="+qte+"&prix="+prix+"&designation="+reference,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                
            }
        });
    }
    
    function valideInventaire21(date,depot){
        if(valideinventaire==1){
            $.ajax({
               url: "traitement/SaisieInventaire.php?acte=inventaireEntree21&date="+date+"&depot="+depot,
               method: 'GET',
               dataType: 'json',
                success: function(data) {
                    var ente21 = data.entete;
                    $("table.table > tbody > tr").each(function() {
                        if($(this).find("td#tab_ref").html()!=null){
                            var prix = $(this).find("td#tab_prix").html().replace(",", ".");
                            var qte = $(this).find("td#tab_qte").html();
    //                        var qteajust = $(this).find("td#tab_qteajust").html();
    //                        var prixajust = $(this).find("td#tab_prajust").html();
                            var ref = $(this).find("td#tab_ref").html();
                            var valide = $(this).find("input#valide").val();
                            if(qte!=0 && valide==1){
                                if(prix=="") prix = 0;
                                if(qte=="") qte = 0;
    //                            if(qteajust=="") qteajust = 0;
    //                            if(prixajust=="") prixajust = 0;
                                valideLigneInventaire21(ente21,date,depot,prix,qte,ref);
                            }
                        }
                    });
                }
            });
        }
    }
    
    
    function valideLigneInventaire21(entete,date,depot,prix,qte,reference){
        $.ajax({
            url: "traitement/SaisieInventaire.php?acte=inventaireLigneEntree21&entete="+entete+"&date="+date+"&depot="+depot+"&quantite="+qte+"&prix="+prix+"&designation="+reference,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
            }
        });
    }
    
    $("#valide").click(function (){
        var date = $.datepicker.formatDate('yy-mm-dd', new Date());
        var depot = $("#depot").val();
        valideInventaire21(date,depot);
        valideEntreeInventaire(date,depot);
        $("#valide").prop('disabled', true);
        $("#qte_ajustee").prop('disabled', true);
        $("#pr_ajuste").prop('disabled', true);
        $(".comboreference").prop('disabled', true);
        window.setTimeout(function(){alert("La saisie a bien été prise en compte !"); window.location.replace("indexMVC.php?module=1&action=1"); },5000);
    });

});