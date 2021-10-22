var user_correct = false;
var email_correct = false;
var editing_user_id = '';
var editing_username = '';

jQuery(function($) {

    function enableEditFormBtn() {
        if ($("#change-user-email-chkbx").is(":not(:checked)") && $("#change-user-type-chkbx").is(":not(:checked)")) {
            $('#user-edit').prop("disabled", true);
        }
        if ($("#change-user-email-chkbx").is(":checked")) {
            if ($("#change-user-type-chkbx").is(":checked")) {
                if ($("#email1-input-edit").css('background-color') == 'rgb(255, 150, 150)' || $("#email1-input-edit").css('background-color') == 'rgb(255, 255, 255)') {
                    $('#user-edit').prop("disabled", true);
                } else {
                    $('#user-edit').prop("disabled", false);
                }
            } else {
                $('#user-edit').prop("disabled", true);
            }
        } else if ($("#change-user-type-chkbx").is(":checked")) {
            if ($("#change-user-email-chkbx").is(":checked")) {
                if ($("#email1-input-edit").css('background-color') == 'rgb(255, 150, 150)' || $("#email1-input-edit").css('background-color') == 'rgb(255, 255, 255)') {
                    $('#user-edit').prop("disabled", true);
                } else {
                    if ($("#change-user-email-chkbx").is(":checked")) {
                        $('#user-edit').prop("disabled", false);
                    } else {
                        $('#user-edit').prop("disabled", true);
                    }
                }
            } else {
                $('#user-edit').prop("disabled", false);
            }
        }
    }

    $('#email1-input-edit, #email2-input-edit').on('keyup', function(e) {
        // set the variables
        var email1 = $('#email1-input-edit').val();
        var email2 = $('#email2-input-edit').val();
        if (email1 == email2 && email1 != "" && email2 != "") {
            $.ajax({
                url: location.origin+'/dashboard/admin/users/check_data.php', // this is the target
                method: 'post', // method
                data: {email: email1}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $('#email1-input-edit').css('background-color', '#A7F0A9').html(r);
                    $('#email2-input-edit').css('background-color', '#A7F0A9').html(r);
                    $('#user-edit').removeAttr('disabled');
                },
                error: function(r) { // if the http response code is other than 200
                    $('#email1-input-edit').css('background-color', '#FF9696').html(r);
                    $('#email2-input-edit').css('background-color', '#FF9696').html(r);
                    $('#user-edit').attr('disabled', 'disabled');               
                }
            });
            

        } else if (email1 != email2 && email1 != "" && email1 != "") {
            $('#email1-input-edit').css('background-color', '#FF9696');
            $('#email2-input-edit').css('background-color', '#FF9696');
            $('#user-edit').attr('disabled', 'disabled');
        }
    });


    $('#user-edit').on('click', function(e) {
        var formData = new FormData();
        formData.append("user_id", editing_user_id);
        if ($("#change-user-email-chkbx").is(":checked") && $("#change-user-type-chkbx").is(":checked")) {
            formData.append("user_email", $('#email1-input-edit').val());
            formData.append("user_type", $('#account-edit option:selected').val());
        } else if ($("#change-user-email-chkbx").is(":checked") && $("#change-user-type-chkbx").is(":not(:checked)")) {
            formData.append("user_email", $('#email1-input-edit').val());
        } else if ($("#change-user-email-chkbx").is(":not(:checked)") && $("#change-user-type-chkbx").is(":checked")) {
            formData.append("user_type", $('#account-edit option:selected').val());
        }
        for(var pair of formData.entries()) {
            console.log(pair[0]+ ', '+ pair[1]); 
         }
        // perform an ajax call
        $.ajax({
            url: location.origin+'/dashboard/admin/users/edit_user.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            data: formData, // pass the input value to server
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location = location.origin+"/dashboard/?page=list-users&order=asc";
            },
            error: function(response) { // if the http response code is other than 200
                alert("Ha ocurrido un error al editar el usuario.");
            }
        });
        $('#edit-user').modal().hide();
        
    });

    $('.user-edit-form').on('click', function(e) {
        // set the variables
        editing_user_id = $(this).attr('id').substring(7);
        console.log("editing user: "+$(this).attr('id'));
        editing_username = $(this).attr('name');
        $('#staticBackdropLabel-edit').text('Editando usuario: "'+editing_username+'"');
        if (account_name != editing_username) {
            $('#select-account').empty();
            label = $('<label for="account">Tipo de cuenta: </label>');
            select = $('<select class="form-control" name="account" id="account-edit"><option value="admin">Administrador</option><option value="publisher">Publicador</option></select>');
            $('#select-account').append(label);
            $('#select-account').append(select);
        } else {
            $('#select-account').empty();
        }
        $('#edit-user').modal().show();
    });

    $(".user-delete").on('click', function(e) {
        editing_user_id = $(this).attr('id');
        editing_username = $(this).attr('name');
        $('#staticBackdropLabel-delete').text('Eliminando usuario: "'+editing_username+'"');
        $('#delete-user').modal().show();
    });

    $("#user-delete").on('click', function(e) {
        var id = $(this).attr('id');
        console.log(editing_user_id.substring(7));
        $.ajax({
            url: location.origin+'/dashboard/admin/users/delete_user.php', // this is the target
            method: 'post', // method
            data: {userid: editing_user_id.substring(7)}, // pass the input value to server
            success: function(r) { // if the http response code is 200
                // alert("El usuario se ha eliminado correctamente.");
                $('#delete-user').modal().hide();
                $('.modal-backdrop').remove();
                editing_username = '';
                editing_user_id = '';
                window.location = location.origin+"/dashboard/?page=list-users&order=asc";
            },
            error: function(r) { // if the http response code is other than 200
                alert("Ha ocurrido un error al eliminar el usuario.");
            }
        });
    });

    $('#cancel-user-edit, #close-user-edit').on('click', function(e) {
        $('#email1-input-edit').css("background-color", "#FFF");
        $('#email2-input-edit').css("background-color", "#FFF");
        $('#email1-input-edit').val("");
        $('#email2-input-edit').val("");
        $('#select-account').addClass("disabled-form");
        $('#edit-email').addClass("disabled-form");
    });

    $('.user-status-change-form').on('click', function(e) {
        // set the variables
        editing_user_id = $(this).attr('id');
        editing_username = $(this).attr('name');
        action_title = 'Habilitando';
        action_info = 'habilitar';
        if ($('#'+editing_user_id+'_account_status').text().trim() == 'Habilitada') {
            action_title = 'Desabilitando';
            action_info = 'deshabilitar';
        };
        $('#staticBackdropLabel-statuschange').text(action_title+' usuario: "'+editing_username+'"');
        $('#statuschange_modal_info_text').text('¿Estás seguro de que quieres "'+action_info+'" este usuario?');
        $('#user-status-change').modal().show();
    });

    $('.password-recover-form').on('click', function(e) {
        // set the variables
        editing_user_id = $(this).attr('id').substring(10);
        console.log(editing_user_id)
        $('#staticBackdropLabel-password').text('Restaurar contraseña para: "'+editing_username+'"');
        $('#password_recover_modal_info_text').text('¿Estás seguro de que quieres restablecer la contraseña de este usuario? Se enviará un email con instrucciones a la dirección asociada a esta cuenta.');
        $('#user-password').modal().show();
    });

    $("#submit-password-recover").on('click', function(e) {

        $.ajax({
            url: location.origin+'/scripts/send_recover_email.php', // this is the target
            method: 'post', // method
            data: {id: editing_user_id, message: "¡Hola! El administrador de ViGal Artesana te ha enviado una solicitud para restablecer tu contraseña. Para seguir usando tu cuenta, debes restablecerla haciendo clic en el siguiente enlace: "}, // pass the input value to server
            success: function(r) { // if the http response code is 200
                //alert("El estado del usuario se ha actualizado correctamente.");
                $('#user-password').modal().hide();
                $('.modal-backdrop').remove();
                console.log("user id: "+editing_user_id);
                editing_user_id = '';
                // window.location = location.origin+"/dashboard/?page=list-users&order=asc";
            },
            error: function(r) { // if the http response code is other than 200
                alert("Ha ocurrido un error al actualizar el estado del usuario.");
            }
        });        
    });

    $("#user-statuschange").on('click', function(e) {
        disable = 'YES';
        if ($('#'+editing_user_id+'_account_status').text().trim() == 'Habilitada') {
            disable = 'NO';
        };
        user_id = editing_user_id.substring(7)
        console.log("user id: "+user_id);
        console.log("account status: "+disable);
        $.ajax({
            url: location.origin+'/dashboard/admin/users/change_user_account_status.php', // this is the target
            method: 'post', // method
            data: {id: user_id, status: disable}, // pass the input value to server
            success: function(r) { // if the http response code is 200
                //alert("El estado del usuario se ha actualizado correctamente.");
                $('#userid-'+user_id+'-change-status-btn').clas
                $('#user-status-change').modal().hide();
                $('.modal-backdrop').remove();
                editing_username = '';
                editing_user_id = '';
                window.location = location.origin+"/dashboard/?page=list-users&order=asc";
            },
            error: function(r) { // if the http response code is other than 200
                alert("Ha ocurrido un error al actualizar el estado del usuario.");
            }
        });        
    });

    $('#result-order').on('change', function(e) {
        value = $(this).children("option:selected").val();
        console.log(value);
        switch(value) {
            case "asc":
                window.location = "?page=list-users&order=asc";
                break;
            case "desc":
                window.location = "?page=list-users&order=desc";
                break;
            case "enabled":
                window.location = "?page=list-users&order=enabled";
                break;
            case "disabled":
                window.location = "?page=list-users&order=disabled";
                break;
        }
    });

    $("#change-user-email-chkbx").on("change", function(e){
        if ($("#change-user-email-chkbx").is(":checked")) {
            $("#edit-email").removeClass("disabled-form");
            var email1 = $('#email1-input-edit').val();
            var email2 = $('#email2-input-edit').val();
            if (email1 == email2 && email1 != "" && email2 != "") {
                $.ajax({
                    url: location.origin+'/dashboard/admin/users/check_data.php', // this is the target
                    method: 'post', // method
                    data: {email: email1}, // pass the input value to server
                    success: function(r) { // if the http response code is 200
                        $('#email1-input-edit').css('background-color', '#A7F0A9').html(r);
                        $('#email2-input-edit').css('background-color', '#A7F0A9').html(r);
                        $('#user-edit').removeAttr('disabled');
                    },
                    error: function(r) { // if the http response code is other than 200
                        $('#email1-input-edit').css('background-color', '#FF9696').html(r);
                        $('#email2-input-edit').css('background-color', '#FF9696').html(r);
                        $('#user-edit').attr('disabled', 'disabled');               
                    }
                });
            }
        } else {
            $("#edit-email").addClass("disabled-form");
        }
        enableEditFormBtn();
    });

    $("#change-user-type-chkbx").on("change", function(e){
        if ($("#change-user-type-chkbx").is(":checked")) {
            $("#select-account").removeClass("disabled-form");
        } else {
            $("#select-account").addClass("disabled-form");
        }
        enableEditFormBtn();
    });

    $("#user-profile").on("click", function(e){
        window.location.href = location.origin+"/dashboard/?page=profile";
    });
});