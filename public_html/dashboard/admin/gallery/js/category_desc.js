
function enableEditBtn(code) {
    if (code != "") $("#submit").removeAttr("disabled");
    else $("#submit").attr("disabled", true);
}

$("#submit").on("click", function() {
    var formdata = new FormData();
    formdata.append("desc", $("#gallery-desc").summernote("code"));
    for (var pair of formdata.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }
    $.ajax({
        url: location.origin+'/dashboard/admin/gallery/update_gallery_desc.php', // this is the target
        type: 'post', // method
        dataType: 'text',
        cache: false,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        data: formdata, // pass the input value to server
        success: function(response) { // if the http response code is 200
            alert(response);
            window.location = location.origin+"/dashboard/?page=gallery-desc";
        },
        error: function(response) { // if the http response code is other than 200
            alert(response);
        }
    });
})