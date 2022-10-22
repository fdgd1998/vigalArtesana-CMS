$('#cat-create').on('click', function(e) {
    ShowSpinnerOverlay("Creando categoría...");
    // perform an ajax call
    var formData = new FormData();
    formData.append("cat_name", $("#new-cat-name").val());
    formData.append("cat_desc", $("#cat-desc").summernote("code"));
    formData.append("file", $("#new-cat-image").prop("files")[0]);
    console.log($("#cat-desc").summernote("code"));

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
    var formData = new FormData();
    formData.append("cat_id", $(this).attr("catid"));
    if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
        formData.append("cat_name", $("#update-cat-name").val());
    } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
        formData.append("cat_file", $("#update-cat-image").prop("files")[0]);
    } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":checked")) {
        formData.append("cat_desc", $("#cat-desc").summernote("code"));
    } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":not(:checked)")) {
        formData.append("cat_name", $("#update-cat-name").val());
        formData.append("cat_file", $("#update-cat-image").prop("files")[0]);
    } else if ($("#change-edit-name-chkbx").is(":not(:checked)") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":checked")) {
        formData.append("cat_file", $("#update-cat-image").prop("files")[0]);
        formData.append("cat_desc", $("#cat-desc").summernote("code"));
    } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-desc-chkbx").is(":checked")) {
        formData.append("cat_name", $("#update-cat-name").val());
        formData.append("cat_desc", $("#cat-desc").summernote("code"));
    } else if ($("#change-edit-name-chkbx").is(":checked") && $("#change-edit-image-chkbx").is(":checked") && $("#change-edit-desc-chkbx").is(":checked")) {
        formData.append("cat_name", $("#update-cat-name").val());
        formData.append("cat_file", $("#update-cat-image").prop("files")[0]);
        formData.append("cat_desc", $("#cat-desc").summernote("code"));
    } 

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

// Enable submit button of the create form.
function enableCreateFormBtn() {
    var total_inputs = 0;
    if ($('#new-cat-name').val() != "" && $("#new-cat-name").css('background-color') != 'rgb(255, 150, 150)') total_inputs++;
    if ($('#new-cat-image').val() != "") total_inputs++;
    if ($('#new-cat-desc').summernote('code') != "") total_inputs++;
    console.log("color:"+$("#new-cat-name").css('background-color'));
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
    if ($("#update-cat-image").prop("files")[0]) {
        return true;
    } else {
        return false;
    }
}

function isDescEditValid() {
    if ($('#cat-desc').summernote('code') != "") {
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
    console.log("enabling editing button...");
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
}

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
            },
            error: function(r) { // if the http response code is other than 200
                $("#new-cat-name").css('background-color', '#FF9696');
                enableCreateFormBtn();
                console.log('category exists.');
            }
        });
    } else {
        $("#new-cat-name").css('background-color', '#FFF');
        enableCreateFormBtn();
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
            },
            error: function(r) { // if the http response code is other than 200
                $("#update-cat-name").css('background-color', '#FF9696');
                console.log('category exists.');
                enableEditFormBtn();
            }
        })
    } else {
        $("#update-cat-name").css('background-color', '#FFF');
        enableEditFormBtn();
    }    
});

$("#new-cat-desc").on("keyup", function() {
    enableCreateFormBtn();
});

$("#update-cat-desc").on("keyup", function() {
    enableEditFormBtn();
});

$("#update-cat-image").on("change", function(e) {
    var input = this;
    var cat_file_blob = $(this).prop("files")[0];
    if (cat_file_blob) {
        var formData = new FormData();
        formData.append("filenames", cat_file_blob.name);
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
                if (!existentFile) {
                    if (cat_file_blob.size < 2097152) {
                        // var cat_file_blob = $(this).val().substring(12);
                        console.log(cat_file_blob.size);
                        $('#update-cat-image-name').html(cat_file_blob.name);
                        readURL(input, $("#update-cat-image-preview"));
                        $("#update-cat-image-preview-div").prop("hidden", false);  
                    } else {
                        alert("El tamaño de la foto supera los 2 MB. Selecciona otro fichero.")
                        $("#update-cat-image-name").html("Seleccionar imagen...");
                        $("#update-cat-image-preview").prop("src", "../includes/img/placeholder-image.jpg");   
                        $("#update-cat-image").val("");

                    }
                }
            },
            error: function(response) { 
                $("#update-cat-image-name").html("Seleccionar imagen...");
                $("#update-cat-image-preview").prop("src", "../includes/img/placeholder-image.jpg"); 
                $("#update-cat-image").val("");
                alert("El fichero " + cat_file_blob.name + " ya existe en el servidor. Renómbralo e inténtalo de nuevo.");
            }
        // if (!CheckImageSize($(this).prop("files")[0], 2097152)) {
            
        //     var fileName = $(this).val().substring(12);
        //     console.log(fileName);
        //     $('#cat-image-name').html(fileName);
        //     readURL(this, $("#cat-image-preview"));
        //     $("#cat-image-preview-div").prop("hidden", false);  
        // } else {
        //     $(this).val('');   
        });
    } else {
        $('#cat-edit').attr('disabled', 'disabled');
        $("#update-cat-image-name").html("Escoger fichero...");
        // $("#cat-image-preview-div").prop("hidden", true);
        $("#update-cat-image-preview").prop("src", "../includes/img/placeholder-image.jpg"); 
    }
    enableEditFormBtn();
});

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
                if (!existentFile) {
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
        $('#new-cat-image-preview-div').attr("hidden","true");
        $('#new-cat-image-name').html("Seleccionar imagen...");
    }
    enableCreateFormBtn();
});

$("#change-edit-name-chkbx").on("change", function(e){
    if ($(this).is(":checked")) {
        $("#edit-change-name").removeClass("disabled-form");
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

$("#cancel-btn").on("click", function() {
    window.location = location.origin + "/dashboard?page=categories";
});