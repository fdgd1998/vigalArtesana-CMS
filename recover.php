<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ViGal - Recuperar contraseña</title>
    <meta name="description" content="Administración de Sistemas Informáticos en Red, I.E.S. Los Manantiales.">
    <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="includes/css/Bootstrap-Callout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="includes/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="includes/css/styles.css">
</head>

<body style="background-color: rgb(241,247,252);">
    <div class="login-clean" style="background-color: rgba(241,247,252,0);">
        <form class="border rounded shadow-lg" method="post" style="margin-top: 20px;">
            <h2 class="sr-only">Recuperar cuenta en ViGal</h2><a data-bs-hover-animate="pulse" class="bg-white" href="./index.php"><i class="icon ion-android-arrow-back" style="margin-right: 10px;"></i>Volver a Inicio</a>
            <p style="margin-top: 10px;">Recuperar cuenta</p>
            <p class="text-left" style="font-size: 14px;">Si el email introducido corresponde con una cuenta existente, se enviarán instrucciones para su recuperación.</p>
            <div class="form-group"><input id="email" class="form-control" type="email" placeholder="Email" name="email" style="font-size: 14px;"></div>
            <div class="form-group"><button id="submitbtn" class="btn btn-primary btn-block" type="submit" style="background-color: rgb(0, 98, 204);">Recuperar contraseña</button></div>
        </form>
    </div>
    <script src="includes/js/jquery.min.js"></script>
    <script src="includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="includes/js/bs-init.js"></script>
    <script>
        $('#submitbtn').on('click', function(e) {
            // perform an ajax call
            $.ajax({
                url: './script/send_recover_email.php', // this is the target
                method: 'post', // method
                data: {email: $('#email').val()}, // pass the input value to server
                success: function(r) { // if the http response code is 200 
                    window.location = "recover_success.php";
                },
                error: function(r) { // if the http response code is other than 200
                    window.location = "recover_success.php";
                }
            });
            
        });
    </script>
</body>
</html>