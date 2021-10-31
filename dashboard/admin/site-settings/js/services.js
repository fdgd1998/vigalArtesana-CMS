$(document).ready(function() {
    var id = 0;
    function EnableSaveCategoryBtn () {
        var total_inputs = 0;
        if($.trim($("#title-new").val()) != "") total_inputs++;
        if($.trim($("#description-new").val()) != "") total_inputs++;
        if($("#image-input-new").prop("files")[0]) total_inputs++;
        if(total_inputs == 3) $("#new-service-btn").removeAttr("disabled");
        else $("#new-service-btn").attr("disabled","disabled");
    }
    $("#new-service-btn").on("click", function(){
        var formData = new FormData();
        formData.append("title", $("#title-new").val());
        formData.append("description", $("#description-new").val());
        formData.append("file", $("#image-input-new").prop("files")[0]);
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

    $("#image-input-new").on("change", function(){
        EnableSaveCategoryBtn ();
        if ($(this).prop("files")[0]) {
            $("#image-preview-div-new").removeAttr("hidden");
            readURL(this, $("#image-preview-new"));
            $("#image-input-label-new").html($(this).prop("files")[0].name);            
        } else {
            $("#image-preview-div-new").attr("hidden", true);
            $("#image-input-label-new").html("Selecccionar imagen...");
        }
        
    });

    $("#title-new, #description-new").on("keyup", function() {
        EnableSaveCategoryBtn ();
    })

    $(".edit-service").on("click", function(){
        window.location.href = location.origin+'/dashboard?page=edit-service&id='+$(this).attr("id").substring(5);
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

    function EnableEditServiceBtn(enable) {
        console.log("enable: "+enable);
        if (enable) $("#submit-service-edit").removeAttr("disabled");
        else $("#submit-service-edit").attr("disabled","disabled");
    }

    function IsTitleValid () {
        console.log("title valid: "+$.trim($("#title-input-edit").val()) != "");
        if ($.trim($("#title-input-edit").val()) != "") 
        {
            return true;
        } else if ($.trim($("#title-input-edit").val()) == "") {
            return false;
        }
    }

    function IsImageValid() {
        console.log("image valid: "+$("#image-input-edit").prop("files")[0]);
        if ($("#image-input-edit").prop("files")[0]) 
        {
            return true;
        } else {
            return false;
        }
    }

    function IsDescriptionValid () {
        console.log("description valid: "+$.trim($("#description-input-edit").val()) != "");
        if ($.trim($("#description-input-edit").val()) != "") 
        {
            return true;
        } else if ($.trim($("#description-input-edit").val()) == "") {
            return false;
        }
    }

    $("#title-input-edit").on("keyup", function(){
        EnableEditServiceBtn(IsTitleValid());
    })

    $("#description-input-edit").on("keyup", function(){
        EnableEditServiceBtn(IsDescriptionValid());
    })

    $("#edit-title").on("change", function(){
        if ($(this).is(":checked")) {
            $("#title-input-edit").removeAttr("disabled");
            EnableEditServiceBtn(IsTitleValid());
        } else { 
            if ($("#edit-description, #edit-image").is(":checked")) {
                if ($("#edit-description").is(":checked")) {
                    console.log("descripción seleccionado");
                    EnableEditServiceBtn(IsDescriptionValid());
                } 
                if ($("#edit-image").is(":checked")) {
                    console.log("iamgen seleccionada");
                    EnableEditServiceBtn(IsImageValid());
                }
            } else {
                console.log("solo titulo seleccionado");
                EnableEditServiceBtn(false);
            }
            $("#title-input-edit").attr("disabled","disabled");
        }
    });

    $("#edit-description").on("change", function(){
        if ($(this).is(":checked")) {
            $("#description-input-edit").removeAttr("disabled");
            EnableEditServiceBtn(IsDescriptionValid());
        } else { 
            if ($("#edit-title, #edit-image").is(":checked")) {
                if ($("#edit-title").is(":checked")) {
                    console.log("titulo seleccionado");
                    EnableEditServiceBtn(IsTitleValid());
                } 
                if ($("#edit-image").is(":checked")) {
                    console.log("iamgen seleccionada");
                    EnableEditServiceBtn(IsImageValid());
                }
            } else {
                console.log("solo descripcion seleccionado");
                EnableEditServiceBtn(false);
            }
            $("#description-input-edit").attr("disabled","disabled");
        }
    });

    $("#edit-image").on("change", function(){
        if ($(this).is(":checked")) {
            $("#image-input-edit").removeAttr("disabled");
            EnableEditServiceBtn(IsImageValid());
        } else {
            if ($("#edit-title, #edit-description").is(":checked")) {
                if ($("#edit-title").is(":checked")) {
                    console.log("titulo seleccionado");
                    EnableEditServiceBtn(IsTitleValid());
                } 
                if ($("#edit-description").is(":checked")) {
                    console.log("descripcion seleccionada");
                    EnableEditServiceBtn(IsImageValid());
                }
            } else {
                console.log("solo imagen seleccionado");
                EnableEditServiceBtn(false);
            }
            $("#image-input-edit").attr("disabled","disabled");
        } 
    });

    $("#image-input-edit").on("change", function(){
        if ($(this).prop("files")[0]) {
            $("#image-input-edit-label").html($(this).prop("files")[0].name);
            readURL(this, $("#service-edit-image-preview"));
            EnableEditServiceBtn(true);
        } else {
            $("#image-input-edit-label").html("Escoger imagen...");
            $("#service-edit-image-preview").attr("src","../includes/img/placeholder-image.jpg");
            EnableEditServiceBtn(false);
        }
    });

    $("#cancel-service-edit").on("click", function(){
        window.location.href = location.origin + "/dashboard?page=manage-services"
    });

    $("#submit-service-edit").on("click", function(){
        var formData = new FormData();
        formData.append("id", servId);
        if ($("#edit-title").is(":checked")) {
            formData.append("title", $.trim($("#title-input-edit").val()));
        }
        if ($("#edit-description").is(":checked")) {
            formData.append("description", $.trim($("#description-input-edit").val()));
        }
        if ($("#edit-image").is(":checked")) {
            formData.append("image", $("#image-input-edit").prop("files")[0]);
        }

        console.log("title: "+formData.get("title"));
        console.log("description: "+formData.get("description"));
        console.log("image: "+formData.get("image"));
        $.ajax({
            url: location.origin+'/dashboard/admin/site-settings/update_service.php', // this is the target
            type: 'post', // method
            cache: false,
            data: formData, // pass the input value to server
            processData: false,  // tell not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location.href = location.origin+"/dashboard?page=manage-services";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });
});