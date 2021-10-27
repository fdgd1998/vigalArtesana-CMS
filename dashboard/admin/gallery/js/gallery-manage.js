var editing_post_id = 0;
jQuery(function($) {

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

    $(".gallery-item").on("click", function() {
        $(this).toggleClass("delete-selected");
        if ($(document).find(".delete-selected").length > 0) {
            if ($(document).find("#delete-images").length == 0)
                $(".gallery-manage").before("<div class='container'><button type='button' id='delete-images' style='margin-bottom: 20px; margin-right: 35px;' class='btn my-button float-right'><i class='far fa-trash-alt'></i>Borrar</button></div>");
        } else {
            $("#delete-images").parent().remove();
        }
    })

    $(document).on("click", "#delete-images", function() {
        var filenames = {};
        $(document).find(".delete-selected > img").each(function(i) {
            
            filenames[i] = this.id;
        });
        console.log(JSON.stringify(filenames));
        $.ajax({
            url: location.origin+'/dashboard/admin/gallery/delete_images.php',
            method: 'post',
            data: {filenames: JSON.stringify(filenames)}, // Data to send.
            success: function(response) { // HTTP response code 200
                alert(response);
                window.location = location.origin+"/dashboard/?page=manage-gallery"; // Reloading page on success.
            },
            error: function(r) { // HTTP responde code != than 200.
                alert(response);
            }
        });
    });
});