jQuery(function($) {

    // Showing edition form.
    $('.cat-edit-form').on('click', function(e) {
        // set the variables
        editing_cat_id = $(this).attr('id').substring(6);
        editing_catname = $(this).attr('name');
        $('#staticBackdropLabel-edit').text('Editando categoría: "'+editing_catname+'"');
            // $('#category-name').empty();
            // $("#update-cat-name").val(editing_catname);
            var formData = new FormData();
            formData.append("cat_id", editing_cat_id);
            $.ajax({
                url: location.origin+'/dashboard/admin/gallery/retrieve_category_image.php', // this is the target
                type: 'post', // method
                dataType: 'text',
                cache: false,
                data: formData, // pass the input value to server
                processData: false,  // tell not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: function(response) { // if the http response code is 200
                    // alert(response);
                    $("#update-cat-image-preview").attr("src", response);
                    $("#update-cat-image-preview-div").removeAttr("hidden");
                },
                error: function(response) { // if the http response code is other than 200
                    alert(response);
                }
            });
        $('#edit-cat').modal().show();
    });

    // Showing deletion form.
    $(".cat-delete").on('click', function(e) {
        editing_cat_id = $(this).attr('id').substring(6);
        editing_catname = $(this).attr('name');
        $('#staticBackdropLabel-delete').text('Eliminando categoría: "'+editing_catname+'"');
        $('#delete-cat').modal().show();
    });

    // Showing creating form
    $("#create-cat").on('click', function(e) {
        $('#new-cat').modal().show();
    });

    // $("#cancel-cat-create, #close-edit-cat").on("click", function(e) {
    //     $("#new-cat-name").val("");
    // });

    // Cancelling or closing the edition of a category. Resetting form.
    $('#cancel-cat-edit, #close-cat-edit').on('click', function(e) {
        $('#update-cat-name').css("background-color", "#FFF");
        $('#update-cat-image').css("background-color", "#FFF");
        $('#update-cat-name').val("");
        $('#update-cat-image').val("");
        $("#update-new-cat-image-preview-div").attr("hidden", "");
        $("#update-new-cat-image-name").html("Escoger fichero...");
        $("#change-edit-name-chkbx").prop("checked", false);
        $("#change-edit-image-chkbx").prop("checked", false);
        $("#cat-edit").attr("disabled");
    });

    // Cancelling or closing the creation of a category. Resetting form.
    $('#cancel-cat-create, #close-cat-create').on('click', function(e) {
        $('#new-cat-name').css("background-color", "#FFF");
        $('#new-cat-image').css("background-color", "#FFF");
        $('#new-cat-name').val("");
        $('#new-cat-image').val("");
        $("#new-cat-image-preview-div").attr("hidden", "");
        $("#new-cat-image-preview").attr("src", "");
        $("#new-cat-image-name").html("Escoger fichero...");
    });

    // Changing category status - enabled/disabled.
    $('.cat-status-change-form').on('click', function(e) {
        // Getting category info.
        editing_cat_id = $(this).attr('id');
        editing_catname = $(this).attr('name');

        // Setting action text.
        action_title = 'Habilitando';
        action_info = 'habilitar';
        if ($('#'+editing_cat_id+'_cat_status').text().trim() == 'Habilitada') {
            action_title = 'Desabilitando';
            action_info = 'deshabilitar';
        };
        $('#staticBackdropLabel-statuschange').text(action_title+' categoría: "'+editing_catname+'"');
        var text = '¿Estás seguro de que quieres '+action_info+' esta categoría?';
        if (action_info == "deshabilitar") {
            text = text + " Si la deshabilitas, no se borrará, pero dejará de estar visible en la galería hasta que la habilites de nuevo.";
        } else {
            text = text + " Si la habilitas, volverá a estar visible de nuevo en la galería.";
        }
        $('#statuschange_modal_info_text').text(text);
        $('#cat-status-change').modal().show(); //Showing modal on top of website content.
    });

    // Getting new category image URL and setting a preview.
    $("#update-new-cat-image").on("change", function(e) {
        if ($(this).val() != "") {
            var fileName = $(this).val().substring(12);
            console.log(fileName);
            $('#update-new-cat-image-name').html(fileName);
            readURL(this, $("#update-new-cat-image-preview"));
            $("#update-new-cat-image-preview-div").prop("hidden", false);  
        } else {
            $('#cat-edit').attr('disabled', 'disabled');
            $("#update-new-cat-image-name").html("Escoger fichero...");
            $("#update-new-cat-image-preview-div").prop("hidden", true);
        }
        enableEditFormBtn();
    });

    // Getting current category image URL and setting a preview.
    $("#new-cat-image").on("change", function(e) {
        if ($(this).prop("files")[0]) {
            var fileName = $(this).val().substring(12);
            console.log(fileName.substring(12));
            $('#new-cat-image-name').html(fileName);
            $('#new-cat-image-preview-div').removeAttr("hidden");
            readURL(this, $("#new-cat-image-preview"));
            $("#new-cat-image-preview-div").prop("hidden", false);
        } else {
            // $('#cat-create').attr('disabled', 'disabled');
            $('#new-cat-image-preview-div').attr("hidden","true");
            $('#new-cat-image-name').html("Seleccionar imagen...");
        }
        enableCreateFormBtn();
    });

    // Changing name of the category.
    $("#change-edit-name-chkbx").on("change", function(e){
        if ($(this).is(":checked")) {
            $("#edit-change-name").removeClass("disabled-form");
            if ($("#update-cat-name").val() != "") {
                $.ajax({
                    url: 'admin/gallery/check_category_name.php', // this is the target
                    method: 'post', // method
                    data: {cat_name: $("#update-cat-name").val()}, // pass the input value to server
                    success: function(r) { // if the http response code is 200
                        $("#update-cat-name").css('background-color', '#A7F0A9');
                        console.log('category does not exist.');
                        $('#cat-edit').prop("disabled", false);
                    },
                    error: function(r) { // if the http response code is other than 200
                        $("#update-cat-name").css('background-color', '#FF9696');
                        console.log('category exists.');
                        $('#cat-edit').prop("disabled", true);
                    }
                });
            }
        } else {
            $("#edit-change-name").addClass("disabled-form");
        }
        enableEditFormBtn();
    });

    // Enabled image change form if selected. Disabling if not.
    $("#change-edit-image-chkbx").on("change", function(e){
        if ($(this).is(":checked")) {
            $("#edit-change-image").removeClass("disabled-form");
        } else {
            $("#edit-change-image").addClass("disabled-form");
        }
        enableEditFormBtn();
    });

    // Reload page with new sorting order.
    $('#result-order').on('change', function(e) {
        value = $(this).children("option:selected").val();
        console.log(value);
        switch(value) {
            case "asc":
                window.location = "?page=categories&order=asc";
                break;
            case "desc":
                window.location = "?page=categories&order=desc";
                break;
            case "enabled":
                window.location = "?page=categories&order=enabled";
                break;
            case "disabled":
                window.location = "?page=categories&order=disabled";
                break;
        }
    });

});