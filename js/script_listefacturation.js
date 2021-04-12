jQuery(function($){      
    var protect = 0;
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DOCUMENT_VENTE;
                    if(protect==1){
                        $("#nouveau").prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection();
    
    $('#table').dynatable({
        features: {
            perPageSelect: false
        },
        inputs: {
            queryEvent: 'keyup'
        }
    });

    function referencement(){
        $("table.table > tbody > tr").on('dblclick', function() {
            var entete = $(this).find("td").html();
            $(this).find('td').each (function() {
                if($(this).html()=="Comptant")
                    document.location.href = "indexMVC.php?module=2&action=3&entete="+entete+"&visu=1&type=Vente";
                if($(this).html()=="Crédit")
                    document.location.href = "indexMVC.php?module=2&action=3&entete="+entete+"&modif=1&type=Vente";
                // do your cool stuff
            });
        });
    }
    
    referencement();
    $("#nouveau").on('click', function() {
        document.location.href = "indexMVC.php?module=2&action=3&depot="+$("#depot").val()+"&type=Vente";
    }); 
    
    $(".dynatable-page-link").on('click', function(){
        referencement();
    });
    
    $("#dynatable-query-search-table").keyup(function(e){
        referencement(); 
    });
    
    alert($("#post").val());
    if($("#post").val()==0) {
        $("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
        $("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    }
});