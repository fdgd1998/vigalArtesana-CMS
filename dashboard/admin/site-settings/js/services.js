$(document).ready(function() {
    var n = 1;
    $("#new-service-section-btn").on("click", function(){
        var service_section = '<div class="services-section" id="service-'+n+'">\
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
                <input type="text" class="form-control" aria-describedby="basic-addon1">\
            </div>\
            <div class="input-group mb-3">\
                <div class="input-group-prepend">\
                    <span class="input-group-text"><i class="fas fa-upload"></i></span>\
                </div>\
                <div class="custom-file">\
                    <input type="file" class="custom-file-input" id="inputGroupFile01">\
                    <label class="custom-file-label" for="inputGroupFile01">Seleccionar imagen...</label>\
                </div>\
            </div>\
            <div class="input-group">\
                <div class="input-group-prepend">\
                    <span class="input-group-text">Descripción:</span>\
                </div>\
                <textarea cols="20" class="form-control" aria-label="With textarea"></textarea>\
            </div>\
        </div>\
        <div class="text-center col-12 col-lg col-xl-5 col-md-12 col-sm-12">\
            <img style="height: 100%; width: 70%; object-fit: contain" src="../includes/img/placeholder-image.jpg" alt="">\
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
});