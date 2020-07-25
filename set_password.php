<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Establecer contraseña</title>
    <meta name="description" content="Administración de Sistemas Informáticos en Red, I.E.S. Los Manantiales.">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="./includes/css/Footer-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
</head>

<body style="background-color: rgb(241,247,252);">
    <?php
        require_once './modules/connection.php';
        require_once './modules/get_http_protocol.php';
        if(isset($_GET['token'])) {
            echo '<script>token = "'.$_GET['token'].'"</script>';
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $stmt = "select username from password_reset inner join users using(email) where token = '".$_GET['token']."'";

            // Si los datos coinciden, inicializo la sesión
                if ($res = $conn->query($stmt)) {
                    if ($row = $res->fetch_assoc()) {
                        echo '
                            <script>username = "'.$row['username'].'"</script>
                            <div class="login-clean" style="background-color: rgba(241,247,252,0);">
                                <form class="border rounded shadow-lg" method="post" style="margin-top: 20px;">
                                    <h2 class="sr-only">Establecer contraseña</h2>
                                    <p>Establecer contraseña</p>
                                    <div class="form-group">
                                        <input id="pass1" class="form-control" type="password" placeholder="Nueva contraseña" style="font-size: 14px;">
                                    </div>
                                    <div class="form-group">
                                        <input id="pass2" class="form-control form-control-sm" type="password" name="password" placeholder="Confirma nueva contraseña">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" disabled id="submitbtn" role="button" href="./modules/change_password.php" style="background-color: rgb(0, 98, 204);">Restablecer</button>
                                    </div>
                                </form>
                            </div>
                        ';
                    } else {
                        echo '
                            <div class="login-clean" style="background-color: rgba(241,247,252,0);">
                                <form class="border rounded shadow-lg" style="margin-top: 20px;">
                                    <h2 class="sr-only"></h2>
                                    <p>No existe niguna petición de recuperación de contraseña con el identificador proporcionado. Si crees que se puede tratar de un error, contacta con el administrador del sitio.</p>    
                                </form>
                            </div>
                        ';
                    }
                }
            }
        } else {
            echo '<script type="text/javascript">
                window.location = "'.getHttpProtocol().'://'.$_SERVER['SERVER_NAME'].'/403.php"
            </script>';
        }
    ?>
    
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/bs-init.js"></script>
    <script>
        $('#pass1, #pass2').on('keyup', function(e) {
        // set the variables
            var pass1 = $('#pass1').val();
            var pass2 = $('#pass2').val();
            if (pass1 == pass2 && pass1 != "" && pass2 != "") {
                $('#pass1').css('background-color', '#A7F0A9');
                $('#pass2').css('background-color', '#A7F0A9');
                $('#submitbtn').removeAttr('disabled');
            } else if (pass1 != pass2 && pass1 != "" && pass1 != "") {
                $('#pass1').css('background-color', '#FF9696');
                $('#pass2').css('background-color', '#FF9696');
                $('#submitbtn').attr('disabled', 'disabled');
            }
        });

        $('#submitbtn').on('click', function(e) {
            // perform an ajax call
            console.log(username);
            console.log($('#pass1').val());
            console.log(token);
            $.ajax({
                url: './modules/change_passwd.php', // this is the target
                method: 'post', // method
                data: {user: username, pass: $('#pass1').val(), token: token}, // pass the input value to server
                success: function(r) { // if the http response code is 200 
                    window.location = location.origin+"/index.php";
                },
                error: function(r) { // if the http response code is other than 200
                    alert("Ha ocurido un error al establecer la contraseña.");
                }
            }); 
        });

    </script>
</body>

</html>