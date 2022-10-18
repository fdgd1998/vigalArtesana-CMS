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
        var items = $(document).find(".delete-selected").length;
        if (items > 0) {
            if ($(document).find("#delete-images").length == 0) {
                $(".gallery-manage").before("\
                    <div class='container text-right'>\
                        <div class='button-group'>\
                            <button type='button' id='delete-images' class='btn my-button-2 float-right'><i class='far fa-trash-alt'></i>Borrar</button>\
                        </div>\
                    </div>");
            }
        } else {
            $("#delete-images").parent().remove();
        }
    })

    $(document).on("click", "#delete-images", function() {
        var filenames = {};
        var directories = {};
        $(document).find(".delete-selected > img").each(function(i) {
            filenames[i] = $(this).attr("id");
            directories[i] = $(this).attr("dir");
        });
        console.log(JSON.stringify(filenames));
        console.log(JSON.stringify(directories));
        $.ajax({
            url: './admin/gallery/delete_images.php',
            method: 'post',
            data: {
                filenames: JSON.stringify(filenames),
                directories: JSON.stringify(directories)
            }, // Data to send.
            success: function(response) { // HTTP response code 200
                alert(response);
                window.location = location.origin+"/dashboard/?page=manage-gallery"; // Reloading page on success.
            },
            error: function(response) { // HTTP responde code != than 200.
                alert(response);
            }
        });
    });
});