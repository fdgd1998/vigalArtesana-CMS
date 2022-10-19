editing_cat_id = 0;
editing_catname = '';

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

$('.cat-edit-form').on('click', function(e) {
    editing_cat_id = $(this).attr('id').substring(6);
    window.location = location.origin+"/dashboard?page=edit-category&id="+$(this).attr('id').substring(6);
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
    // $('#new-cat').modal().show();
    window.location = location.origin+"/dashboard?page=new-category";
});

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