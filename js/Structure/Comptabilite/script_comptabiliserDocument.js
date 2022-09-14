jQuery(function($){

    function $_GET(param) {
        var vars = {};
        window.location.href.replace(location.hash, '').replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function (m, key, value) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );

        if (param) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }

    function autocompleteDoPiece(comptabiliser,typeDocument) {
        $("#DO_Piece").autocomplete({
            source: "indexServeur.php?page=getDocumentByDoPieceType&TypeDocument=" + typeDocument + "&Comptabiliser=" + comptabiliser,
            autoFocus: true,
            select: function (event, ui) {
                event.preventDefault();
                $("#DO_Piece").val(ui.item.DO_Piece)
                $("#CT_Num").val(ui.item.value)
            },
            focus: function (event, ui) {
            }
        })
    }
    autocompleteDoPiece( $("#Comptabiliser").val(),$("#TypeDocument").val())

    $("#Comptabiliser").change(function(){
        autocompleteDoPiece( $("#Comptabiliser").val(),$("#TypeDocument").val())
    })

    $("#TypeDocument").change(function(){
        autocompleteDoPiece( $("#Comptabiliser").val(),$("#TypeDocument").val())
    })
});