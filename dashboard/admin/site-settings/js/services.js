$(document).ready(function() {
    var n = 1;
    $("#new-service-section-btn").on("click", function(){
        var service_section = '<div class="services-section">\
        <div class="row">\
        <div class="col-12 col-lg-12 col-md-12 col-sm-12">\
            <button class="remove-section btn btn-outline-danger" type="button">Borrar sección</button>\
        </div>\
    </div>\
    <div class="row">\
        <div class="col-12 col-lg col-xl-7 col-md-12 col-sm-12">\
            <div class="input-group mb-3">\
                <div class="input-group-prepend">\
                    <span class="input-group-text" id="basic-addon1">Título:</span>\
                </div>\
                <input type="text" class="form-control service-title" aria-describedby="basic-addon1">\
            </div>\
            <div class="input-group mb-3">\
                <div class="input-group-prepend">\
                    <span class="input-group-text"><i class="fas fa-upload"></i></span>\
                </div>\
                <div class="custom-file">\
                    <input type="file" class="custom-file-input service-image" data-browse="Buscar...">\
                    <label class="custom-file-label" data-browse="Buscar..."">Seleccionar imagen...</label>\
                </div>\
            </div>\
            <div class="input-group">\
                <div class="input-group-prepend">\
                    <span class="input-group-text">Descripción:</span>\
                </div>\
                <textarea cols="20" class="form-control service-description" aria-label="With textarea"></textarea>\
            </div>\
        </div>\
        <div class="service-image-preview text-center col-12 col-lg col-xl-5 col-md-12 col-sm-12">\
            <img  style="height: 100%; width: 70%; object-fit: contain" src="../includes/img/placeholder-image.jpg" alt="">\
        </div>\
    </div>\
    </div>';
       $("#services").append(service_section);
       n++;
       disableNewServiceBtn();
       disableSaveBtn();
    });

    $(document).on("click", ".remove-section", function(){
        $(this).parent().parent().parent().fadeOut(300);
        $(this).promise().done(function(){
            $(this).parent().parent().parent().remove();
            resetSectionNumbers();
            disableSaveBtn();
        });
        
    })

    function resetSectionNumbers() {
        n = 1;
        $(".services-section").each(function(){
            $(this).attr("id","service-"+n);
            n++;
        });
        disableNewServiceBtn();
    }

    function disableNewServiceBtn() {
        if (n>10) {
            $("#new-service-section-btn").attr("disabled","disabled");
        } else {
            $("#new-service-section-btn").removeAttr("disabled");
        }
    }

    function disableSaveBtn() {
        if (n>1) {
            $("#save-services-btn").removeAttr("disabled");
        } else {
            $("#save-services-btn").attr("disabled","disabled");
        }
    }

    $("#save-services-btn").on("click", function(){
        var services_data = [];
        var sections = $(document).find(".services-section");
        var services = new FormData();

        sections.each(function(i) {
            if (!$.trim($(this).find(".service-title").val())) {
                alert("ERROR: debes proporcionar un título a todos los servicios. Revísalos y vuelve a intentarlo.");
                return false; //breaking the loop
            }
            if (!$.trim($(this).find(".service-description").val())) {
                alert("ERROR: debes proporcionar una descripción a todos los servicios. Revísalos y vuelve a intentarlo.");
                return false; //breaking the loop
            }
            if (!$(this).find(".service-image").get(0).files[0]) {
                alert("ERROR: debes selecccionar una imagen por cada servicio. Revísalas y vuelve a intentarlo.");
                return false; //breaking the loop
            }

            console.log($(this).find(".service-image > input"));
            services_data.push([
                $(this).find(".service-title").val(),
                $(this).find(".service-description").val(),
                "" //placeholder for the file name. to be filled by php script                
            ]);
            services.append(i, $(this).find(".service-image").get(0).files[0]);
        });

        services.append("service_data", JSON.stringify(services_data));
        console.log(services);

        $.ajax({
            url: 'admin/site-settings/update_services.php', // this is the target
            method: 'post', // method
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            data: services, // pass the input value to server
            success: function(r) { // if the http response code is 200
                alert(r)
            },
            error: function(r) { // if the http response code is other than 200
                alert("Ha ocurrido un error")
            }
        })
    })

    $(document).on("change", ".service-image", function(){
        console.log("image changed!");
        console.log(this)
        var img = $(this).parent().parent().parent().parent().find(".service-image-preview > img");
        readURL(this, img);
        if (this.files[0]) {
            $(this).siblings("label").text(this.files[0]["name"]);
        } else {
            $(this).siblings("label").text("Seleccionar fichero...");
            img.attr("src", "../includes/img/placeholder-image.jpg");
        }
        // $(this).siblings(".service-image-preview").removeAttr("src");
    })
});