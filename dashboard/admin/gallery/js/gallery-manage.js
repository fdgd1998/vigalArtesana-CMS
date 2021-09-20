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

    // Refreshing page applying new category order on selection change.
    $("#category-order").on("change", function(e) {
        var category = $("#category-order option:selected").val();
        var destination = "?page=manage-gallery&display=bycategory";
        destination += "&c="+category;
        window.location = destination;
    });

    // Refreshing page applying new sort order on selection change.
    $('#display-order').on('change', function(e) {
        var value = $(this).children("option:selected").val(); // Getting selected value.
        var destination = "?page=manage-gallery&display=";
        $("#category-order").prop("hidden", true);
        if (value != "bycategory") {
            window.location = destination+"all";
        } else {
            $("#category-order").prop("hidden", false);
            window.location = destination + "bycategory&c=" + $("#category-order option:selected").val();
        }
    });
});