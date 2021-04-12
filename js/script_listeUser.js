jQuery(function($){

    $("#table").DataTable(
        {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
            ,"initComplete": function(settings, json) {
                $("#table_wrapper").addClass("row").addClass("p-3")
                $("#table_filter").find(":input").addClass("form-control");
                $("#table_length").find(":input").addClass("form-control");
                $("#searchBar").append($("#table_filter"))
                $("#numberRow").append($("#table_length"))
            }

        }
    );

$("table.table > tbody > tr").on('dblclick', function() {
    iduser = $(this).find(".data-id").val();
    document.location.href = "indexMVC.php?module=8&action=4&id="+iduser;
}); 
   
});

