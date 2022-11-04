<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/database_connection.php";

    $site_settings = getSiteSettings();
    $errorMessage = "";
    $conn = new DatabaseConnection();

    if (isset($_SESSION["loggedin"])) {
        header("Location: index.php");
        exit();
    }
    
    function registerIp($conn) {
        $ip = $_SERVER["REMOTE_ADDR"];
        $sql = "insert into ip_register (address ,timestamp) values ('$ip', CURRENT_TIMESTAMP)";

        if ($conn->query($sql)) {
            return true;
        }
        return false;
    }

    function maximumAttemps($conn) {
        $ip = $_SERVER["REMOTE_ADDR"];
        $sql = "select count(address) from ip_register where address = '$ip' and timestamp > (now() - interval 10 minute) and login_success = 0";
        if ($res = $conn->query($sql)) {
            $attempts = $res[0]["count(address)"];
            if ($attempts > 3) {
                $_SESSION["error"] = "Has superado el número de intentos permitidos. Inténtalo de nuevo en 10 minutos.";
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    if (isset($_POST)) {
        $user_form = trim($_POST['user']);
        $pass_form = trim($_POST['password']);
    
        $conn = new DatabaseConnection();
        registerIp($conn);

        if (!maximumAttemps($conn)) {
            // Verificación de las credenciales de usuario
            $sql = "select users.id, users.username, users.passwd, user_roles.role, users.account_enabled, users.passwd_reset from users inner join user_roles on user_roles.id = users.account_type where username = ?";
            $params = array($user_form);
            $result = $conn->preparedQuery($sql, $params)[0];
            
            // Si los datos coinciden, inicializo la sesión
            if (isset($result["id"])) {
                if (password_verify($pass_form, $result["passwd"])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user'] = $result["username"];
                    $_SESSION['userid'] = $result["id"];
                    $sql = "update ip_register set login_success = 1 where address = '".$_SERVER["REMOTE_ADDR"]."'";
                    $conn->query($sql);
                    header("Location: ../dashboard/?page=start");
                    exit();
                    // }
                } else {
                    $errorMessage = "Usuario y/o contraseña incorrectos.";
                }
            } else {
                $errorMessage = "Usuario y/o contraseña incorrectos.";
            }
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Iniciar sesión en <?=$site_settings[2]["value_info"]?></title>
    <meta name="description" content="Iniciar sesión en ViGal Artesana">
    <link rel="icon" href="<?=GetBaseUri()?>/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Bootstrap-Callout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    

</head>

<body style="background-color: rgb(241,247,252);">
    <div class="login-clean" style="background-color: rgba(241,247,252,0);">
        <form class="border rounded shadow-lg" method="post" style="margin-top: 20px;" action="<?=GetBaseUri()?>/login">
            <div style="margin-top: 20px; text-align: center;">
                <a href="<?=GetBaseUri()?>">
                    <i class="fas fa-arrow-left" style="margin-right: 10px;"></i>
                    Volver a Inicio
                </a>
            </div>
            <div class="mt-5">
                <?php
                    if ($errorMessage != "") {
                        $message = $_SESSION["error"];
                        echo '<div class="illustration">
                                <div style="font-size: 16px;" class="alert alert-danger" >
                                    '.$errorMessage.'
                                </div>
                            </div>';
                        session_unset();
                        session_destroy();
                    }
                ?>

                <div class="form-group"><input type="text" class="form-control form-control-sm" name="user" placeholder="Usuario" /></div>
                <div class="form-group"><input class="form-control form-control-sm" type="password" name="password" placeholder="Contraseña"></div>
                <div class="form-group"><button class="btn my-button btn-block" type="submit" style="background-color: rgb(0, 98, 204);">Iniciar sesión</button></div>
                <p class="forgot">Si has olvidado tu contraseña, puedes restablecerla <u><a href="<?=GetBaseUri()?>/password_reset.php">aquí</a></u>.</p>
            </div>
        </form>
    </div>        
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>