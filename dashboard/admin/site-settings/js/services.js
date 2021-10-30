$(document).ready(function() {
    var id = 0;
    function EnableSaveCategoryBtn () {
        var total_inputs = 0;
        if($.trim($("#title").val()) != "") total_inputs++;
        if($.trim($("#description").val()) != "") total_inputs++;
        if($("#image-input").prop("files")[0]) total_inputs++;
        if(total_inputs == 3) $("#new-service-btn").removeAttr("disabled");
        else $("#new-service-btn").attr("disabled","disabled");
    }
    $("#new-service-btn").on("click", function(){
        var formData = new FormData();
        formData.append("title", $("#title").val());
        formData.append("description", $("#description").val());
        formData.append("file", $("#image-input").prop("files")[0]);
        $.ajax({
            url: location.origin+'/dashboard/admin/site-settings/create_service.php', // this is the target
            type: 'post', // method
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location.href = location.origin+"/dashboard/?page=manage-services";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });

    $("#image-input").on("change", function(){
        EnableSaveCategoryBtn ();
        if ($(this).prop("files")[0]) {
            $("#image-preview-div").removeAttr("hidden");
            readURL(this, $("#image-preview"));
            $("#image-input-label").html($(this).prop("files")[0].name);            
        } else {
            $("#image-preview-div").attr("hidden", true);
            $("#image-input-label").html("Selecccionar imagen...");
        }
        
    });

    $("#title, #description").on("keyup", function() {
        EnableSaveCategoryBtn ();
    })

    $(".edit-service").on("click", function(){
        var id = $(this).attr("id").substring(5);
        $.ajax({
            url: location.origin+'/dashboard/admin/site-settings/edit_service.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: {service_id: id.toString()}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location = location.origin+"/dashboard?page=manage-services";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });

    $("#delete-service-btn").on("click", function(){
        console.log("id: "+id);
        $.ajax({
            url: location.origin+'/dashboard/admin/site-settings/delete_service.php', // this is the target
            type: 'POST', // method
            dataType: 'text',
            cache: false,
            data: {service_id: id}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location = location.origin+"/dashboard?page=manage-services";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });

    $(".carousel").carousel({
        interval: false,
        pause: true,
        touch: true,
        keyboard: true
    });

    $(".carousel").carousel('pause');

    $(".delete-service").on('click', function() {
        id = $(this).attr("id").substring(7);
        $('#delete-service-modal').modal().show();
    });

});