
$("#role").on("change", function() {
    console.log($("#role option:selected").val())
    console.log($("#username").val())
    $.ajax({
        url: location.origin+'/dashboard/admin/users/update_user_role.php', // this is the target
        type: 'post', // method
        dataType: 'text',
        cache: false,
        data: {role: $("#role option:selected").val(), username: $("#username").val()}, // pass the input value to serve
        success: function(response) { // if the http response code is 200
            alert(response);
            window.location = location.origin + "/dashboard?page=manage-users";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });
})

$("#cancel-create-user").on("click", function() {
    window.location = location.origin + "/dashboard?page=manage-users";
})

$("#generate").on("click", function(){
    var pass = generatePass();
    while (!passwordComplexity(pass)) {
        pass = generatePass();
    }
    $("#password").val(pass);
    $("#edit-pass").removeAttr("disabled");
});

$("#edit-pass").on("click", function() {
    var formdata = new FormData();
    formdata.append("userid", userid);
    formdata.append("pass", $("#password").val());

    $.ajax({
        url: location.origin+'/dashboard/admin/users/update_user_random_password.php', // this is the target
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