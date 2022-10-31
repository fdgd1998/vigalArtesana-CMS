function enableChangePasswdBtn() {
    if (passValid) $("#change-password").removeAttr("disabled");
    else $("#change-password").attr("disabled", true);
}
$("#pass1, #pass2").on("keyup", function() {
    if ($("#pass1").val() != $("#pass2").val()) {
        $("#pass-feedback").html("Las contraseñas no coinciden.");
        $("#pass1").addClass("is-invalid");
        $("#pass2").addClass("is-invalid");
        $("#pass1").removeClass("is-valid");
        $("#pass2").removeClass("is-valid");
        passValid = false;
    } else {
        $("#pass1").addClass("is-valid");
        $("#pass2").addClass("is-valid");
        $("#pass1").removeClass("is-invalid");
        $("#pass2").removeClass("is-invalid");
        if (passwordComplexity($("#pass1").val()) && passwordComplexity($("#pass2").val())) {
            $("#pass1").addClass("is-valid");
            $("#pass2").addClass("is-valid");
            $("#pass1").removeClass("is-invalid");
            $("#pass2").removeClass("is-invalid");
            $("#pass-feedback").html("");
            passValid = true;
        } else  {
            $("#pass1").addClass("is-invalid");
            $("#pass2").addClass("is-invalid");
            $("#pass1").removeClass("is-valid");
            $("#pass2").removeClass("is-valid");
            passValid = false;
            $("#pass-feedback").html("La contraseña no cumple los requisitos de complejidad.");
        }
    }
    enableChangePasswdBtn();
})