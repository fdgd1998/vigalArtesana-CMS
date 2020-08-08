var filesToRemove = [];

jQuery(function($){

    // Enabling submit button for post creation.
    function enableCreateBtn() {
        var total_inputs = 0;
        if ($("#title").val() != "") total_inputs++;
        if ($("#post-content").val() != "") total_inputs++;
        if ($("#category option:selected").val() != "Sin resultados.") total_inputs++;
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

        // Erasing old images from showcase
        $(".new-image").remove();
        $("#new-image-container").prop("hidden", true);

        if (files.length > 0) { // Checking if there's selected files
            if (files.length <= maxFilesToUpload) { // Checking if there's less than 10 files selected.
                var namesArray = $.map(files, function(val) { return val.name; }); // Getting file names.
                $("#file-list").empty(); // Emptying the file list.

                // Appending file names to a list and showing it to the user.
                for (var i = 0; i < namesArray.length; i++) {
                    $("#file-list").append("<li><i class='far fa-file-image' style='padding-right: 5px;'></i>"+namesArray[i]+"</li>");
                }
                imagesPreview(this, $("#images-preview"));
                $("#upload-files-name").html(files.length+" fichero(s) seleccionado(s)."); // Updating input text.
                $("#new-image-container").prop("hidden", false);
            } else {
                // If more than 10 files are selected, a warning is shown and form is resetted.
                alert("El número máximo de ficheros permitidos es "+maxFilesToUpload+". Revisa tu selección e inténtalo de nuevo.");
                $("#upload-files").val("");
                $("#upload-files-name").html("Subir fichero(s)...");
                $("#file-list").empty();
                $("#new-image-container").prop("hidden", true);
            }
        } else {
            // If no files are selected, reset form.
            $("#file-list").empty();
            $("#upload-files-name").html("Subir fichero(s)...");
        }
        enableCreateBtn(); // Checking if submit button should be enabled.
    });

    //Checking the images to be removed.
    $(".remove-image").change(function(e) {
        if ($(this).is(":checked")) {
            filesToRemove.push($(this).attr('id'));
            console.log(filesToRemove);
        } else {
            var removeElement = filesToRemove.indexOf($(this).attr('id'));
            if (removeElement != undefined) {
                filesToRemove.splice(removeElement, 1);
            }
            console.log(filesToRemove);
        }
    });

    //Exiting post creation/edition
    $("#post-cancel").on("click", function(e){
        window.location = location.origin + "/dashboard/?page=list-posts&order=asc"
    });

    // Getting URL of input images.
    function imagesPreview(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).addClass('rounded float-left new-image').appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });

    // Creating or editing the post the post.
    $("#post-create").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var filesLength = 0;
        if ($("#upload-files").prop("files").length != 0) {
            filesLength = $("#upload-files").prop("files").length;
        }
        var formData = new FormData();
        formData.append("title", $("#title").val());
        formData.append("content", $("#post-content").val());
        formData.append("category", $("#category option:selected").val());

        // Appending file names to the form data.
        if (filesLength == 1) {
            formData.append("image", $("#upload-files").prop("files")[0]);
            formData.append("file_count", filesLength);
        } else if (filesLength > 1){
            var files = $("#upload-files").prop("files");
            for (var i = 0; i < files.length; i++) {
                formData.append("image"+i, files[i]);
            }
            formData.append("file_count", filesLength);
        }
        if ($(this).text() == "Crear") {           
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
        } else {
            if (filesToRemove.length != 0) {
                formData.append("images_to_remove", filesToRemove.join());
            }
            formData.append("post_id", post_id);
             // Sending AJAX request to the server.
             $.ajax({
                url: location.origin+'/dashboard/admin/posts/edit_post.php', // this is the target
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
        }

    });
});