$(document).ready(function() {

    $("#maintenance-on, #maintenance-off").on("click", function(){
        var enable = false;
        if ($(this).attr("id") == "maintenance-on") {
            enable = true;
        }
        $.ajax({
            url: location.origin+'/dashboard/admin/site-settings/update_maintenance_mode.php', // this is the target
            type: 'post', // method
            data: {mode: enable}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location.href = location.origin+"/dashboard/?page=advanced";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });  
    })

});