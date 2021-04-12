jQuery(function($){
    $("#date").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    $("#valide").click(function(){
        if($("#CA_NoSource").val()!=$("#CA_NoDest").val()){
            $("#form").submit();
        }else{

        }
    });
});