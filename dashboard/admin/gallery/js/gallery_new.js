jQuery(function($){

    $("#cancel").on("click", function() {
        window.location.href="?page=manage-gallery";
    });
    // Variable definition
    var categories = {};

    // Creating input select for selecting image category
    function createCategorySelection() {
        category_selection = $((document.createElement('select')));
        category_selection.addClass("form-control category-upload");
        for (var key in categories) {
            var option = $((document.createElement('option')));
            option.attr("value", key);
            option.html(categories[key]);
            category_selection.append(option);
        }
        return category_selection;
    }

    // Checking content for post creation.
    $("#upload-files").on("change", function(e){

        var files = $("#upload-files").prop("files");

        // AJAX call to get categories stored in database
        $.ajax({
            type: 'POST',
            async: false,
            url: './admin/gallery/get_categories.php',
            dataType: 'json',
            data: 'id=testdata',
            cache: false,
            success: function(result) {
                $.each(result, function(key, value) {
                    categories[key] = value;
                });
            },
        });

        // Emptying previous images preview
        $("#images-preview").empty();

        if (files.length > 0) { // Checking if there's selected files
            if (files.length <= 10) { // Checking if there's less than 10 files selected.
                imagesPreview(this); // Load images preview
                $("#upload-files-name").html(files.length+" fichero(s) seleccionado(s)."); // Updating input text.
                $("#uploadbtn").removeAttr("disabled","disabled");
            } else {
                // If more than 10 files are selected, a warning is shown and form is resetted.
                alert("El número máximo de ficheros permitidos es "+maxFilesToUpload+". Revisa tu selección e inténtalo de nuevo.");
                $("#upload-files").val("");
                $("#upload-files-name").html("Subir fichero(s)...");
                $("#uploadbtn").attr("disabled","disabled");
            }
        } else {
            // If no files are selected, reset form.
            $("#file-list").empty();
            $("#upload-files-name").html("Subir fichero(s)...");
            $("#uploadbtn").attr("disabled","disabled");
        }
    });

    // Getting location URL of input images.
    function imagesPreview(input) {
        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    //Creating each image preview, from here->
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
                    // ->to here
                }
                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    // Starting database data insertion and file upload
    $("#uploadbtn").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var image_categories = [];
        var formData = new FormData();
        var i = 0;

        // getting category ids selected for each image
        jQuery('.category-upload').each(function() {    
            var value = $(this).val();
            image_categories[i++] = value;
        });
        i = 0;

        formData.append("categories", JSON.stringify(image_categories)); // encoding string to pass it to php file

        // getting files metadata to pass it to php file
        var files = $("#upload-files").prop("files");
            for (var i = 0; i < files.length; i++) {
                formData.append("image"+i, files[i]);
            }

        // Sending AJAX request to the server.
        $.ajax({
            url: './admin/gallery/create_gallery_items.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: formData, // pass the input valuse to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.replace("?page=manage-gallery"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });
});