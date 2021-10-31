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
        var social = {};
        if ($("#instagram_chkbx").is(':checked')) social["instagram"] = $("#instagram_url").val();
        if ($("#facebook_chkbx").is(':checked')) social["facebook"] = $("#facebook_url").val();
        if ($("#whatsapp_chkbx").is(':checked')) social["whatsapp"] = $("#whatsapp_url").val();

        $.ajax({
            url: location.origin+"/dashboard/admin/site-settings/update_social_media.php", // this is the target
            type: 'POST', // method
            data: {social: JSON.stringify(social)},
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.href = "?page=contact-settings";
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });

    $(".week").on("change", function() {
        var current = $(this).attr("id").substr(6);
        console.log("day week change: "+current);
        if ($(this).is(":checked")) {
            $("#"+current).removeAttr("disabled");
        } else{
            $("#"+current).attr("disabled","disabled");
        }
    });

    $("#submit_opening_hours").on("click", function() {
        console.log("getting opening hours...");
        var hours = {};
        $(".week").each(function(i, obj) {
            if ($(this).is(":checked")) {
                console.log($(this).attr("id").substring(6));
                hours[$(this).attr("id").substring(6)] = $("#"+$(this).attr("id").substring(6)).val();
            }
        });
        console.log(hours);

        $.ajax({
            url: location.origin+"/dashboard/admin/site-settings/update_opening_hours.php", // this is the target
            type: 'POST', // method
            data: {hours: JSON.stringify(hours)},
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.href = "?page=contact-settings";
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });

    $("#submit_contact_data").on("click", function() {
        $.ajax({
            url: location.origin+"/dashboard/admin/site-settings/update_contact_phone_email.php", // this is the target
            type: 'POST', // method
            data: {
                phone: $("#phone").val(),
                email: $("#email").val()
            },
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.href = "?page=contact-settings";
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });

    $("#submit_map_link").on("click", function() {
        $.ajax({
            url: location.origin+"/dashboard/admin/site-settings/update_map_link.php", // this is the target
            type: 'POST', // method
            data: {
                map_link: $("#map-link").val()
            },
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.href = "?page=contact-settings";
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });
})