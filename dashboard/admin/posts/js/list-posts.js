jQuery(function($) {

    // Showing delete options on button click.
    $(".post-delete").on('click', function(e) {
        $('#staticBackdropLabel-delete').text('Eliminando post: "'+ $(this).attr('name')+'"');
        $('#delete-post').modal().show(); // Showing the modal window on top of the page content.
    });

    $("#post-delete").on('click', function(e) {
        // Sending AJAX request to the server for deleting the post.
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/delete_post.php',
            method: 'post',
            data: {post_id: $(this).attr('id').substring(7)}, // Data to send.
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
        action_title = 'Habilitando';
        action_info = 'habilitar';
        if ($('#postid-'+$(this).attr('id').substring(7)+'_status').text().trim() == 'Sí') {
            action_title = 'Desabilitando';
            action_info = 'deshabilitar';
        };
        $('#staticBackdropLabel-statuschange').text(action_title+' post: "'+$(this).attr('name')+'"');
        $('#statuschange_modal_info_text').text('¿Estás seguro de que quieres '+action_info+' este post?');
        $('#post-status-change').modal().show(); // Showing the modal window on top of the page content.
    });


    // Refreshing page applying new sort order on selection change.
    $('#result-order').on('change', function(e) {
        value = $(this).children("option:selected").val(); // Getting selected value.
        // $destination = "?page=list-posts&order=";
        switch(value) {
            case "asc":
                window.location = "?page=list-posts&order=asc";
                break;
            case "desc":
                window.location = "?page=list-posts&order=desc";
                break;
            case "published":
                window.location = "?page=list-posts&order=published";
                break;
            case "notpublished":
                window.location = "?page=list-posts&order=notpublished";
                break;
        }

        /* to be applied...
        if (category_is_selected) {
            $destination += &category=category_id;
        }
        window.location = $destination;
        */
    });
});