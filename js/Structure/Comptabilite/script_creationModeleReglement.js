jQuery(function($){

        var protect=0;
        var type =0;
        var exist = false;
        var mr_no=0;
        
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
    
    $('#Ajouter').click(function(){
        Ajouter();
    });
        
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DEPOT;
                    if(protect==1){
                        $('#intitule').prop('disabled', true);
                        $('#adresse').prop('disabled', true);
                        $('#complement').prop('disabled', true);
                        $('#cp').prop('disabled', true);
                        $('#region').prop('disabled', true);
                        $('#pays').prop('disabled', true);
                        $('#responsable').prop('disabled', true);
                        $('#cat_compta').prop('disabled', true);
                        $('#code_depot').prop('disabled', true);
                        $('#tel').prop('disabled', true);
                    }
                });
            }
        });
    }
    protection();  

    function Ajouter(){
        if($_GET("MR_No")==null){
            var num ='';
            $.ajax({
                url: 'traitement/Structure/Comptabilite/ModeleReglement.php?acte=ajout',
                method: 'GET',
                dataType: 'json',
                data : $("#formModeleReglement").serialize(),
                async : false,
                success: function(data) {
                    mr_no=data.MR_No;
                    $("tr[id^='emodeler']").each(function() {
                        $.ajax({
                            url: 'traitement/Structure/Comptabilite/ModeleReglement.php?acte=ajout&MR_No='+mr_no+'&Detail=1',
                            method: 'GET',
                            dataType: 'json',
                            data : 'ER_VRepart='+$(this).find("#tabER_TRepart").html()+'&ER_NbJour='+$(this).find("#tabER_NbJour").html()+'&ER_Condition='+$(this).find("#idtabER_Condition").val()+'&ER_JourTb01='+$(this).find("#tabER_JourTb01").html()+'&N_Reglement='+$(this).find("#idtabR_Intitule").val()+'&MR_Intitule='+$("#MR_Intitule").val()+'&cbMarq='+$(this).find("#cbMarq").val(),
                            async : false,
                            success: function(data) {
                                window.location.replace("indexMVC.php?module=9&action=11&acte=ajoutOK&MR_No="+data.MR_No);
                            }
                        });
                    });
                } 
            }); 
        }else {
            var num ='';
            var mr_no=$_GET("MR_No");
            $.ajax({
                url: 'traitement/Structure/Comptabilite/ModeleReglement.php?acte=modif&MR_No='+mr_no,
                method: 'GET',
                dataType: 'json',
                data : $("#formModeleReglement").serialize(),
                async : false,
                success: function(data) {
                    $("tr[id^='emodeler']").each(function() {
                        $.ajax({
                            url: 'traitement/Structure/Comptabilite/ModeleReglement.php?acte=modif&MR_No='+mr_no+'&Detail=1',
                            method: 'GET',
                            dataType: 'json',
                            data : 'ER_VRepart='+$(this).find("#tabER_TRepart").html()+'&ER_NbJour='+$(this).find("#tabER_NbJour").html()+'&ER_Condition='+$(this).find("#idtabER_Condition").html()+'&ER_JourTb01='+$(this).find("#tabER_JourTb01").html()+'&N_Reglement='+($(this).find("#idtabR_Intitule").html()).substr(0,2)+'&MR_Intitule='+$("#MR_Intitule").val()+'&cbMarq='+$(this).find("#cbMarq").val(),
                            async : false,
                            success: function(data) {
                                window.location.replace("indexMVC.php?module=9&action=11&acte=modifOK&MR_No="+data.MR_No);
                            }
                        });
                    });
                } 
            });
        }
    }
    
    function valideLigne(emodeler){
        emodeler.find("#tabER_TRepart").html($("#ER_VRepart").val());
        emodeler.find("#tabER_NbJour").html($("#ER_NbJour").val());
        emodeler.find("#idtabER_Condition").val($("#ER_Condition").val());
        emodeler.find("#valER_Condition").html($("#ER_Condition option:selected").text());
        emodeler.find("#tabER_JourTb01").html($("#ER_JourTb01").val());
        emodeler.find("#idtabR_Intitule").html($("#N_Reglement").val());
        emodeler.find("#valR_Intitule").html($("#N_Reglement option:selected").text());
        
        $("#ER_VRepart").val("");
        $("#ER_NbJour").val("");
        $("#ER_Condition").val(0);
        $("#ER_JourTb01").val("");
        $("#N_Reglement").val("01");
        $("#ER_VRepart").unbind();
        $("#ER_NbJour").unbind();
        $("#ER_JourTb01").unbind();
        setDblClick();
        setKey();
        
    }
    
    function ajoutLigne(){
        var val=true;
        
        $("#table").find("tr[id='emodeler']").each(function(){
            if(($("#ER_VRepart").val()==0 || $("#ER_VRepart").val()=="") && $(this).find("td[id='tabER_TRepart']").html()=="Equilibre")
               val=false;
        });
        if(val){
            $("#table > tbody:last").append("<tr id='emodeler'>"+
            "<td id='tabER_TRepart'>"+$("#ER_VRepart").val()+"</td>"+
            "<td id='tabER_NbJour'>"+$("#ER_NbJour").val()+"</td>"+
            "<td id='tabER_Condition'>"+
                "<span id='valER_Condition'>"+$("#ER_Condition option:selected").text()+"</span>"+
                "<span style='width:0px;visibility:hidden' id='idtabER_Condition'>"+$("#ER_Condition").val()+"</span>"+
                "<input style='width:0px;visibility:hidden' id='cbMarq' value='0'/>"+
            "</td>"+
            "<td id='tabER_JourTb01'>"+$("#ER_JourTb01").val()+"</td>"+
            "<td id='tabR_Intitule'><span id='valR_Intitule'>"+$("#N_Reglement option:selected").text()+"</span><span style='width:0px;visibility:hidden' id='idtabR_Intitule'>"+$("#N_Reglement").val()+"<span/></td>"+
            "<td id='modif'><i class='fa fa-pencil fa-fw'></i></td><td id='suppr'><i class='fa fa-trash-o'></i></td>"+
            "</tr>").on ('click','#modif',function(){
                //$(this).unbind();
                var emodeler = $(this).parent();
                $("#ER_VRepart").val(emodeler.find("#tabER_TRepart").html());
                $("#ER_NbJour").val(emodeler.find("#tabER_NbJour").html());
                $("#ER_Condition").val(emodeler.find("#idtabER_Condition").html());
                $("#ER_JourTb01").val(emodeler.find("#tabER_JourTb01").html());
                var valeur = '0'+(emodeler.find("#idtabR_Intitule").html()).substr(0,2);
                $("#N_Reglement").val(valeur.substr(valeur.length-2));
                $("#ER_VRepart").unbind();
                $("#ER_NbJour").unbind();
                $("#ER_JourTb01").unbind();
                $("#ER_VRepart").keydown(function (event) {
                   if(event.keyCode == 13){
                    valideLigne(emodeler);
                   } 
                });
                $("#ER_NbJour").keydown(function (event) {
                   if(event.keyCode == 13){
                    valideLigne(emodeler);
                   } 
                });
                $("#ER_JourTb01").keydown(function (event) {
                   if(event.keyCode == 13){
                    valideLigne(emodeler);
                   } 
                });
            }).on ('click','#suppr',function(){
                $(this).unbind();
                var emodeler = $(this).parent();
                emodeler.remove();
            });
            $("#ER_VRepart").val("");
            $("#ER_NbJour").val("");
            $("#ER_Condition").val(0);
            $("#ER_JourTb01").val("");
            $("#N_Reglement").val("01");

            $("#ER_VRepart").unbind();
            $("#ER_NbJour").unbind();
            $("#ER_JourTb01").unbind();
            setKey();
        } else alert("L'équilibre ne peut être saisie plus d'une fois !");
    }
    
    function setKey(){
        $("#ER_VRepart").keydown(function (event) {
            if(event.keyCode == 13)
               ajoutLigne();
        });

        $("#ER_NbJour").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });

        $("#ER_JourTb01").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
    }   
    
    setKey();

    function setDblClick (){
        $("td[id^='modif']").click(function() {
            var emodeler = $(this).parent();
            $("#ER_VRepart").val(emodeler.find("#tabER_TRepart").html());
            $("#ER_NbJour").val(emodeler.find("#tabER_NbJour").html());
            $("#ER_Condition").val(emodeler.find("#idtabER_Condition").html());
            $("#ER_JourTb01").val(emodeler.find("#tabER_JourTb01").html());
            var valeur = '0'+emodeler.find("#idtabR_Intitule").html();
            $("#N_Reglement").val(valeur.substr(valeur.length-2));
            $("#ER_VRepart").unbind();
            $("#ER_NbJour").unbind();
            $("#ER_JourTb01").unbind();
            $("#ER_VRepart").keydown(function (event) {
               if(event.keyCode == 13){
                valideLigne(emodeler);
               } 
            });
            $("#ER_NbJour").keydown(function (event) {
               if(event.keyCode == 13){
                valideLigne(emodeler);
               } 
            });
            $("#ER_JourTb01").keydown(function (event) {
               if(event.keyCode == 13){
                valideLigne(emodeler);
               } 
            });
        });
        
        $("td[id^='suppr']").click(function() {
            var emodeler = $(this).parent();
            emodeler.remove();
        });
    }
    setDblClick();
    bloqueForm();
});