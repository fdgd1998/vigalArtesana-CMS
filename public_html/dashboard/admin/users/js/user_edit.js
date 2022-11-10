function generatePass() {
    var result           = '';
    var characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&()\-_+,.';
    var charactersLength = characters.length;
    for ( var i = 0; i <= 12; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

$("#generate").on("click", function(){
    var pass = generatePass();
    while (!passwordComplexity(pass)) {
        pass = generatePass();
    }
    $("#new-password").val(pass);
    $("#edit-pass").removeAttr("disabled");
});

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
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });
})