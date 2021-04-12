jQuery(function($){


    $("#table").DataTable(
        {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
            ,"initComplete": function(settings, json) {
                $("#table_wrapper").addClass("row").addClass("p-3")
                $("#table_length").addClass("col-6")
                $("#table_filter").addClass("col-6")
                $("#table_filter").find(":input").addClass("form-control");
                $("#table_length").find(":input").addClass("form-control");
            }

        }
    );


$("table.table > tbody > tr").on('dblclick', function() {
    iduser = $(this).find(".data-id").val();
    idu = $(this).find(".data2-id").val();
    idp = $(this).find(".data3-id").val();
    document.location.href = "indexMVC.php?module=8&action=3&id="+iduser+"&u="+idu+"&gu="+idp;
}); 
   
});

