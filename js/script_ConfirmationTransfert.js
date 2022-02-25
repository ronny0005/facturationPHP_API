jQuery(function($){

    let prot_no = $("#PROT_No").val()
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

    $('#checkAll').click(function () {
        $('input:checkbox').prop('checked', this.checked);
    });

    $.fn.select2.defaults.set( "theme", "bootstrap" );
    $.fn.select2.defaults.set( "maximumSelectionSize", "6" );

    $("#DO_Piece").select2().on("select2:select", function (e) {
        $.ajax({
            url: "traitement/Facturation.php?acte=initLigneconfirmation_document",
            method: 'GET',
            dataType: 'html',
            data: "cbMarq=" + $("#DO_Piece").val(),
            async: false,
            success: function (data) {
                $("#ligne").html(data);
            },
            error: function (resultat, statut, erreur) {
                error = 1;
            }
        })
    });

    $("input[id^='qte']").each(function(){
        $(this).inputmask({   'alias': 'decimal',
            'groupSeparator': ' ',
            'autoGroup': true,
            'digits': 2,
            rightAlign: true,
            'digitsOptional': false,
            'placeholder': '',
            allowPlus: true,
            allowMinus: false
        })
    })


    $("input[id^='item']").each(function() {
        $(this).click(function(){
            if(!$(this).is(':checked'))
                $('#checkAll').prop('checked',false)
        })
    })

    $("#valider").click(function(){
        var error = 0;
        var check = 0;
        $("input[id^='item']").each(function() {
            if($(this).is(':checked')) {
                check=1;
                qte = $(this).parent().parent().find("#qte").val()
                cbMarq = $(this).parent().parent().find("#cbMarq").html()
                $.ajax({
                    url: "traitement/Facturation.php?acte=confirmation_document",
                    method: 'GET',
                    dataType: 'html',
                    data: "cbMarq=" + cbMarq + "&qte=" + qte+"&PROT_No="+prot_no,
                    async: false,
                    success: function (data) {
                        if (data != "")
                            error = 1;
                    },
                    error: function (resultat, statut, erreur) {
                        error = 1;
                    }
                })
            }
        })
        if(error==0 && check==1) {
            alert("l'opération s'est bien déroulé")
            $("#entete").submit();
        }
    })
});
