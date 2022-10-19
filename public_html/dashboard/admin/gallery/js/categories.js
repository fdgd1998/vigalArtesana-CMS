editing_cat_id = 0;
editing_catname = '';

// Enable submit button of the create form.
function enableCreateFormBtn() {
    var total_inputs = 0;
    if ($('#new-cat-name').val() != "" && $("#new-cat-name").css('background-color') != 'rgb(255, 150, 150)') total_inputs++;
    if ($('#new-cat-image').val() != "") total_inputs++;
    if ($('#new-cat-desc').val() != "") total_inputs++;
    console.log($("#new-cat-name").css('background-color'));
    if (total_inputs == 3) $('#cat-create').removeAttr('disabled');
    else $('#cat-create').attr('disabled', 'disabled');
}
 

function isNameEditValid() {
    console.log($("#update-cat-name").css('background-color'))
    if ($("#update-cat-name").css('background-color') == "rgb(255, 150, 150)") {
        return false;
    } else if ( $("#update-cat-name").css('background-color') == "rgb(167, 240, 169)") {
        return true;
    }
    return false;
}

function isImageEditValid() {
    if ($("#update-new-cat-image").prop("files")[0]) {
        return true;
    } else {
        return false;
    }
}

function isDescEditValid() {
    if ($.trim($("#update-cat-desc").val()) != "") {
        return true;
    } else {
        return false;
    }
}

function enableEditBtn(action) {
    if (action) 
        $('#cat-edit').prop("disabled", false);
    else 
        $('#cat-edit').prop("disabled", true);
}
// Enable submit button of the edit form.
function enableEditFormBtn() {
    if ($("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
        $('#cat-edit').prop("disabled", true);
    } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
        if (isNameEditValid()) enableEditBtn(true);
        else enableEditBtn(false);
    } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
        if (isImageEditValid()) enableEditBtn(true);
        else enableEditBtn(false);
    } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":checked")) {
        if (isDescEditValid()) enableEditBtn(true);
        else enableEditBtn(false);
    } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
        if (isNameEditValid() && isImageEditValid()) enableEditBtn(true);
        else enableEditBtn(false);
    } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":checked")) {
        if (isImageEditValid() && isDescEditValid()) enableEditBtn(true);
        else enableEditBtn(false);
    } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":checked")) {
        if (isNameEditValid() && isDescEditValid()) enableEditBtn(true);
        else enableEditBtn(false);
    } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":checked")) {
        if (isNameEditValid() && isImageEditValid() && isDescEditValid()) enableEditBtn(true);
        else enableEditBtn(false);
    } 
    // if ($("#change-edit-image-chkbx").is(":checked")) {
    //     if ($("#update-new-cat-image").prop("files")[0]) {
    //         $('#cat-edit').prop("disabled", false);
    //         if ($("#change-edit-name-chkbx").is(":checked")) {
    //             if ($("#update-cat-name").css('background-color') == 'rgb(255, 150, 150)' || $.trim($("#update-cat-name").val()) == "") {
    //                 $('#cat-edit').prop("disabled", true);
    //             }
    //         }
    //     } else {
    //         $('#cat-edit').prop("disabled", true);
    //     }
    // } else if ($("#change-edit-image-chkbx").is(":not(:checked)")) {
    //     if ($("#change-edit-name-chkbx").is(":checked")) {
    //         if ($("#update-cat-name").css('background-color') == 'rgb(255, 150, 150)' || $.trim($("#update-cat-name").val()) == "") {
    //             $('#cat-edit').prop("disabled", true);
    //         } else {
    //             $('#cat-edit').prop("disabled", false);
    //         }
    //     }
    // }
}

jQuery(function($) {
    $('#cat-create').on('click', function(e) {
        ShowSpinnerOverlay("Creando categoría...");
        // perform an ajax call
        var formData = new FormData();
        formData.append("cat_name", $("#new-cat-name").val());
        formData.append("cat_desc", $("#new-cat-desc").val());
        formData.append("file", $("#new-cat-image").prop("files")[0]);

        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }
        $.ajax({
            url: location.origin+'/dashboard/admin/gallery/create_category.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location = location.origin+"/dashboard/?page=categories&order=asc";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                HideSpinner();
            }
        });
    });

    $('#cat-edit').on('click', function(e) {
        // ShowSpinnerOverlay("Editando categoría...");
        // perform an ajax call
        var formData = new FormData();
        formData.append("cat_id", editing_cat_id);
        if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
            formData.append("cat_name", $("#update-cat-name").val());
        } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
            formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
        } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":checked")) {
            formData.append("cat_desc", $("#update-cat-desc").val());
        } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
            formData.append("cat_name", $("#update-cat-name").val());
            formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
        } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":checked")) {
            formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
            formData.append("cat_desc", $("#update-cat-desc").val());
        } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":checked")) {
            formData.append("cat_name", $("#update-cat-name").val());
            formData.append("cat_desc", $("#update-cat-desc").val());
        } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":checked")) {
            formData.append("cat_name", $("#update-cat-name").val());
            formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
            formData.append("cat_desc", $("#update-cat-desc").val());
        } 
        // if ($("#change-edit-image-chkbx").is(":checked") && $("#change-edit-name-chkbx").is(":checked")) {
        //     formData.append("cat_name", $("#update-cat-name").val());
        //     formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
        // } else if ($("#change-edit-image-chkbx").is(":checked") && $("#change-edit-name-chkbx").is(":not(:checked)")) {
        //     formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
        // } else if ($("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-name-chkbx").is(":checked")) {
        //     formData.append("cat_name", $("#update-cat-name").val());
        // }
        for(var pair of formData.entries()) {
            console.log(pair[0]+ ', '+ pair[1]); 
         }
        $.ajax({
            url: location.origin+'/dashboard/admin/gallery/edit_category.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                // $('.modal-backdrop').remove();
                alert(response);
                window.location = location.origin+"/dashboard/?page=categories&order=asc";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                HideSpinner();
            }
        });
    });

    $('#cat-delete').on('click', function(e) {
        ShowSpinnerOverlay("Borrando categoría...");
        // perform an ajax call
        var formData = new FormData();
        formData.append("cat_id", editing_cat_id);
        $.ajax({
            url: location.origin+'/dashboard/admin/gallery/delete_category.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                $('.modal-backdrop').remove();
                alert(response);
                window.location = location.origin+"/dashboard/?page=categories&order=asc";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                HideSpinner();
            }
        });
    });

    $('#new-cat-name').on('keyup', function(e) {
        if ($.trim($(this).val()) != "") {
            // perform an ajax call
            $.ajax({
                url: 'admin/gallery/check_category_name.php', // this is the target
                method: 'post', // method
                data: {cat_name: $.trim($(this).val())}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $("#new-cat-name").css('background-color', '#A7F0A9');
                    enableCreateFormBtn();
                    // enableCreateFormBtn();
                    // console.log('category does not exist.');
                },
                error: function(r) { // if the http response code is other than 200
                    $("#new-cat-name").css('background-color', '#FF9696');
                    enableCreateFormBtn();
                    // enableCreateFormBtn();
                    console.log('category exists.');
                    // $('#cat-create').attr('disabled', 'disabled');
                }
            });
        }
        
    });

    
    $('#update-cat-name').on('keyup', function(e) {
        console.log("editing title...");
        if ($.trim($(this).val()) != "") {
            // perform an ajax call
            $.ajax({
                url: 'admin/gallery/check_category_name.php', // this is the target
                method: 'post', // method
                data: {cat_name: $.trim($(this).val())}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $("#update-cat-name").css('background-color', '#A7F0A9');
                    console.log('category does not exist.');
                    enableEditFormBtn();
                    // if ($("#change-edit-image-chkbx").is(":checked")) {
                    //     if ($("#update-new-cat-image-name").text() == "Seleccionar imagen...") {
                    //         // $('#cat-edit').prop("disabled", true);
                    //     }
                    // }
                },
                error: function(r) { // if the http response code is other than 200
                    $("#update-cat-name").css('background-color', '#FF9696');
                    console.log('category exists.');
                    enableEditFormBtn();
                    // $('#cat-edit').prop("disabled", true);
                }
            })
        } else {
            $("#update-cat-name").css('background-color', '#FFF');
            enableEditFormBtn();
        }
        
    });

    $("#cat-statuschange").on('click', function(e) {
        ShowSpinnerOverlay("Actualizando categoría...");
        disable = 'YES';
        if ($('#'+editing_cat_id+'_cat_status').text().trim() == 'Habilitada') {
            console.log("la categoria sera deshabilitada");
            disable = 'NO';
        }
        cat_id = editing_cat_id.substring(6);
        console.log("category id: "+cat_id);
        console.log("category status: "+disable);
        $.ajax({
            url: location.origin+'/dashboard/admin/gallery/change_category_status.php', // this is the target
            method: 'post', // method
            data: {id: cat_id, status: disable}, // pass the input value to server
            success: function(r) { // if the http response code is 200
                alert(r)
                $('#catid-'+cat_id+'-change-status-btn').clas
                $('#cat-status-change').modal().hide();
                $('.modal-backdrop').remove();
                editing_cat_name = '';
                editing_cat_id = '';
                window.location = location.origin+"/dashboard/?page=categories&order=asc";
            },
            error: function(r) { // if the http response code is other than 200
                alert(r);
                HideSpinner();
            }
        });        
    });
});

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
                alert(response);
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

$("#new-cat-desc").on("keyup", function() {
    enableCreateFormBtn();
});

$("#update-cat-desc").on("keyup", function() {
    enableEditFormBtn();
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
    $('#update-cat-desc').val("");
    $("#update-new-cat-image-preview-div").attr("hidden", "");
    $("#update-new-cat-image-name").html("Escoger fichero...");
    $("#change-edit-name-chkbx").prop("checked", false);
    $("#change-edit-image-chkbx").prop("checked", false);
    $("#change-edit-desc-chkbx").prop("checked", false);
    $("#edit-change-name").addClass("disabled-form");
    $("#edit-change-image").addClass("disabled-form");
    $("#edit-change-desc").addClass("disabled-form");
    $("#cat-edit").attr("disabled");
});

// Cancelling or closing the creation of a category. Resetting form.
$('#cancel-cat-create, #close-cat-create').on('click', function(e) {
    $('#new-cat-name').css("background-color", "#FFF");
    $('#new-cat-image').css("background-color", "#FFF");
    $('#new-cat-name').val("");
    $('#new-cat-image').val("");
    $('#new-cat-desc').val("");
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
    if ($(this).prop("files")[0]) {
        if (!CheckImageSize($(this).prop("files")[0], 2097152)) {
            
            var fileName = $(this).val().substring(12);
            console.log(fileName);
            $('#update-new-cat-image-name').html(fileName);
            readURL(this, $("#update-new-cat-image-preview"));
            $("#update-new-cat-image-preview-div").prop("hidden", false);  
        } else {
            $(this).val('');   
        }
    } else {
        $('#cat-edit').attr('disabled', 'disabled');
        $("#update-new-cat-image-name").html("Escoger fichero...");
        $("#update-new-cat-image-preview-div").prop("hidden", true);
    }
    enableEditFormBtn();
});

// Getting current category image URL and setting a preview.
$("#new-cat-image").on("change", function(e) {
    var cat_file_blob = $(this).prop("files")[0];
    if (cat_file_blob) {
        var cat_filename = $("#new-cat-image")[0].files[0].name;
        console.log(cat_filename);
        var formData = new FormData();
        formData.append("filenames", cat_filename);
        $.ajax({
            url: './admin/gallery/scripts/check_current_category_filenames.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: formData, // pass the input valuse to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                console.log(response);
                var existentFile = response;
                if (existentFile) {
                    
                } else {
                    if (cat_file_blob.size < 2097152) {
                        console.log(cat_file_blob.name);
                        $('#new-cat-image-name').html(cat_file_blob.name);
                        $('#new-cat-image-preview-div').removeAttr("hidden");
                        readURL($("#new-cat-image")[0], $("#new-cat-image-preview"));
                        $("#new-cat-image-preview-div").prop("hidden", false);
                    } else {
                        alert("El tamaño de la foto supera los 2 MB. Selecciona otro fichero.")
                        $("#new-cat-image").html("Seleccionar imagen...");
                        $("#new-cat-image-preview-div").prop("hidden", true);  
                        $("#new-cat-image").val("");

                    }
                }
            },
            error: function(response) { 
                $("#new-cat-image-name").html("Seleccionar imagen...");
                $("#new-cat-image-preview-div").prop("hidden", true);  
                $("#new-cat-image").val("");
                alert("El fichero " + cat_filename + " ya existe en el servidor. Renómbralo e inténtalo de nuevo.");
            }
        });
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
        // if ($("#update-cat-name").val() != "") {
        //     $.ajax({
        //         url: 'admin/gallery/check_category_name.php', // this is the target
        //         method: 'post', // method
        //         data: {cat_name: $("#update-cat-name").val()}, // pass the input value to server
        //         success: function(r) { // if the http response code is 200
        //             $("#update-cat-name").css('background-color', '#A7F0A9');
        //             console.log('category does not exist.');
        //             $('#cat-edit').prop("disabled", false);
        //         },
        //         error: function(r) { // if the http response code is other than 200
        //             $("#update-cat-name").css('background-color', '#FF9696');
        //             console.log('category exists.');
        //             $('#cat-edit').prop("disabled", true);
        //         }
        //     });
        // }
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

$("#change-edit-desc-chkbx").on("change", function(e){
    if ($(this).is(":checked")) {
        $("#edit-change-desc").removeClass("disabled-form");
    } else {
        $("#edit-change-desc").addClass("disabled-form");
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