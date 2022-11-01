<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/validation.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/send_email.php";
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php"; //datos de conexión
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_company_info.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/reset_password_function.php";


    session_start();
    if (isset($_SESSION["loggedin"])) {
        header("Location: index.php");
        exit();
    }
    try {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        $emailValid = false;
        $emailSend = false;
        $message = "";
        $passChanged = false;
        $validToken = false;

        if (isset($_POST["email"])) {
            resetPassword($_POST["email"], $conn);
            $message = "Se ha enviado el correo electrónico. Comprueba tu bandeja de entrada.";
        } else if (isset($_POST["pass1"]) && isset($_POST["pass2"]) && isset($_GET["token"])) {
            $pass1 = $_POST["pass1"];
            $pass2 = $_POST["pass2"];
            $token = $_GET["token"];
            if (validatePasswd($pass1) && validatePasswd($pass2)) {
                $sql = $conn->prepare("select userid from password_reset where token = ?");
                $sql->bind_param("s", $token);
                $sql->execute();
                $sql->store_result();
                $sql->bind_result($userid);
                $sql->fetch();
                $hash = password_hash($pass1, PASSWORD_DEFAULT);
                $sql = $conn->prepare("update users set passwd = ? where id = ?");
                $sql->bind_param("si", $hash, $userid);
                if ($sql->execute()) {
                    $sql = "delete from password_reset where token = '$token'";
                    if ($conn->query($sql) === TRUE) {
                        $passChanged = true;
                    }
                }
            } else {
                $message = "Las contraseñas no coninciden.";
            }
        } else if (isset($_GET["token"])) {
            $token = $_GET["token"];
            $sql = $conn->prepare("select token from password_reset where token = ? and timestamp >= (now() - interval 1 day)");
            $sql->bind_param("s", $token);
            $sql->execute();
            $sql->store_result();
            $sql->bind_result($token);

            if ($sql->num_rows > 0) {
                $validToken = true;
            } else {
                $validToken = false;
            }
        } else {
            $validToken = false;
        }
    } catch (Exception $e) {
        include $_SERVER["DOCUMENT_ROOT"]."/errorpages/500.php";
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Restablecer contraseña | <?=$GLOBALS["site_settings"][2]?></title>
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
        <form class="border rounded shadow-lg" method="post"  action="<?=GetUri()?>">
            <?php if (!$passChanged): ?>
            <div style="margin-bottom: 20px; text-align: center;">
                <a href="<?=GetBaseUri()?>/login">
                    <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>
                    Volver a Iniciar Sesión
                </a>
            </div>
            <div class="mt-2">
                <?php
                    if ($message != "") {
                        echo '<div class="illustration">
                                <div style="font-size: 16px;" class="alert alert-warning" >
                                    '.$message.'
                                </div>
                            </div>';
                    }
                ?>
                <?php if (!isset($_GET["token"])): ?>
                <p style="text-align: center"><strong>Restablecer contraseña</strong></p>
                <p style="text-align: center; font-size: 14px;">Introduce tu email. Si el email existe, se enviará un enlace para restablecer la contraseña. Este enlace será válido durante las próximas 24 horas.</p>
                <div class="form-group"><input class="form-control form-control-sm" type="email" name="email" placeholder="Email"></div>
                <div class="form-group"><button class="btn my-button btn-block" type="submit">Restablecer</button></div>
                <?php else: ?>
                    <?php if($validToken): ?>
                    <p style="text-align: center"><strong>Restablecer contraseña</strong></p>
                    <p style="text-align: center; font-size: 14px;">Requisitos de complejidad:</p>
                    <ul style="text-align: center; font-size: 14px;">
                        <li>Longitud mínima de 8 caracteres.</li>
                        <li>Letras minúsculas (<strong>a-z</strong>).</li>
                        <li>Letras mayúsculas (<strong>A-Z</strong>).</li>
                        <li>Dígitos del <strong>0 al 9</strong></li>
                        <li>Caracteres especiales</li>
                        <li>(<strong>!, @, #, $, %, ^, &, (, ), \, -, _, +, .</strong>).</li>
                    </ul>
                    <div class="form-group"><input class="form-control form-control-sm" id="pass1" type="password" name="pass1" placeholder="Nueva contraseña" /></div>
                    <div class="form-group"><input class="form-control form-control-sm" id="pass2" type="password" name="pass2" placeholder="Confirma nueva contraseña"></div>
                    <div class="form-group"><p style="color: red; font-size: 14px;" id="pass-feedback"></p></div>
                    <div class="form-group"><input class="btn my-button btn-block" id="change-password" disabled type="submit" value="Cambiar contraseña"></div>
                    <?php else: ?>
                    <p style="text-align: center"><strong>Restablecer contraseña</strong></p>
                    <p style="text-align: center; font-size: 14px;">El token proporcionado no es válido o ha caducado.</p>
                    <p style="text-align: center; font-size: 14px;">Vuelve a solicitar un nuevo restablecimiento de contraseña.</p>
                    <?php endif; ?>        
                <?php endif; ?>

                <?php else: ?>
                <p style="text-align: center"><strong>Restablecer contraseña</strong></p>
                <p style="text-align: center; font-size: 14px;">La contraseñas se ha cambiado correctamente.</p>
                <div class="form-group"><a class="btn my-button btn-block" href="<?=GetBaseUri()?>/login">Iniciar sesión</a></div>
                <?php endif; ?>
            </div>
        </form>
    </div>        
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/validations.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/reset-password.js"></script>
</body>
</html>