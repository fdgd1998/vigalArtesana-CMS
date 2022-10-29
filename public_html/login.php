<?php
    session_start();
    if (isset($_SESSION["loggedin"])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Iniciar sesión en <?=$GLOBALS["site_settings"][2]?></title>
    <meta name="description" content="Iniciar sesión en ViGal Artesana">
    <link rel="icon" href="./includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/css/Bootstrap-Callout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    

</head>

<body style="background-color: rgb(241,247,252);">
    <div class="login-clean" style="background-color: rgba(241,247,252,0);">
        <form class="border rounded shadow-lg" method="post" style="margin-top: 20px;" action="./scripts/authenticate.php">
            <div style="margin-bottom: 20px;">
                <a href="<?=(isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]?>">
                    <i class="fas fa-arrow-left" style="margin-right: 10px;"></i>
                    Volver a Inicio
                </a>
            </div>
            <?php
                if ($_SESSION["error"] != "") {
                    $message = $_SESSION["error"];
                    include './snippets/error_message.php';
                    // session_unset();
                    // session_destroy();
                }
            ?>
                
            <div class="form-group"><input type="text" class="form-control form-control-sm" name="user" placeholder="Usuario" /></div>
            <div class="form-group"><input class="form-control form-control-sm" type="password" name="password" placeholder="Contraseña"></div>
            <div class="form-group"><button class="btn my-button btn-block" type="submit" style="background-color: rgb(0, 98, 204);">Iniciar sesión</button></div>
            <p class="forgot">Si has olvidado tu contraseña, contacta con el administrador del sitio para restablecerla.</p>
        </form>
    </div>        
    <script src="includes/js/jquery.min.js"></script>
    <script src="includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="includes/js/bs-init.js"></script> -->
</body>
</html>