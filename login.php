<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Iniciar sesión en ViGal</title>
    <meta name="description" content="Administración de Sistemas Informáticos en Red, I.E.S. Los Manantiales.">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/fonts/ionicons.min.css">
    <link rel="stylesheet" href="./includes/css/Bootstrap-Callout.css">
    <link rel="stylesheet" href="./includes/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
</head>

<body style="background-color: rgb(241,247,252);">
<?php
        require_once 'scripts/get_http_protocol.php';
        if(!isset($_SESSION['user'])) {
            echo '
            <div class="login-clean" style="background-color: rgba(241,247,252,0);">
            <form class="border rounded shadow-lg" method="post" style="margin-top: 20px;" action="./scripts/authenticate.php">
                <div style="margin-bottom: 20px;">
                    <a data-bs-hover-animate="pulse" class="bg-white" href="./index.php">
                        <i class="icon ion-android-arrow-back" style="margin-right: 10px;"></i>
                        Volver a Inicio
                    </a>
                </div>
            ';
            $message = '';
                if ($_GET) {
                    if (isset($_GET['wrong_pass'])) {
                        $message = "Contraseña incorrecta.";
                        include './snippets/error_message.php';
                    }
                    if (isset($_GET['wrong_user'])) {
                        $message = "Usuario incorrecto.";
                        include './snippets/error_message.php';
                    }
                }
                echo '
                        <div class="form-group"><input type="text" class="form-control form-control-sm" name="user" placeholder="Usuario" /></div>
                        <div class="form-group"><input class="form-control form-control-sm" type="password" name="password" placeholder="Contraseña"></div>
                        <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(0, 98, 204);">Iniciar sesión</button></div>
                        <a class="forgot" href="./recover.php">¿Has olvidado tu contraseña?</a></form>
                </div>
                ';
        } else {
            echo '<script type="text/javascript">
                window.location = "'.getHttpProtocol().'://'.$_SERVER['SERVER_NAME'].'/403.php"
            </script>';
        }
    ?>            
    <script src="includes/js/jquery.min.js"></script>
    <script src="includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="includes/js/bs-init.js"></script>
</body>
</html>