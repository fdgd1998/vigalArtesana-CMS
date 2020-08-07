var editing_post_id = 0;
jQuery(function($) {

    // Showing delete options on button click.
    $(".post-delete").on('click', function(e) {
        editing_post_id = $(this).attr('id').substring(7);
        $('#staticBackdropLabel-delete').text('Eliminando post: "'+ $(this).attr('name') +'"');
        $('#delete-post').modal().show(); // Showing the modal window on top of the page content.
    });

    $("#post-delete").on('click', function(e) {
        // Sending AJAX request to the server for deleting the post.
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/delete_post.php',
            method: 'post',
            data: {post_id: editing_post_id}, // Data to send.
            success: function(response) { // HTTP response code 200
                alert(response);
                window.location = location.origin+"/dashboard/?page=list-posts&order=asc"; // Reloading page on success.
            },
            error: function(r) { // HTTP responde code != than 200.
                alert(response);
            }
        });
    });

    $('.post-status-change-form').on('click', function(e) {
        // Setting action messages depending on post's current status.
        editing_post_id = $(this).attr('id').substring(7);
        action_title = 'Habilitando';
        action_info = 'habilitar';
        if ($('#postid-'+editing_post_id+'_status').text().trim() == 'Sí') {
            action_title = 'Desabilitando';
            action_info = 'deshabilitar';
        };
        $('#staticBackdropLabel-statuschange').text(action_title+' post: "'+$(this).attr('name')+'"');
        $('#statuschange_modal_info_text').text('¿Estás seguro de que quieres '+action_info+' este post?');
        $('#post-status-change').modal().show(); // Showing the modal window on top of the page content.
    });

    // Refreshing page applying new category order on selection change.
    $("#category-order").on("change", function(e) {
        var category = $("#category-order option:selected").val();
        var destination = "?page=list-posts&order=asc";
        destination += "&category="+category;
        window.location = destination;
    });

    //Editing post button
    $(".post-edit-form").on("click", function(e) {
        window.location = location.origin+"/dashboard/?page=create-post&action=edit&id="+$(this).attr('id').substring(7).trim();
    });

    // Refreshing page applying new sort order on selection change.
    $('#result-order').on('change', function(e) {
        var value = $(this).children("option:selected").val(); // Getting selected value.
        var destination = "?page=list-posts&order=";
        $("#category-order").prop("hidden", true);
        if (value != "bycategory") {
            switch(value) {
                case "asc":
                    destination += "asc";
                    break;
                case "desc":
                    destination += "desc";
                    break;
                case "published":
                    destination += "published";
                    break;
                case "notpublished":
                    destination += "notpublished";
                    break;
            }
            window.location = destination;
        } else {
            $("#category-order").prop("hidden", false);
            window.location = destination + "asc&category=" + $("#category-order option:selected").val();
        }
    });
});