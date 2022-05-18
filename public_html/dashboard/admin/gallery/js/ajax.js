editing_cat_id = 0;
editing_catname = '';

// Enable submit button of the create form.
function enableCreateFormBtn() {
    var total_inputs = 0;
    if ($('#new-cat-name').val() != "" && $("#new-cat-name").css('background-color') != 'rgb(255, 150, 150)') total_inputs++;
    if ($('#new-cat-image').val() != "") total_inputs++;
    console.log($("#new-cat-name").css('background-color'));
    if (total_inputs == 2) $('#cat-create').removeAttr('disabled');
    else $('#cat-create').attr('disabled', 'disabled');
}

// Enable submit button of the edit form.
function enableEditFormBtn() {
    if ($("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-name-chkbx").is(":not(:checked)")) {
        $('#cat-edit').prop("disabled", true);
    }
    if ($("#change-edit-image-chkbx").is(":checked")) {
        if ($("#update-new-cat-image").prop("files")[0]) {
            $('#cat-edit').prop("disabled", false);
            if ($("#change-edit-name-chkbx").is(":checked")) {
                if ($("#update-cat-name").css('background-color') == 'rgb(255, 150, 150)' || $.trim($("#update-cat-name").val()) == "") {
                    $('#cat-edit').prop("disabled", true);
                }
            }
        } else {
            $('#cat-edit').prop("disabled", true);
        }
    } else if ($("#change-edit-image-chkbx").is(":not(:checked)")) {
        if ($("#change-edit-name-chkbx").is(":checked")) {
            if ($("#update-cat-name").css('background-color') == 'rgb(255, 150, 150)' || $.trim($("#update-cat-name").val()) == "") {
                $('#cat-edit').prop("disabled", true);
            } else {
                $('#cat-edit').prop("disabled", false);
            }
        }
    }
}

jQuery(function($) {
    $('#cat-create').on('click', function(e) {
        ShowSpinnerOverlay("Creando categoría...");
        // perform an ajax call
        var formData = new FormData();
        formData.append("cat_name", $("#new-cat-name").val());
        formData.append("file", $("#new-cat-image").prop("files")[0]);
        $.ajax({
            url: location.origin+'/dashboard/admin/gallery/create_category.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                //alert(response);
                window.location = location.origin+"/dashboard/?page=categories&order=asc";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                HideSpinner();
            }
        });
    });

    $('#cat-edit').on('click', function(e) {
        ShowSpinnerOverlay("Editando categoría...");
        // perform an ajax call
        var formData = new FormData();
        formData.append("cat_id", editing_cat_id);
        if ($("#change-edit-image-chkbx").is(":checked") && $("#change-edit-name-chkbx").is(":checked")) {
            formData.append("cat_name", $("#update-cat-name").val());
            formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
        } else if ($("#change-edit-image-chkbx").is(":checked") && $("#change-edit-name-chkbx").is(":not(:checked)")) {
            formData.append("cat_file", $("#update-new-cat-image").prop("files")[0]);
        } else if ($("#change-edit-image-chkbx").is(":not(:checked)") && $("#change-edit-name-chkbx").is(":checked")) {
            formData.append("cat_name", $("#update-cat-name").val());
        }
        // for(var pair of formData.entries()) {
        //     console.log(pair[0]+ ', '+ pair[1]); 
        //  }
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
                //alert(response);
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
                    // console.log('category does not exist.');
                },
                error: function(r) { // if the http response code is other than 200
                    $("#new-cat-name").css('background-color', '#FF9696');
                    enableCreateFormBtn();
                    console.log('category exists.');
                    // $('#cat-create').attr('disabled', 'disabled');
                }
            });
        }
        
    });

    
    $('#update-cat-name').on('keyup', function(e) {
        if ($.trim($(this).val()) != "") {
            // perform an ajax call
            $.ajax({
                url: 'admin/gallery/check_category_name.php', // this is the target
                method: 'post', // method
                data: {cat_name: $.trim($(this).val())}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $("#update-cat-name").css('background-color', '#A7F0A9');
                    enableEditFormBtn();
                    console.log('category does not exist.');
                    if ($("#change-edit-image-chkbx").is(":checked")) {
                        if ($("#update-new-cat-image-name").text() == "Seleccionar imagen...") {
                            // $('#cat-edit').prop("disabled", true);
                        }
                    }
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