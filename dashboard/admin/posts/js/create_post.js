jQuery(function($){

    // Enabling submit button for post creation.
    function enableCreateBtn() {
        var total_inputs = 0;
        if ($("#title").val() != "") total_inputs++;
        if ($("#post-content").val() != "") total_inputs++;
        if ($("#category-option option:selected").val() != "") total_inputs++;
        if ($("#upload-files").prop("files").length > 0) total_inputs++;
        console.log(total_inputs);
        if (total_inputs == 4) $("#post-create").prop("disabled", false);
        else $("#post-create").prop("disabled", true);
    }

    // Checking content for post creation.
    $("#title, #post-content").on("keyup", function(e){
        enableCreateBtn();
    });

    // Checking content for post creation.
    $("#category-option, #upload-files").on("change", function(e){
        enableCreateBtn();
    });

    // Checking content for post creation.
    $("#upload-files").on("change", function(e){
        var files = $("#upload-files").prop("files");
        if (files.length > 0) { // Checking if there's selected files
            if (files.length <= 10) { // Checking if there's less than 10 files selected.
                var namesArray = $.map(files, function(val) { return val.name; }); // Getting file names.
                $("#file-list").empty(); // Emptying the file list.

                // Appending file names to a list and showing it to the user.
                for (var i = 0; i < namesArray.length; i++) {
                    $("#file-list").append("<li><i class='far fa-file-image' style='padding-right: 5px;'></i>"+namesArray[i]+"</li>");
                }
                $("#upload-files-name").html(files.length+" fichero(s) seleccionado(s)."); // Updating input text.
            } else {
                // If more than 10 files are selected, a warning is shown and form is resetted.
                alert("El número máximo de ficheros permitidos es 10. Revisa tu selección e inténtalo de nuevo.");
                $("#upload-files").val("");
                $("#upload-files-name").html("Subir fichero(s)...");
                $("#file-list").empty();
            }
        } else {
            // If no files are selected, form is resetted.
            $("#file-list").empty();
            $("#upload-files-name").html("Subir fichero(s)...");
        }
        enableCreateBtn(); // Checking if submit button should be enabled.
    });

    //Exiting post creation/edition
    $("#post-cancel").on("click", function(e){
        window.location = location.origin + "/dashboard/?page=list-posts&order=asc"
    });

    // Creating the post.
    $("#post-create").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var filesLength = $("#upload-files").prop("files").length;
        var formData = new FormData();
        formData.append("title", $("#title").val());
        formData.append("content", $("#post-content").val());
        formData.append("category", $("#category option:selected").val());
        formData.append("file_count", filesLength);

        // Appending file names to the form data.
        if (filesLength == 1) {
            formData.append("image", $("#upload-files").prop("files")[0]);
        } else {
            var files = $("#upload-files").prop("files");
            for (var i = 0; i < files.length; i++) {
                formData.append("image"+i, files[i]);
            }
        }
        
        // Sending AJAX request to the server.
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/create_post.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location = location.origin+"/dashboard/?page=list-posts&order=asc";
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });
});