
jQuery(function($) {
    $('.cat-edit-form').on('click', function(e) {
        // set the variables
        editing_cat_id = $(this).attr('id').substring(6);
        editing_catname = $(this).attr('name');
        $('#staticBackdropLabel-edit').text('Editando categoría '+editing_catname);
            $('#category-name').empty();
            label = $('<label for="update-cat-name">Nombre: </label>');
            input = $('<input class="form-control" name="update-cat-name" id="update-cat-name" value="'+editing_catname+'"></input>');
            $('#category-name').append(label);
            $('#category-name').append(input);
            var formData = new FormData();
            formData.append("cat_id", editing_cat_id);
            $.ajax({
                url: location.origin+'/dashboard/admin/posts/retrieve_category_image.php', // this is the target
                type: 'post', // method
                dataType: 'text',
                cache: false,
                data: formData, // pass the input value to serve
                processData: false,  // tell jQuery not to process the data
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

    $(".cat-delete").on('click', function(e) {
        editing_cat_id = $(this).attr('id').substring(6);
        editing_catname = $(this).attr('name');
        $('#staticBackdropLabel-delete').text('Eliminando categoría '+editing_catname);
        $('#delete-cat').modal().show();
    });

    $("#create-cat").on('click', function(e) {
        $('#new-cat').modal().show();
    });

    $("#cancel-cat-create, #close-edit-cat").on("click", function(e) {
        $("#new-cat-name").val("");
    });

    $('#cancel-cat-edit, #close-cat-edit').on('click', function(e) {
        $('#update-cat-name').css("background-color", "#FFF");
        $('#update-cat-image').css("background-color", "#FFF");
        $('#update-cat-name').val("");
        $('#update-cat-image').val("");
        $("#update-new-cat-image-preview-div").attr("hidden", "");

    });

    $('#cancel-cat-create, #close-cat-create').on('click', function(e) {
        $('#new-cat-name').css("background-color", "#FFF");
        $('#new-cat-image').css("background-color", "#FFF");
        $('#new-cat-name').val("");
        $('#new-cat-image').val("");
        $("#new-cat-image-preview-div").attr("hidden", "");
        $("#new-cat-image-preview").attr("src", "");
    });

    $('.cat-status-change-form').on('click', function(e) {
        // set the variables
        editing_cat_id = $(this).attr('id');
        editing_catname = $(this).attr('name');
        action_title = 'Habilitando';
        action_info = 'habilitar';
        if ($('#'+editing_cat_id+'_cat_status').text().trim() == 'Habilitada') {
            action_title = 'Desabilitando';
            action_info = 'deshabilitar';
        };
        $('#staticBackdropLabel-statuschange').text(action_title+' categoría '+editing_catname);
        $('#statuschange_modal_info_text').text('¿Estás seguro de que quieres '+action_info+' esta categoría?');
        $('#cat-status-change').modal().show();
    });

    $("#update-cat-image").on("change", function(e) {
        if ($("#udpate-cat-image").val() != "") {
            // $('#cat-create').removeAttr('disabled');
            readURL(this, "#update-new-cat-image-preview");
            $("#update-new-cat-image-preview-div").removeAttr("hidden");
            enableCreateFormBtn();
        } else {
            $('#cat-edit').attr('disabled', 'disabled');
        }
    });

    $("#new-cat-image").on("change", function(e) {
        if ($("#new-cat-image").val() != "") {
            // $('#cat-create').removeAttr('disabled');
            readURL(this, "#new-cat-image-preview");
            $("#new-cat-image-preview-div").removeAttr("hidden");
            enableCreateFormBtn();
        } else {
            $('#cat-create').attr('disabled', 'disabled');
        }
    });

    function readURL(input, selector) {
        console.log(input);
        console.log(selector);
        console.log(input.files[0]);
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function(e) {
            $(selector).attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

});