jQuery(function($){
    $("#txtConfirmPassword").keyup(function() {
        var password = $("#txtNewPassword").val();
        $("#divCheckPasswordMatch").html(password == $(this).val()
            ? "Les mots de passe correspondent."
            : "Les mots de passe ne correspondent pas !"
        );
    });
});