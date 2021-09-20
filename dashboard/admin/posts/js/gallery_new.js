var filesToRemove = [];

jQuery(function($){

    var categories = {};
    // Enabling submit button for post creation.
    function enableCreateBtn() {
        var total_inputs = 0;
        if ($("#upload-files").prop("files").length > 0) total_inputs++;
        if (total_inputs == 1) $("#upload").prop("disabled", false);
        else $("#upload").prop("disabled", true);
    }

    function createCategorySelection() {
        category_selection = $((document.createElement('select')));
        category_selection.addClass("form-control category-upload");
        for (var key in categories) {
            var option = $((document.createElement('option')));
            option.attr("value", key);
            option.html(categories[key]);
            category_selection.append(option);
        }
        // console.log(category_selection);
        // console.log(categories);
        return category_selection;
    }

    // Checking content for post creation.
    $("#category-option, #upload-files").on("change", function(e){
        enableCreateBtn();
    });

    // Checking content for post creation.
    $("#upload-files").on("change", function(e){
        var files = $("#upload-files").prop("files");

        $.ajax({
            type: 'POST',
            async: false,
            url: './admin/posts/get_categories.php',
            dataType: 'json',
            data: 'id=testdata',
            cache: false,
            success: function(result) {
                $.each(result, function(key, value) {
                    categories[key] = value;
                });
            },
        });

        $("#images-preview").empty();

        if (files.length > 0) { // Checking if there's selected files
            if (files.length <= maxFilesToUpload) { // Checking if there's less than 10 files selected.
                var namesArray = $.map(files, function(val) { return val.name; }); // Getting file names.
                $("#file-list").empty(); // Emptying the file list.

                imagesPreview(this);
                $("#upload-files-name").html(files.length+" fichero(s) seleccionado(s)."); // Updating input text.
            } else {
                // If more than 10 files are selected, a warning is shown and form is resetted.
                alert("El número máximo de ficheros permitidos es "+maxFilesToUpload+". Revisa tu selección e inténtalo de nuevo.");
                $("#upload-files").val("");
                $("#upload-files-name").html("Subir fichero(s)...");
                $("#file-list").empty();
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
    $("#cancel").on("click", function(e){
        window.location = location.origin + "/dashboard/?page=list-posts&order=asc"
    });

    // Getting URL of input images.
    function imagesPreview(input) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = $((document.createElement('img')));
                    img.addClass("card-img-top img-fluid post_img");
                    img.attr("src", event.target.result);
                    var card_div =  $((document.createElement('div')));
                    card_div.addClass("card h-100");
                    card_div.append(img);
                    card_div.append(createCategorySelection());
                    var main_div = $((document.createElement('div')));
                    main_div.addClass('col mb-4');
                    main_div.append(card_div);
                    $("#images-preview").append(main_div);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    // Creating or editing the post.
    $("#upload").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var image_categories = [];
        // var filesLength = 0;
        // if ($("#upload-files").prop("files").length != 0) {
        //     filesLength = $("#upload-files").prop("files").length;
        // }
        var formData = new FormData();
        var i = 0;
        jQuery('.category-upload').each(function() {    
            var value = $(this).val();
            image_categories[i++] = value;
            // data_to_upload[value] = $("#upload-files").prop("files")[i++];
        });
        // console.log(image_categories);
        i = 0;
        formData.append("categories", JSON.stringify(image_categories));
        var files = $("#upload-files").prop("files");
            for (var i = 0; i < files.length; i++) {
                formData.append("image"+i, files[i]);
            }
        // Sending AJAX request to the server.
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/create_gallery_items.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: formData, // pass the input valuse to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.replace("?page=manage-gallery");
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });
});