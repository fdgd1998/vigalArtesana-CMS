editing_cat_id = 0;
editing_catname = '';
function enableCreateFormBtn() {
    var total_inputs = 0;
    if ($('#new-cat-name').val() != "") total_inputs++;
    if ($('#new-cat-image').val() != "") total_inputs++;
    if (total_inputs == 2) $('#cat-create').removeAttr('disabled');
    else $('#cat-create').attr('disabled', 'disabled');
};

function enableEditFormBtn() {
    var total_inputs = 0;
    if ($('#update-cat-name').val() != "") total_inputs++;
    if ($('#update-cat-image').val() != "") total_inputs++;
    if (total_inputs == 2) $('#cat-edit').removeAttr('disabled');
    else $('#cat-edit').attr('disabled', 'disabled');
};

jQuery(function($) {
    $('#cat-create').on('click', function(e) {
        // perform an ajax call
        var formData = new FormData();
        formData.append("cat_name", $("#new-cat-name").val());
        formData.append("file", $("#new-cat-image").prop("files")[0]);
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/create_category.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                $('.modal-backdrop').remove();
                alert(response);
                window.location = location.origin+"/dashboard/?page=categories";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });

    $('#cat-edit').on('click', function(e) {
        // perform an ajax call
        var formData = new FormData();
        formData.append("cat_name", $("#update-cat-name").val());
        formData.append("file", $("#update-cat-image").prop("files")[0]);
        formData.append("cat_id", editing_cat_id);
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/edit_category.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                $('.modal-backdrop').remove();
                alert(response);
                window.location = location.origin+"/dashboard/?page=categories";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });

    $('#cat-delete').on('click', function(e) {
        // perform an ajax call
        var formData = new FormData();
        alert(editing_cat_id);
        formData.append("cat_id", editing_cat_id);
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/delete_category.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                $('.modal-backdrop').remove();
                alert(response);
                window.location = location.origin+"/dashboard/?page=categories";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });

    $('#new-cat-name').on('keyup', function(e) {
        if ($(this).val() != "") {
            // perform an ajax call
            $.ajax({
                url: 'admin/posts/check_category_name.php', // this is the target
                method: 'post', // method
                data: {cat_name: $(this).val()}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $("#new-cat-name").css('background-color', '#A7F0A9').html(r);
                    console.log('category does not exist.');
                },
                error: function(r) { // if the http response code is other than 200
                    $("#new-cat-name").css('background-color', '#FF9696').html(r);
                    console.log('category exists.');
                    $('#cat-create').attr('disabled', 'disabled');
                }
            });
        }
        enableCreateFormBtn();
    });

    $('#update-cat-name').on('keyup', function(e) {
        if ($(this).val() != "") {
            // perform an ajax call
            $.ajax({
                url: 'admin/posts/check_category_name.php', // this is the target
                method: 'post', // method
                data: {cat_name: $(this).val()}, // pass the input value to server
                success: function(r) { // if the http response code is 200
                    $("#update-cat-name").css('background-color', '#A7F0A9').html(r);
                    console.log('category does not exist.');
                },
                error: function(r) { // if the http response code is other than 200
                    $("#update-cat-name").css('background-color', '#FF9696').html(r);
                    console.log('category exists.');
                    $('#cat-edit').attr('disabled', 'disabled');
                }
            });
        }
        enableEditFormBtn();
    });

    $("#cat-statuschange").on('click', function(e) {
        disable = 'YES';
        if ($('#'+editing_cat_id+'_cat_status').text().trim() == 'Habilitada') {
            console.log("la categoria sera deshabilitada");
            disable = 'NO';
        }
        cat_id = editing_cat_id.substring(6);
        console.log("category id: "+cat_id);
        console.log("category status: "+disable);
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/change_category_status.php', // this is the target
            method: 'post', // method
            data: {id: cat_id, status: disable}, // pass the input value to server
            success: function(r) { // if the http response code is 200
                //alert("El estado del usuario se ha actualizado correctamente.");
                $('#catid-'+cat_id+'-change-status-btn').clas
                $('#cat-status-change').modal().hide();
                $('.modal-backdrop').remove();
                editing_cat_name = '';
                editing_cat_id = '';
                window.location = location.origin+"/dashboard/?page=categories";
            },
            error: function(r) { // if the http response code is other than 200
                alert("Ha ocurrido un error al actualizar el estado de la categoría.");
            }
        });        
    });
});