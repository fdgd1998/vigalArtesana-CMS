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

    $("#index-image-description").on("input", function() {
        console.log($(this).val());
        if ($(this).val()) {
            $("#submit-index-image-description").removeAttr("disabled");
        } else {
            $("#submit-index-image-description").attr("disabled","disabled");
        }
    });

    $("#upload-index-image").on("change", function(e){

        //Disable upload button if input file is empty, or enabling if files are selected.
        // $("#upload").prop("disabled", $(this).prop("files").length === 0?true:false);
        var files = $("#upload-index-image").prop("files");

        // Emptying previous images preview
        // $("#index-image-preview").empty();

        if (files.length > 0) { // Checking if there's selected files
            // indexImagePreview(this); // Load images preview
            $("#upload-index-name").html(files.length+" fichero seleccionado."); // Updating input text.
            $("#submit-index-image").removeAttr("disabled");
        } else {
            // If no files are selected, reset form.
            $("#upload-index-name").html("Seleccionar fichero...");
            $("#submit-index-image").attr("disabled","disabled");
        }
    });

    // Getting location URL of input images.
    // function indexImagePreview(input) {
    //     if (input.files) {
    //         var reader = new FileReader();
    //         reader.onload = function(event) {
    //             //Creating each image preview, from here->
    //             var img = $((document.createElement('img')));
    //             img.addClass("img-fluid");
    //             img.attr("src", event.target.result);
    //             var img_div =  $((document.createElement('div')));
    //             img_div.addClass("w-50");
    //             img_div.append(img);
    //             var main_div = $((document.createElement('div')));
    //             main_div.append(img_div);
    //             $("#index-image-preview").append(main_div);
    //             // ->to here
    //         }
    //         reader.readAsDataURL(input.files[0]);
    //     }

    // };

    $("#submit-index-image-description").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var formData = new FormData();

        formData.append("index-image-description", $("#index-image-description").val()); // encoding string to pass it to php file

        // getting files metadata to pass it to php file
        // var files = $("#upload-index-image").prop("files");
        //     for (var i = 0; i < files.length; i++) {
        //         formData.append("image"+i, files[i]);
        //     }

        // Sending AJAX request to the server.
        $.ajax({
            url: './admin/site-settings/update_index_image_description.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: formData, // pass the input valuse to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.replace("?page=site-settings"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });

    $("#submit-index-image").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var formData = new FormData();

        formData.append("filename", "index.php"); // encoding string to pass it to php file

        // getting files metadata to pass it to php file
        var files = $("#upload-index-image").prop("files");
            for (var i = 0; i < files.length; i++) {
                formData.append("image"+i, files[i]);
            }

        // Sending AJAX request to the server.
        $.ajax({
            url: './admin/site-settings/update_index_image.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: formData, // pass the input valuse to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.replace("?page=site-settings"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });
})