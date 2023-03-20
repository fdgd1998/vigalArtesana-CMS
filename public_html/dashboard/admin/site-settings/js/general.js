function enableIndexImageEditBtn() {
    total_inputs = 0;
    if ($("#upload-index-image").prop("files").length == 1) total_inputs++;
    if ($.trim($("#image-desc").val()) != "") total_inputs++;
    if (total_inputs == 2) {
        $("#submit-index-image").removeAttr("disabled");
    } else {
        $("#submit-index-image").attr("disabled",true);
    }
}

$(document).ready(function() {
    $("#index-image-description").on("keyup", function() {
        if ($.trim($(this).val()) != "") {
            $("#submit-index-image-description").removeAttr("disabled");
        } else {
            $("#submit-index-image-description").attr("disabled","disabled");
        }
    });

    $("#image-desc").on("keyup", function() {
        enableIndexImageEditBtn()
    });

    $("#upload-index-image").on("change", function(e){
        var input = this;
        var blob = $(this).prop("files")[0];
        if (blob) { // Checking if there's selected files
            var formData = new FormData();
            formData.append("filenames", blob.name);
            $.ajax({
                url: './admin/site-settings/check_current_index_filenames.php', // this is the target
                type: 'post', // method
                dataType: 'text', // what is expected to be returned
                cache: false,
                data: formData, // pass the input valuse to serve
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: function(response) { // HTTP response code is 200
                    console.log(response);
                    var existentFile = response;
                    if (!existentFile) {
                        if (blob.size < 5242880) {
                            readURL(input, $("#index-image-preview"));
                            $("#upload-index-name").html(blob.name); // Updating input text.
                        } else {
                            $(input).val('');
                            alert("El fichero supera el máximo de 5 MB. Comprueba el tamaño e inténtalo de nuevo.");
                            $("#index-image-preview").attr("src", "../includes/img/placeholder-image.jpg");
                            $("#upload-index-name").html("Seleccionar imagen...");
                        }
                    }
                },
                error: function(response) { 
                    $("#upload-index-name").html("Seleccionar imagen...");
                    $("#index-image-preview").attr("src", "../includes/img/placeholder-image.jpg");
                    $("#upload-index-image").val("");
                    alert("El fichero " + blob.name + " ya existe en el servidor. Renómbralo e inténtalo de nuevo.");
                } 
            });
        } else {
             // If no files are selected, reset form.
             $("#index-image-preview").attr("src", "../includes/img/placeholder-image.jpg");
             $("#upload-index-name").html("Seleccionar imagen...");
        }
        enableIndexImageEditBtn();
    });

    $("#submit-index-image-description").on("click", function(e){
        ShowSpinnerOverlay("Actualizando descripción...");
        // Getting data to sent and appending it to the form data.
        var formData = new FormData();

        formData.append("index-image-description", $("#index-image-description").val()); // encoding string to pass it to php file
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
                window.location.replace("?page=general-settings"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
                HideSpinnerOverlay();
            }
        });
    });

    $("#submit-index-image").on("click", function(e){
        ShowSpinnerOverlay("Actualizando imagen...");
        // Getting data to sent and appending it to the form data.
        var formData = new FormData();

        formData.append("image", $("#upload-index-image").prop("files")[0]);
        formData.append("image-desc", $.trim($("#image-desc").val()));
        // getting files metadata to pass it to php file
        // var files = $("#upload-index-image").prop("files")[0];
        //     for (var i = 0; i < files.length; i++) {
        //         formData.append("image"+i, files[i]);
        //     }

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
                window.location.replace("?page=general-settings"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
                HideSpinnerOverlay();
            }
        });
    });

    $("#submit-index-brief-description").on("click", function(e){
        ShowSpinnerOverlay("Actualizando descripción...");
        // Sending AJAX request to the server.
        $.ajax({
            url: './admin/site-settings/update_index_brief_description.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: {description: $("#index-brief-description").summernote("code")}, // pass the input valuse to serve
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.replace("?page=general-settings"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
                HideSpinnerOverlay();
            }
        });
    });
})