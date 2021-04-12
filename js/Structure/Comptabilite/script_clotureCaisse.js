jQuery(function($){
    $("#dateCloture").datepicker({
        dateFormat: "ddmmy", altFormat: "ddmmy",
        autoclose: true
    });
    $("#dateCloture").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());

    var dateObj=new Date();
    var time  = ("0"+dateObj.getHours()).substr(-2)+":"+("0"+dateObj.getMinutes()).substr(-2)+":"+("0"+dateObj.getSeconds()).substr(-2);

    $("#heureCloture").val(time);

});