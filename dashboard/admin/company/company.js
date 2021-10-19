$(document).ready(function() {
    $(".social").on("change", function() {
        if (this.checked) {
            switch($(this).attr("id")) {
                case "instagram_chkbx":
                    $("#instagram_url").removeAttr("disabled");
                    break;
                case "facebook_chkbx":
                    $("#facebook_url").removeAttr("disabled");
                    break;
                case "whatsapp_chkbx":
                    $("#whatsapp_url").removeAttr("disabled");
                    break;
            }
        } else {
            switch($(this).attr("id")) {
                case "instagram_chkbx":
                    $("#instagram_url").attr("disabled","disabled");
                    break;
                case "facebook_chkbx":
                    $("#facebook_url").attr("disabled","disabled");
                    break;
                case "whatsapp_chkbx":
                    $("#whatsapp_url").attr("disabled","disabled");
                    break;
            }
        }
    });

    $("#submit_social").on("click", function() {
        // var socialURLs = [
        //     $("#instagram_url").val(),
        //     $("#facebook_url").val(),
        //     $("#whatsapp_url").val()
        // ]
        // Sending AJAX request to the server.
        console.log(location.origin);
        // var formData = new FormData();
        var social = {};
        if ($("#instagram_chkbx").is(':checked')) social["instagram"] = $("#instagram_url").val();
        if ($("#facebook_chkbx").is(':checked')) social["facebook"] = $("#facebook_url").val();
        if ($("#whatsapp_chkbx").is(':checked')) social["whatsapp"] = $("#whatsapp_url").val();

        // if ($("#instagram_chkbx").is(':checked')) formData.append("instagramURL", $("#instagram_url").val());
        // if ($("#facebook_chkbx").is(':checked')) formData.append("facebookURL", $("#facebook_url").val());
        // if ($("#whatsapp_chkbx").is(':checked')) formData.append("whatsappURL", $("#whatsapp_url").val());
        $.ajax({
            url: location.origin+"/dashboard/admin/company/update_social_media.php", // this is the target
            type: 'POST', // method
            data: {social: JSON.stringify(social)},
            success: function(response) { // HTTP response code is 200
                alert("200:"+response);
            },
            error: function(response) { // HTTP response code is != than 200
                alert("error: "+response);
            }
        });
    });
})