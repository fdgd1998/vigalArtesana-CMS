var files = [];

jQuery(function($){

    $("#cancel").on("click", function() {
        window.location.href="?page=manage-gallery";
    });
    // Variable definition
    var categories = {};

    // Creating input select for selecting image category
    function createCategorySelectionInput() {
        var div = $((document.createElement("div")));
        var input_label = $((document.createElement("label")));
        var category_selection = $((document.createElement('select')));

        div.addClass("card-div-category");

        input_label.html("Categoría");
        input_label.addClass("input-label");

        category_selection.addClass("form-control category-upload");
        for (var key in categories) {
            var option = $((document.createElement('option')));
            option.attr("value", key);
            option.html(categories[key]);
            category_selection.append(option);
        }

        div.append(input_label);
        div.append(category_selection);

        return div;
    }

    function createImageAltTextInput() {
        var div = $((document.createElement("div")));
        var input_label = $((document.createElement("label")));
        var alt_text = $((document.createElement('input')));

        div.addClass("card-div-alt-text");

        input_label.html("Texto descriptivo");
        input_label.addClass("input-label")

        alt_text.addClass("form-control alt-text-upload");
        alt_text.attr("type", "text");

        div.append(input_label);
        div.append(alt_text);

        return div;
    }

    $("#upload-files").on("change", function(e){

        files = Array.from($("#upload-files")[0].files);

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
                    if (files[i].size > 5242880) {
                        filesToRemove.push(files[i]);
                        files.splice(files.indexOf(files[i]), 1);
                    }
                }
                if (filesToRemove.length > 0) {
                    var filesOverSize = "";
                    if (filesToRemove.length > 1) {
                        for (var i = 0; i <filesToRemove.length - 1; i++) {
                            filesOverSize = filesOverSize + filesToRemove[i].name;
                        }
                        var filesOverSize = filesOverSize + " y " + filesToRemove[filesToRemove.length - 1].name;
                    } else {
                        var filesOverSize = filesToRemove[0].name;
                    }

                    alert("Los ficheros " + filesOverSize + " superan el máximo de 5 MB. Se eliminarán de la selección y no se subirán. Comprueba el tamaño de estos ficheros e inténtalo de nuevo.");
                }
                imagesPreview(filesToRemove); // Load images preview
                
                if (filesToRemove.length != files.length) {
                    $("#upload-files-name").html((files.length)+" fichero(s) seleccionado(s)."); // Updating input text.
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

    function ImageReader(file) {
        var name = file.name;
        var reader = new FileReader();
        reader.onload = function(event) {
            var maindiv = $(document.createElement('div'));
            var imgdiv = $(document.createElement('div'));
            var propdiv = $(document.createElement('div'));

            var filename = $(document.createElement("label"));
            filename.text(name);

            maindiv.addClass("main-div");
            maindiv.attr("id", name);
            var img = $((document.createElement('img')));
            img.addClass("card-div-img");
            img.attr("src", event.target.result);

            imgdiv.append(img);
            imgdiv.append(filename);
            propdiv.append(createCategorySelectionInput());
            propdiv.append(createImageAltTextInput());
            maindiv.append(imgdiv);
            maindiv.append(propdiv);

            $("#images-preview").append(maindiv);
        }
        reader.readAsDataURL(file);
    }

    // Getting location URL of input images.
    function imagesPreview(filesToRemove) {
        if (files) {
            for (var i = 0; i < files.length; i++) {
                if (!filesToRemove.includes(files[i])) {
                    ImageReader(files[i]);
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
        var image_alt_text = [];
        var formData = new FormData();
        // var i = 0;

        // getting category ids selected for each image
        $(".category-upload").each(function(index) {    
            var value = $(this).val();
            image_categories[index] = value;
            // image_categories[i++] = value;
        });

        // getting alt text for each image
        $(".alt-text-upload").each(function(index) {    
            var value = $(this).val();
            image_alt_text[index] = value;
        });

        formData.append("categories", JSON.stringify(image_categories)); // encoding string to pass it to php file
        formData.append("alt_text", JSON.stringify(image_alt_text));

        // getting files metadata to pass it to php file
        // var files = $("#upload-files").prop("files");
            for (var i = 0; i < files.length; i++) {
                // formData.append("image"+i, files[i]);
                formData.append(files[i].name, files[i]);
            }

        // Display the key/value pairs
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
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
                $(document).find("#spinner-div").remove();
            }
        });
    });
});