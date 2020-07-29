jQuery(function($){
    function enableCreateBtn() {
        var total_inputs = 0;
        if ($("#title").val() != "") total_inputs++;
        if ($("#post-content").val() != "") total_inputs++;
        if ($("#category-option option:selected").val() != "") total_inputs++;
        if ($("#upload-files").prop("files").length > 0) total_inputs++;
        console.log(total_inputs);
        if (total_inputs == 4) $("#post-create").prop("disabled", false);
        else $("#post-create").prop("disabled", true);
    }

    $("#title, #post-content").on("keyup", function(e){
        enableCreateBtn();
    });

    $("#category-option, #upload-files").on("change", function(e){
        enableCreateBtn();
    });

    $("#upload-files").on("change", function(e){
        var files = $("#upload-files").prop("files");
        if (files.length > 0) {
            if (files.length <= 10) {
                var namesArray = $.map(files, function(val) { return val.name; });
                $("#file-list").empty();
                for (var i = 0; i < namesArray.length; i++) {
                    $("#file-list").append("<li><i class='far fa-file-image' style='padding-right: 5px;'></i>"+namesArray[i]+"</li>");
                    // names += namesArray[i];
                }
                // names = names.substring(0, names.length - 2);
                // console.log("text length: "+$("#upload-files-name").text().length)
                // console.log("text length: "+$("#upload-files-name").text().length)
                $("#upload-files-name").html(files.length+" fichero(s) seleccionado(s).");
                // console.log(names);
            } else {
                alert("El número máximo de ficheros permitidos es 10. Revisa tu selección e inténtalo de nuevo.");
                $("#upload-files").val("");
                $("#upload-files-name").html("Subir fichero(s)...");
                $("#file-list").empty();
            }
        } else {
            $("#file-list").empty();
            $("#upload-files-name").html("Subir fichero(s)...");
        }
        enableCreateBtn();
    });

    $("#post-create").on("click", function(e){
        var filesLength = $("#upload-files").prop("files").length;
        var formData = new FormData();
        formData.append("title", $("#title").val());
        formData.append("content", $("#post-content").val());
        formData.append("category", $("#category option:selected").val());
        formData.append("file_count", filesLength);
        if (filesLength == 1) {
            formData.append("image", $("#upload-files").prop("files")[0]);
        } else {
            var files = $("#upload-files").prop("files");
            for (var i = 0; i < files.length; i++) {
                formData.append("image"+i, files[i]);
            }
        }
        for(var pair of formData.entries()) {
            console.log(pair[0]+ ', '+ pair[1]); 
        }
        $.ajax({
            url: location.origin+'/dashboard/admin/posts/create_post.php', // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                // $('.modal-backdrop').remove();
                alert(response);
                window.location = location.origin+"/dashboard/?page=list-posts&order=asc";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });
});