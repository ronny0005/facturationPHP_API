jQuery(function($){  

    var protect=0;
    var modification = 0;

    $("#hniv0").keyup(function (e){
        if(e.keyCode == 13){
            valide0();
        }
        if(e.keyCode == 27 && modification==1){
            echap0();
        }
    });
    
    $("#hniv1").keyup(function (e){
        if(e.keyCode == 13){
            valide1();
        }
        if(e.keyCode == 27 && modification==1){
            echap1();
        }
    });

    $("#hniv2").keyup(function (e){
        if(e.keyCode == 13){
            valide2();
        }
        if(e.keyCode == 27 && modification==1){
            echap2();
        }
    });

    $("#hniv3").keyup(function (e){
        if(e.keyCode == 13){
            valide3();
        }
        if(e.keyCode == 27 && modification==1){
            echap3();
        }
    });


    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_FAMILLE;
                    if(protect==1){
                        $('#hniv0').prop('disabled', true);
                        $('#hniv1').prop('disabled', true);
                        $('#hniv2').prop('disabled', true);
                        $('#hniv3').prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection(); 
    
    $('#selecthniv0 option').click(function() {
        listeCatalogue($("#selecthniv0 option:selected").val());
    });
    
    $('#selecthniv1 option').click(function() {
        listeCatalogue($("#selecthniv1 option:selected").val());
    });
    
    $('#selecthniv2 option').click(function() {
        listeCatalogue($("#selecthniv2 option:selected").val());
    });
    
    $('#selecthniv0').keyup(function(e) {
        if(protect!=1){
            if(e.keyCode == 46) suppr_catalogue($("#selecthniv0 option:selected").val());
        }
    });
    
    $('#selecthniv1').keyup(function(e) {
        if(protect!=1){
            if(e.keyCode == 46) suppr_catalogue($("#selecthniv1 option:selected").val());
        }
    });
    
    $('#selecthniv2').keyup(function(e) {
        if(protect!=1){
            if(e.keyCode == 46) suppr_catalogue($("#selecthniv2 option:selected").val());
        }
    });
    
    $('#selecthniv3').keyup(function(e) {
        if(protect!=1){
            if(e.keyCode == 46) suppr_catalogue($("#selecthniv3 option:selected").val());
        }
    });
    
    function valide0(){
        if(modification==0){
            if($("#hniv0").val()!=""){
                $.ajax({
                    url: "traitement/GestionCatalogue.php?acte=nouveau_hniv0&hniv="+$("#hniv0").val()+"&noparent=0&niv=0",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        window.location.replace("indexMVC.php?module=3&action=5"); 
                    }
                });
            }
        }else {
            modif_catalogue($("#valhniv0").val(),$("#hniv0").val());
        }
    }
    
    function valide1(){
        if(modification==0){
            if($("#hniv1").val()!=""){
                $.ajax({
                    url: "traitement/GestionCatalogue.php?acte=nouveau_hniv0&hniv="+$("#hniv1").val()+"&noparent="+$("#selecthniv0 option:selected").val()+"&niv=1",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        window.location.replace("indexMVC.php?module=3&action=5"); 
                    }
                });
            }
        }else {
            modif_catalogue($("#valhniv1").val(),$("#hniv1").val());
        }
    }
    
    
    function valide2(){
        if(modification==0){
            if($("#hniv2").val()!=""){
                $.ajax({
                    url: "traitement/GestionCatalogue.php?acte=nouveau_hniv0&hniv="+$("#hniv2").val()+"&noparent="+$("#selecthniv1 option:selected").val()+"&niv=2",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        window.location.replace("indexMVC.php?module=3&action=5"); 
                    }
                });
            }
        }else {
            modif_catalogue($("#valhniv2").val(),$("#hniv2").val());
        }
    }
    
    
    function valide3(){
        if(modification==0){
            if($("#hniv3").val()!=""){
                $.ajax({
                    url: "traitement/GestionCatalogue.php?acte=nouveau_hniv0&hniv="+$("#hniv3").val()+"&noparent="+$("#selecthniv2 option:selected").val()+"&niv=3",
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        window.location.replace("indexMVC.php?module=3&action=5"); 
                    }
                });
            }
        }else {
            modif_catalogue($("#valhniv3").val(),$("#hniv3").val());
        }
    }
    
    function echap0(){
        $('#selecthniv0').prop('disabled', false);
        $('#hniv1').prop('disabled', false);
        modification=0;
        $('#hniv0').val("");
    }
    
    function echap1(){
        $('#selecthniv1').prop('disabled', false);
        $('#selecthniv0').prop('disabled', false);
        $('#hniv1').prop('disabled', false);
        $('#hniv0').prop('disabled', false);
        modification=0;
        $('#hniv1').val("");
    }
    
    function echap2(){
        $('#selecthniv2').prop('disabled', false);
        $('#selecthniv1').prop('disabled', false);
        $('#selecthniv0').prop('disabled', false);
        $('#hniv2').prop('disabled', false);
        $('#hniv1').prop('disabled', false);
        $('#hniv0').prop('disabled', false);
        modification=0;
        $('#hniv2').val("");
    }
    
    
    function echap3(){
        $('#selecthniv3').prop('disabled', false);
        $('#selecthniv2').prop('disabled', false);
        $('#selecthniv1').prop('disabled', false);
        $('#selecthniv0').prop('disabled', false);
        $('#hniv3').prop('disabled', false);
        $('#hniv2').prop('disabled', false);
        $('#hniv1').prop('disabled', false);
        $('#hniv0').prop('disabled', false);
        modification=0;
        $('#hniv3').val("");
    }
    
    function modif_select1(){
        if(protect!=1){
            $('#selecthniv1 option').dblclick(function() {
                $('#hniv1').val($("#selecthniv1 option:selected").html());
                $('#valhniv1').val($("#selecthniv1 option:selected").val());
                $('#selecthniv2').prop('disabled', true);
                $('#selecthniv1').prop('disabled', true); 
                $('#selecthniv0').prop('disabled', true); 
                $('#hniv2').prop('disabled', true);  
                $('#hniv0').prop('disabled', true);  
                modification=1;
            });
        }
    }
    
    function modif_select2(){
        
        if(protect!=1){
            $('#selecthniv2 option').dblclick(function() {
                $('#hniv2').val($("#selecthniv2 option:selected").html());
                $('#valhniv2').val($("#selecthniv2 option:selected").val());
                $('#selecthniv2').prop('disabled', true); 
                $('#selecthniv1').prop('disabled', true); 
                $('#selecthniv0').prop('disabled', true); 
                $('#hniv1').prop('disabled', true);  
                $('#hniv0').prop('disabled', true);  
                modification=1;
            });
        }
    }
    
    
    function modif_select3(){
        
        if(protect!=1){
            $('#selecthniv3 option').dblclick(function() {
                $('#hniv3').val($("#selecthniv3 option:selected").html());
                $('#valhniv3').val($("#selecthniv3 option:selected").val());
                $('#selecthniv3').prop('disabled', true); 
                $('#selecthniv2').prop('disabled', true); 
                $('#selecthniv1').prop('disabled', true); 
                $('#selecthniv0').prop('disabled', true); 
                $('#hniv2').prop('disabled', true);  
                $('#hniv1').prop('disabled', true);  
                $('#hniv0').prop('disabled', true);  
                modification=1;
            });
        }
    }
    
    function modif_select0(){
        if(protect!=1){
            $('#selecthniv0 option').dblclick(function() {
            $('#hniv0').val($("#selecthniv0 option:selected").html());
            $('#valhniv0').val($("#selecthniv0 option:selected").val());
            $('#selecthniv1').prop('disabled', true); 
            $('#selecthniv0').prop('disabled', true); 
            $('#hniv1').prop('disabled', true);  
            modification=1;
        });
        }
    }
    
    modif_select0();
    modif_select1();
    modif_select2();
    modif_select3();
    
    function listeCatalogue(val){
        $('#selecthniv1').html("");
        $.ajax({
            url: "traitement/GestionCatalogue.php?acte=listeCatalogue&niv=1&no="+val,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    $('#selecthniv1').append('<option value="'+this.CL_No+'" selected="selected">'+this.CL_Intitule+'</option>');
                    modif_select1();
                });
                $('#selecthniv1').unbind('click');
                $('#selecthniv1').click(function(){
                    listeCatalogue2($("#selecthniv1 option:selected").val());  
                }) ;
                if(modification==0){
                    if(protect!=1){
                        $('#selecthniv1').prop('disabled', false);
                        $('#selecthniv2').prop('disabled', true);
                        $('#selecthniv3').prop('disabled', true);
                        $('#selecthniv2').html("");
                        $('#hniv1').prop('disabled', false);
                        $('#hniv2').prop('disabled', true);
                        $('#hniv3').prop('disabled', true);
                    }
                }
            }    
        });
    }
    
    
    function listeCatalogue2(val){
        $('#selecthniv2').html("");
        $.ajax({
            url: "traitement/GestionCatalogue.php?acte=listeCatalogue&niv=2&no="+val,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    $('#selecthniv2').append('<option value="'+this.CL_No+'" selected="selected">'+this.CL_Intitule+'</option>');
                    modif_select2();
                });
                
                $('#selecthniv2').unbind('click');
                $('#selecthniv2').click(function(){
                    listeCatalogue3($("#selecthniv2 option:selected").val());  
                }) ;
                if(modification==0){
                    if(protect!=1){
                        $('#selecthniv2').prop('disabled', false);
                        $('#selecthniv3').prop('disabled', true);
                        $('#hniv2').prop('disabled', false);
                        $('#hniv3').prop('disabled', true);
                        
                    }
                }
            }    
        });
    }
    
    
    function listeCatalogue3(val){
        $('#selecthniv3').html("");
        $.ajax({
            url: "traitement/GestionCatalogue.php?acte=listeCatalogue&niv=3&no="+val,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    $('#selecthniv3').append('<option value="'+this.CL_No+'" selected="selected">'+this.CL_Intitule+'</option>');
                    modif_select3();
                });
                if(modification==0){
                    if(protect!=1){
                        $('#selecthniv3').prop('disabled', false);
                        $('#hniv3').prop('disabled', false);
                    }
                }
            }    
        });
    }
    
    function modif_catalogue(no,intitule){
        $.ajax({
            url: "traitement/GestionCatalogue.php?acte=modifCatalogue&no="+no+"&intitule="+intitule,
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                window.location.replace("indexMVC.php?module=3&action=5"); 
            }    
        });
    }
    
    function suppr_catalogue(cl_no){
        $.ajax({
            url: "traitement/GestionCatalogue.php?acte=suppr_catalogue&cl_no="+cl_no,
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                if(data.length==0){window.location.replace("indexMVC.php?module=3&action=5"); 
                }else alert ("Ce catalogue est rataché à une famille");
            }
        });
    }
    
});