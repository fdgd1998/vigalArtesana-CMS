$(document).ready(function() {
    $("#save-about-us").on("click", function() {
        ShowSpinnerOverlay("Guardando...");
        $.ajax({
            url: location.origin+'/dashboard/admin/site-settings/update_about_us.php', // this is the target
            type: 'post', // method
            data: {about_text: $('#summernote').summernote('code')}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location = location.origin+"/dashboard/?page=about-us";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                $(document).find("#spinner-div").remove();
            }
        });
    });
});