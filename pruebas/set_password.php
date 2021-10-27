<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Establecer contraseña</title>
    <meta name="description" content="Establecer contraseña en ViGal Artesana.">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
</head>

<body style="background-color: rgb(241,247,252);">
    <?php
        require_once './scripts/connection.php';
        if(isset($_GET['token'])) {
            echo '<script>token = "'.$_GET['token'].'"</script>';
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $stmt = "select token from password_reset where token = '".$_GET['token']."'";

            // Si los datos coinciden, inicializo la sesión
                if ($res = $conn->query($stmt)) {
                    if ($res->num_rows == 1) {
                        echo '
                            <div class="login-clean" style="background-color: rgba(241,247,252,0);">
                                <form class="border rounded shadow-lg" style="margin-top: 20px;">
                                    <h2 class="sr-only">Establecer contraseña</h2>
                                    <p>Establecer contraseña</p>
                                    <div class="form-group">
                                        <input id="pass1" class="form-control" type="password" placeholder="Nueva contraseña" style="font-size: 14px;">
                                    </div>
                                    <div class="form-group">
                                        <input id="pass2" class="form-control" type="password" placeholder="Confirma nueva contraseña">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-block" disabled id="submitbtn" style="background-color: rgb(0, 98, 204);">Establecer contraseña</button>
                                    </div>
                                </form>
                            </div>
                            <div id="test"></div>
                        ';
                    } else {
                        echo '
                            <div class="login-clean" style="background-color: rgba(241,247,252,0);">
                                <form class="border rounded shadow-lg" style="margin-top: 20px;">
                                    <h2 class="sr-only"></h2>
                                    <p>No existe niguna petición de recuperación de contraseña con el identificador proporcionado. Si crees que se puede tratar de un error, contacta con el administrador del sitio.</p>    
                                    <a href="index.php">Volver a inicio</a>
                                    </form>
                            </div>
                        ';
                    }
                }
            }
        } else {
            // echo '<script type="text/javascript">
            //     window.location = location.origin+"/403.php";
            // </script>';
        }
    ?>
    
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="./includes/js/bs-init.js"></script> -->
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
            console.log($('#pass1').val());
            console.log(token);
            $.ajax({
                url: './scripts/change_passwd.php', // this is the target
                method: 'post', // method
                data: {pass: $('#pass1').val(), token: token}, // pass the input value to server
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