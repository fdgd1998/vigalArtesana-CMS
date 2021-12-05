$(document).ready(function(){
    function enableSendBtn () {
        var inputs = 0;
        if ($("#nombre").hasClass("is-valid")) inputs++;
        if ($("#email").hasClass("is-valid")) inputs++;
        if ($("#mensaje").hasClass("is-valid")) inputs++;
        if (inputs == 3) {
            $("#submit-message").removeAttr("disabled");
        } else {
            $("#submit-message").attr("disabled","true");
        }
    }
    $("#nombre, #mensaje").on("keyup", function(){
        if ($.trim($(this).val()) == "") {
            $(this).addClass("is-invalid");
            $(this).removeClass("is-valid");
        } else {
            $(this).addClass("is-valid");
            $(this).removeClass("is-invalid");
        }
        enableSendBtn();
    })

    $("#email").on("keyup", function(){
        if (/^([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4})$/.test($.trim($(this).val()))) {
            $(this).addClass("is-valid");
            $(this).removeClass("is-invalid");
        } else {
            $(this).addClass("is-invalid");
            $(this).removeClass("is-valid");
        }
        enableSendBtn();
    })

    $("#submit-message").on("click", function(){
        var motivo = "";
        switch ($("#motivo option:selected").val()) {
            case "duda":
                motivo = "Consultar duda";
                break;
            case "precio":
                motivo = "Consultar precio.";
                break;
            case "presupuesto":
                motivo = "Pedir presupuesto.";
                break;
            case "otro":
                motivo = "Otra consulta.";
                break;
        }
        var message = "\
            <p>Alguien ha contado contigo usando el formulario de contacto de ViGal Artesana.</p>\
            <ul>\
            <li>Motivo de contacto: <strong>"+motivo+"</strong></li>\
            <li>Email de contacto: <strong>"+$.trim($("#email").val())+"<strong></li>\
            </ul>\
            <h2><strong>Mensaje:</strong></h2>\
            <p>"+$("#mensaje").val()+"</p>\
            ";
        var formData = new FormData();
        formData.append("from", $.trim($("#email").val()));
        formData.append("to", "contacto@vigalartesana.es");
        formData.append("subject", "Formulario de contacto - ViGal Artesana.");
        formData.append("message", message);
        $.ajax({
            url: location.origin+'/scripts/send_mail.php', // this is the target
            type: 'post', // method
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                alert(response);
                // window.location = location.origin+"/dashboard/?page=categories&order=asc";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    })
})