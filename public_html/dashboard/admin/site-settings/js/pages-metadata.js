var page_id = 0;

$("li > a[class=metadata-edit]").on("click", function() {
    page_id = $(this).attr("id").substr(7);
    $.ajax({
        url: location.origin+'/dashboard/admin/site-settings/get_page_metadata.php', // this is the target
        method: 'post', // method
        data: {id: page_id}, // pass the input value to server
        success: function(response) { // if the http response code is 200
            var metadata = JSON.parse(response);
            $('#page-title').val(metadata[0]);
            $('#page-desc').val(metadata[1]);
            console.log("editando categoria "+page_id);
            $("#page-edit").modal().show()
            $("#page-edit-title").text("Editando página " + $(this).text());
            
        },
        error: function(response) { // if the http response code is other than 200
            alert("Ha ocurrido un error al recuperar los datos.");
        }
    });     
    
})

$("#page-edit-btn").on("click", function() {
    $.ajax({
        url: location.origin+'/dashboard/admin/site-settings/update_pages_metadata.php', // this is the target
        method: 'post', // method
        data: {id: page_id, title: $('#page-title').val(), desc: $('#page-desc').val()}, // pass the input value to server
        success: function(response) { // if the http response code is 200
            alert(response);
            window.location = location.origin + "/dashboard?page=metadata-settings";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });     
    
})

$("#page-title, #page-desc").on("keyup", function() {
    enableEditBtn();
})

function enableEditBtn() {
    if ($("#page-title").val() != "" && $("#page-desc").val() != "") 
        $("#page-edit-btn").removeAttr("disabled");
    else $("#page-edit-btn").attr("disabled", true);
}

$("#page-edit-close, #cancel-page-edit").on("click", function() {
    $("#page-title").val("");
    $("#page-desc").val("");
    $("#page-edit-btn").attr("disabled", true);
})