jQuery(function($){  
   $('#table').dynatable();

$("table.table > tbody > tr").on('dblclick', function() {
    iduser = $(this).find(".data-id").val();
    document.location.href = "indexMVC.php?module=8&action=2&id="+iduser;
}); 
   
});

