
var passValid = false;
var userValid = false;
var emailValid = false;

function enableCreateUserBtn() {
    if (passValid && userValid && emailValid) $("#create-user").removeAttr("disabled");
    else $("#create-user").attr("disabled", true);
}

$("#create-user").on("click", function() {
    var formdata = new FormData();
    formdata.append("username", $.trim($("#username").val()));
    formdata.append("role", $.trim($("#role option:selected").val()));
    formdata.append("email", $.trim($("#email").val()));
    formdata.append("pass", $("#password").val());

    $.ajax({
        url: location.origin+'/dashboard/admin/users/create_user.php', // this is the target
        type: 'post', // method
        dataType: 'text',
        cache: false,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        data: formdata, // pass the input value to server
        success: function(response) { // if the http response code is 200
            alert(response);
            window.location = location.origin+"/dashboard/?page=manage-users";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });
})

$('#username').on('keyup', function(e) {
    if ($.trim($('#username').val()) != "") {
        // perform an ajax call
        $.ajax({
            url: location.origin + '/dashboard/admin/users/check_username.php', // this is the target
            method: 'post', // method
            data: {username: $.trim($('#username').val())}, // pass the input value to server
            success: function(r) { // if the http response code is 200
                $('#username').addClass('is-valid');
                $('#username').removeClass('is-invalid');
                userValid = true;
            },
            error: function(r) { // if the http response code is other than 200
                $("#username-feedback").html('El usuario ya existe.');
                $('#username').addClass('is-invalid');
                $('#username').removeClass('is-valid');
                userValid = false;
            }
        });
    } else {
        $("#username-feedback").html('El campo no puede estar vacío.');
        $('#username').addClass('is-invalid');
        $('#username').removeClass('is-valid');
        userValid = false;
    }
    enableCreateUserBtn();
});

$('#email').on('keyup', function(e) {
    if ($.trim($('#email').val()) != "") {
        if (emailFormatValid($.trim($(this).val()))) {
            // perform an ajax call
            $.ajax({
                url: location.origin + '/dashboard/admin/users/check_email.php', // this is the target
                method: 'post', // method
                data: {email: $.trim($("#email").val())}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $("#email").addClass('is-valid');
                    $("#email").removeClass('is-invalid');
                    emailValid = true;
                },
                error: function(r) { // if the http response code is other than 200
                    $("#email-feedback").html('El email ya está registrado.');
                    $("#email").addClass('is-invalid');
                    $("#email").removeClass('is-valid');
                    emailValid = false;
                }
            });
        } else {
            $("#email-feedback").html('El email no es válido.');
            $("#email").addClass('is-invalid');
            $("#email").removeClass('is-valid');
            emailValid = false;
        }
        
    } else {
        console.log("campo vacio");
        $("#email-feedback").html('El campo no puede estar vacío.');
        $("#email").addClass('is-invalid');
        $("#email").removeClass('is-valid');
        emailValid = false;
    }
    enableCreateUserBtn();
});

$("#cancel-create-user").on("click", function() {
    window.location = location.origin + "/dashboard?page=manage-users";
})

$("#generate").on("click", function(){
    var pass = generatePass();
    while (!passwordComplexity(pass)) {
        pass = generatePass();
    }
    $("#password").val(pass);
    passValid = true;
    enableCreateUserBtn()
});