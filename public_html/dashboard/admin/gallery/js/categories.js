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
            window.location = location.origin+"/dashboard/?page=categories";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
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

// Reload page with new sorting order.
$('#result-order').on('change', function(e) {
    value = $(this).children("option:selected").val();
    console.log(value);
    window.location = "?page=categories";
});