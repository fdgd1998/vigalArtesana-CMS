var user_correct = false;
var email_correct = false;

jQuery(function($) {

    $('#username').on('keyup', function(e) {
        if ($(this).val() != "") {
            console.log($('#username').val());
            // perform an ajax call
            $.ajax({
                url: 'admin/users/check_data.php', // this is the target
                method: 'post', // method
                data: {username: $('#username').val()}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    console.log("username: "+r);
                    $('#username').css('background-color', '#A7F0A9').html(r);
                    console.log('user does not exist.');
                    user_correct = true;
                },
                error: function(r) { // if the http response code is other than 200
                    $('#username').css('background-color', '#FF9696').html(r);
                    console.log('user exists.');
                    user_correct = false;
                }
            });
        }
        console.log("user: "+user_correct);
        enableCreateFormBtn();
    });

    function enableCreateFormBtn() {
        var total_inputs = 0;
        if (user_correct) total_inputs++;
        if (email_correct) total_inputs++;
        if ($('#name').val() != "") total_inputs++;
        if ($('#surname').val() != "") total_inputs++;

        console.log("total input: "+total_inputs);
        if (total_inputs == 4) $('#submit').removeAttr('disabled');
        else $('#submit').attr('disabled', 'disabled');
    };

    $('#email1, #email2').on('keyup', function(e) {
        // set the variables
        var email1 = $('#email1').val();
        var email2 = $('#email2').val();
        if (email1 == email2 && email1 != "" && email2 != "") {
            $.ajax({
                url: 'admin/users/check_data.php', // this is the target
                method: 'post', // method
                data: {email: email1}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $('#email1').css('background-color', '#A7F0A9').html(r);
                    $('#email2').css('background-color', '#A7F0A9').html(r);
                    email_correct = true;
                    
                },
                error: function(r) { // if the http response code is other than 200
                    $('#email1-input-create').css('background-color', '#FF9696').html(r);
                    $('#email2-input-create').css('background-color', '#FF9696').html(r);         
                }
            });
            
        } else if (email1 != email2 && email1 != "" && email1 != "") {
            $('#email1').css('background-color', '#FF9696');
            $('#email2').css('background-color', '#FF9696');
        }
        console.log("email: "+email_correct);

        enableCreateFormBtn();
    });

    $('#submit').on('click', function(e) {
        // set the variables
        var user = $('#username').val();
        var name = $('#name').val();
        var surname = $('#surname').val();
        var email = $('#email1').val();
        var account_type = $('#account-type option:selected').val();

        console.log(register_data);
        var register_data = {
            username_s: user,
            name_s: name,
            surname_s: surname,
            email_s: email,
            account_s: account_type
        }
        
        // perform an ajax call
        $.ajax({
            url: 'admin/users/create_user.php', // this is the target
            method: 'post', // method
            data: register_data, // pass the input value to server
            success: function(r) { // if the http response code is 200
                alert("El usuario se ha creado correctamente.");
                window.location = "?page=list-users&order=asc";
            },
            error: function(r) { // if the http response code is other than 200
                alert("Ha ocurrido un error al crear el usuario.");
            }
        });

    });
    $("#cancel").on('click', function(e) {
        window.location = "?page=list-users&order=asc";
    });
})