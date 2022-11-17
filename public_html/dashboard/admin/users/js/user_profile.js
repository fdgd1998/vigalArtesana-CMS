
var passValid = false;
var currentPass = false;

function enableChangePasswdBtn() {
    if (passValid && currentPass) $("#change-password").removeAttr("disabled");
    else $("#change-password").attr("disabled", true);
}
$("#new-password-1, #new-password-2").on("keyup", function() {
    if ($("#new-password-1").val() != $("#new-password-2").val()) {
        $("#new-password-2").siblings(".invalid-feedback").html("Las contraseñas no coinciden.");
        $("#new-password-1").addClass("is-invalid");
        $("#new-password-2").addClass("is-invalid");
        $("#new-password-1").removeClass("is-valid");
        $("#new-password-2").removeClass("is-valid");
        passValid = false;
    } else {
        $("#new-password-1").addClass("is-valid");
        $("#new-password-2").addClass("is-valid");
        $("#new-password-1").removeClass("is-invalid");
        $("#new-password-2").removeClass("is-invalid");
        if (passwordComplexity($("#new-password-1").val()) && passwordComplexity($("#new-password-2").val())) {
            $("#new-password-1").addClass("is-valid");
            $("#new-password-2").addClass("is-valid");
            $("#new-password-1").removeClass("is-invalid");
            $("#new-password-2").removeClass("is-invalid");
            passValid = true;
        } else  {
            $("#new-password-1").addClass("is-invalid");
            $("#new-password-2").addClass("is-invalid");
            $("#new-password-1").removeClass("is-valid");
            $("#new-password-2").removeClass("is-valid");
            passValid = false;
            $("#new-password-2").siblings(".invalid-feedback").html("La contraseña no cumple los requisitos de complejidad.");
        }
    }
    enableChangePasswdBtn();
})

$("#current-password").on("keyup", function() {
    if ($(this).val().length > 0) {
        currentPass = true;
        $(this).addClass("is-valid");
        $(this).removeClass("is-invalid");
    } else {
        currentPass = false;
        $(this).addClass("is-invalid");
        $(this).removeClass("is-valid");
    }
    enableChangePasswdBtn();
})

$("#change-password").on("click", function() {
    var formdata = new FormData();
    formdata.append("current", $("#current-password").val());
    formdata.append("new-1", $("#new-password-1").val());
    formdata.append("new-2", $("#new-password-2").val());
    formdata.append("userid", userid);

    $.ajax({
        url: location.origin+'/dashboard/admin/users/update_user_profile_password.php', // this is the target
        type: 'post', // method
        dataType: 'text',
        cache: false,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        data: formdata, // pass the input value to server
        success: function(response) { // if the http response code is 200
            alert(response);
            window.location = location.origin+"/dashboard/?page=user-profile";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });
})