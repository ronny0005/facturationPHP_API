jQuery(function($){  

    if($("#acte").val()=="ajoutOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>L\'article '+$("#arRef").val()+' a bien été enregistré !</div>');
    }

    if($("#acte").val()=="modifOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>L\'article '+$("#arRef").val()+' a bien été modifié !</div>');
    }

    if($("#acte").val()=="supprOK"){
            $("#add_err").css('display', 'inline', 'important');
            $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>L\'article  '+$("#arRef").val()+' a bien été supprimé !</div>');
    }

    if($("#acte").val()=="supprKO"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La suppression de l\'article '+$("#arRef").val()+' a échoué !</div>');
    }

    $("#sommeil").change(function(){
        $("#formParam").submit()
    });

    $("#stockFlag").change(function(){
        $("#formParam").submit()
    });

    $("#prixFlag").change(function(){
        $("#formParam").submit()
    });

$('#table').dynatable({
    inputs: {
    queryEvent: 'keyup'
    }
});

function referencement(){
    $("table.table > tbody > tr").on('click', function() {
        document.location.href = "indexMVC.php?module=&action=1&AR_Ref="+$(this).find("td a").html();
    }); 
}

$("#dynatable-query-search-table").keyup(function(e){
    referencement(); 
});

referencement();


var protect = 0;
var sommeil = -1;
var prixFlag = -1;
var stockFlag = -1;
    sommeil = $("#sommeil").val();
    prixFlag = $("#prixFlag").val();
    stockFlag = $("#stockFlag").val();
    var info = [
        {   "data": "AR_Ref",
            "render": function(data, type, row, meta) {
                if (type === 'display') {
                    console.log(row)
                    data = '<a href="ficheArticle-' + row.cbMarq + '">' + data + '</a>';
                }
                return data;
            }
        },
        {"data": "AR_Design"},
        {"data": "FA_CodeFamille"},
        {"data": "AS_QteSto",
            "render": function(data, type, row, meta) {
                if (type === 'display') {
//                    data = Math.round(data, 2);
                }
                data= parseFloat(data).toLocaleString();
                return data;
            }}
    ];

    if($("#flagPxAchat").val()==0)
        info.push({"data": "AR_PrixAch",
            "render": function(data, type, row, meta) {
                if (type === 'display') {
                }
                data= parseFloat(data).toLocaleString();
                return "<span style='float:right'>"+data+"</span>";
            }});

    if($("#flagInfoLibreArticle").val()!=2) {
        info.push({
            "data": "AR_PrixVen",
            "render": function (data, type, row, meta) {
                if (type === 'display') {
//                    data = Math.round(data,2);
                }
                data = parseFloat(data).toLocaleString();
                return "<span style='float:right'>"+data+"</span>";
            }
        });
    }

    if($("#flagPxRevient").val()!=2)
        info.push(         {"data": "AS_MontSto",
        "render": function(data, type, row, meta) {
            if (type === 'display') {
//                    data = Math.round(data, 2);
            }
            data= parseFloat(data).toLocaleString();
            return "<span style='float:right'>"+data+"</span>";
        }});

    var suppr = {"data" : "AR_Ref","render": function(data, type, row, meta) {
            if (type === 'display') {
                data = "<a href='Traitement\\Creation.php?acte=suppr_article&AR_Ref="+data+"' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer " + data+" ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a>";
            }//
            return data;
        }
    }

    if($("#supprProtected").val()==1)
        info.push(suppr);

    if($("#flagCreateur").val()==1) {
        info.push({
            "data": "PROT_User",
            "render": function (data, type, row, meta) {
                if (data == null) return "";
                else
                    return data;
            }
        });
    }

    $("#imprimer").click(function(){
        window.open('./export/exportCSV.php?&AR_Sommeil='+sommeil+"&prixFlag="+prixFlag+"&stockFlag="+stockFlag, "Fiche Article", "height=100,width=100");
    });

    $('#users').DataTable({
        "columns": info,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: 'traitement/Creation.php?acte=listeArticle&PROT_No='+$("#PROT_No").val()+'&AR_Sommeil='+sommeil+'&flagPxAchat='+$("#flagPxAchat").val()+'&flagPxRevient='+$("#flagInfoLibreArticle").val()+"&prixFlag="+prixFlag+"&stockFlag="+stockFlag,
            type: 'POST'
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        },
        "initComplete": function(settings, json) {
            $("#users_filter").find(":input").addClass("form-control");
            $("#users_length").find(":input").addClass("form-control");
        }
    });

    function protection(){
    $.ajax({
       url: "indexServeur.php?page=connexionProctection",
       method: 'GET',
       dataType: 'json',
        success: function(data) {
            $(data).each(function() {
                protect=this.PROT_ARTICLE;
                if(protect==1){
                    $("#nouveau").hide();
                }
            });
        }
    });
}

protection(); 


});