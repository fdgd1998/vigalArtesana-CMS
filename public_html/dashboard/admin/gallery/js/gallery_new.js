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
                //alert(result);
                $.each(result, function(key, value) {
                    categories[key] = value;
                });
            },
        });

        // Emptying previous images preview
        $("#images-preview").empty();

        if (files.length > 0) { // Checking if there's selected files
            if (files.length <= 10) { // Checking if there's less than 10 files selected.
                var filesToRemove = [];
                for (var i = 0; i < files.length; i++) {
                    console.log(files[i].name +": "+files[i].size);
                    if (files[i].size > 2097152) {
                        filesToRemove.push(files[i]);
                    }
                }
                if (filesToRemove.length > 0) {
                    // var filesOverSize = "";
                    // for (var i = 0; i < filesToRemove.length-1; i++) {
                    //     filesOverSize = filesOverSize + filesToRemove[i].name;
                    // }
                    alert("Uno o más ficheros superan el máximo de 2 MB. Se eliminarán de la selección y no se subirán. Comprueba el tamaño de estos ficheros e inténtalo de nuevo.");
                }
                imagesPreview(this, filesToRemove); // Load images preview
                
                if (filesToRemove.length != files.length) {
                    $("#upload-files-name").html((files.length-filesToRemove.length)+" fichero(s) seleccionado(s)."); // Updating input text.
                    $("#uploadbtn").removeAttr("disabled","disabled");
                } else {
                    $("#upload-files-name").html("Subir fichero(s)...");
                    $("#uploadbtn").attr("disabled","disabled");
                }
            } else {
                // If more than 10 files are selected, a warning is shown and form is resetted.
                alert("El número máximo de ficheros permitidos es 10. Revisa tu selección e inténtalo de nuevo.");
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
    function imagesPreview(input, filesToRemove) {
        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                if (!filesToRemove.includes(input.files[i])) {
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
        }

    };

    // Starting database data insertion and file upload
   // Starting database data insertion and file upload
    $("#uploadbtn").on("click", function(e){
        var spinner_div = $("<div style='height: 100%; min-height: 100%; z-index: 10; position: absolute; bottom:0; left:0; right:0; background-color: rgba(255,255,255,.75)' class='row justify-content-center align-items-center' id='spinner-div'><div class='spinner-border' role='status'></div><span style='margin-left: 10px'>Subiendo imágenes...</span></div>");
        $("body").append(spinner_div);
        // Getting data to sent and appending it to the form data.
        var image_categories = [];
        var formData = new FormData();
        var i = 0;

        // getting category ids selected for each image
        jQuery('.category-upload').each(function() {    
            var value = $(this).val();
            image_categories[i++] = value;
        });

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
                //alert(response);
                window.location.replace("?page=manage-gallery"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
                $(document).find("#spinner-div").remove();
            }
        });
    });
});