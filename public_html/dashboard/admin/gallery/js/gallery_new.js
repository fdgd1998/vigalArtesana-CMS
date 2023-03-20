var input_files = [];

// jQuery(function($){

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

        input_files = Array.from($("#upload-files")[0].files);
        console.log(input_files);
        var filenames = [];
        var filesToRemove = [];

        for (var i = 0; i < input_files.length; i++) {
            filenames.push(input_files[i].name);
        }

        console.log(filenames);

        // AJAX call to get categories stored in database
        $.ajax({
            type: 'POST',
            async: false,
            url: './admin/gallery/get_categories.php',
            dataType: 'json',
            data: {id: 'testdata'},
            cache: false,
            success: function(result) {
                // alert(result);
                $.each(result, function(key, value) {
                    categories[key] = value;
                });
            },
        });

        // Emptying previous images preview
        $("#images-preview").empty();

        if (input_files.length > 0) { // Checking if there's selected files
            if (input_files.length <= 5) { // Checking if there's less than 10 files selected.
                
                for (var i = 0; i < input_files.length; i++) {
                    console.log(input_files[i].name +": "+input_files[i].size);
                    if (input_files[i].size > 5242880) {
                        filesToRemove.push(input_files[i]);
                        input_files.splice(input_files.indexOf(input_files[i]), 1);
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

                    alert("Los ficheros " + filesOverSize + " superan el máximo de 5 MB. Comprueba el tamaño de estos ficheros e inténtalo de nuevo.");
                }

                var formData = new FormData();
                formData.append("filenames", JSON.stringify(filenames));
                $.ajax({
                    url: './admin/gallery/scripts/check_current_images_filenames.php', // this is the target
                    type: 'post', // method
                    dataType: 'text', // what is expected to be returned
                    cache: false,
                    data: formData, // pass the input valuse to serve
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,   // tell jQuery not to set contentType
                    success: function(response) { // HTTP response code is 200
                        console.log(response);
                        var existentFiles = JSON.parse(response);
                        
                        if (existentFiles.length > 0) {
                            var files = "";
                            if (existentFiles.length > 1) {
                                for (var i = 0; i <existentFiles.length - 1; i++) {
                                    files = files + existentFiles[i];
                                }
                                files = files + " y " + existentFiles[existentFiles.length - 1];
                            } else {
                                files = existentFiles[0];
                            }
                            $("#upload-files-name").html("Seleccionar fichero(s)...");
                            $("#uploadbtn").attr("disabled","disabled");
                            alert("Los siguientes ficheros ya existen el servidor: " + files + ". Renómbralos e inténtalo de nuevo.")
                        } else {
                            // imagesPreview(filesToRemove); // Load images preview
                            imagesPreview();

                            // $("#upload-files-name").html((input_files.length)+" fichero(s) seleccionado(s)."); // Updating input text.
                            if (filesToRemove.length == 0) {
                                $("#upload-files-name").html((input_files.length)+" fichero(s) seleccionado(s)."); // Updating input text.
                                // $("#uploadbtn").removeAttr("disabled","disabled");
                            } else {
                                $("#upload-files-name").html("Seleccionar fichero(s)...");
                                $("#uploadbtn").attr("disabled","disabled");
                            }
                        }
                        
                    },
                    error: function(response) { // HTTP response code is != than 200
                        alert(response);
                        $("#upload-files").val("");
                        $("#upload-files-name").html("Seleccionar fichero(s)...");
                        $("#uploadbtn").attr("disabled","disabled");
                    }
                });

                
            } else {
                // If more than 10 files are selected, a warning is shown and form is resetted.
                alert("El número máximo de ficheros permitidos es 10. Revisa tu selección e inténtalo de nuevo.");
                $("#upload-files").val("");
                $("#upload-files-name").html("Seleccionar fichero(s)...");
                $("#uploadbtn").attr("disabled","disabled");
            }
        } else {
            // If no files are selected, reset form.
            $("#file-list").empty();
            $("#upload-files-name").html("Seleccionar fichero(s)...");
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
    function imagesPreview() {
        // if (input_files.length > 0) {
            for (var i = 0; i < input_files.length; i++) {
        //         if (!filesToRemove.includes(input_files[i])) {
                    ImageReader(input_files[i]);
            //     }
            }
        // }

    };

    // Starting database data insertion and file upload
   // Starting database data insertion and file upload
    $("#uploadbtn").on("click", function(e){
        var spinner_div = $("<div style='height: 100%; min-height: 100%; z-index: 10; position: absolute; bottom:0; left:0; right:0; background-color: rgba(255,255,255,.75)' class='row justify-content-center align-items-center' id='spinner-div'><div class='spinner-border' role='status'></div><span style='margin-left: 10px'>Subiendo imágenes...</span></div>");
        $("body").append(spinner_div);
        // Getting data to sent and appending it to the form data.
        var image_categories = {};
        var image_alt_text = {};
        var formData = new FormData();
        // var i = 0;

        // getting category ids selected for each image
        $(".category-upload").each(function(index) {    
            var value = $(this).val();
            var file = $(this).closest(".main-div").attr("id");
            image_categories[file] = value;
            // image_categories[i++] = value;
        });

        // getting alt text for each image
        $(".alt-text-upload").each(function(index) {    
            var value = $(this).val();
            var file = $(this).closest(".main-div").attr("id");
            image_alt_text[file] = value;
        });

        formData.append("categories", JSON.stringify(image_categories)); // encoding string to pass it to php file
        formData.append("alt_text", JSON.stringify(image_alt_text));

        // getting files metadata to pass it to php file
        // var files = $("#upload-files").prop("files");
            for (var i = 0; i < input_files.length; i++) {
                // formData.append("image"+i, files[i]);
                formData.append(input_files[i].name, input_files[i]);
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

    $(document).on("change", ".category-upload", function() {
        enableUploadBtn()
    });

    $(document).on("keyup", ".alt-text-upload", function() {
        enableUploadBtn()
    });

    $("#create-category").on("click", function() {
        window.location = location.origin + "/dashboard?page=new-category";
    });

    function enableUploadBtn() {
        console.log("enabling button...")
        var categories = $(document).find(".category-upload option:selected");
        var alt_text = $(document).find(".alt-text-upload");

        var cat_bool = false;
        var alt_text_bool = false;
    
        $.each(categories, function() {
            if ($(this).text() != "") cat_bool = true;
            else cat_bool = false;
        });

        $.each(alt_text, function() {
            if ($(this).val() != "") alt_text_bool = true;
            else alt_text_bool = false;
        });

        console.log(cat_bool);
        console.log(alt_text_bool);
        
        if (cat_bool && alt_text_bool) $("#uploadbtn").prop("disabled", false);
        else $("#uploadbtn").prop("disabled", true);
    }
// });