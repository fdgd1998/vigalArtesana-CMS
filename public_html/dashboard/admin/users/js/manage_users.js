var id = 0;
var email = 0;
$("#create-user").on("click", function() {
    window.location = location.origin + "/dashboard?page=new-user";
})

$(".user-delete").on("click", function() {
    id = $(this).attr("userid");
    $("#staticBackdropLabel-delete").html("Borando usuario " + $(this).parent().parent().siblings(".username").html());
    $('#delete-user').modal().show();
})

$(".user-reset").on("click", function() {
    email = $(this).attr("email");
    $("#staticBackdropLabel-reset").html("Restableciendo contraseña de " + $(this).parent().parent().siblings(".username").html());
    $('#reset-user').modal().show();
})

$("#user-delete").on("click", function() {
    $.ajax({
        url: location.origin+'/dashboard/admin/users/delete_user.php', // this is the target
        type: 'post', // method
        dataType: 'text',
        cache: false,
        data: {userid: id}, // pass the input value to serve
        success: function(response) { // if the http response code is 200
            alert(response);
            window.location = location.origin+"/dashboard/?page=manage-users";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });
})

$("#user-reset").on("click", function() {
    $.ajax({
        url: location.origin+'/dashboard/admin/users/user_password_reset_email.php', // this is the target
        type: 'post', // method
        dataType: 'text',
        cache: false,
        data: {useremail: email}, // pass the input value to serve
        success: function(response) { // if the http response code is 200
            alert(response);
            window.location = location.origin+"/dashboard/?page=manage-users";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });
})

$(".user-edit").on("click", function() {
    var id = $(this).attr("userid");
    window.location = location.origin + "/dashboard?page=edit-user&id="+id;
})