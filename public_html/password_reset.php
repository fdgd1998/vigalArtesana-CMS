<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/validation.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/send_email.php";
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php"; //datos de conexión
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_company_info.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";

    session_start();
    if (isset($_SESSION["loggedin"])) {
        header("Location: index.php");
        exit();
    }

    if ($GLOBALS["site_settings"][11] == "true" || ($GLOBALS["site_settings"][11] == "true" && !isset($_SESSION["loggedin"]))) { 
        require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_503_header.php";
        set_503_header();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

    $emailValid = false;
    $emailSend = false;
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $sql = $conn->prepare("select id, username, email from users where email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $sql->store_result();
        $sql->bind_result($userid, $username, $email);
        
        if ($sql->num_rows > 0) {
            $sql->fetch();  
            $generatedToken = bin2hex(random_bytes(64));

            $sql = $conn->prepare("select token from password_reset where userid = ?");
            $sql->bind_param("i", $userid);
            $sql->execute();
            $sql->store_result();
            $sql->bind_result($token);
            if ($sql->num_rows > 0) {
                $sql->fetch();
                $sql = $conn->prepare("update password_reset set token = ?, timestamp = CURRENT_TIMESTAMP where userid = ?");
                $sql->bind_param("si", $generatedToken, $userid);
                $sql->execute();
            } else {
                $sql->prepare("insert into password_reset (token, userid) values (?, ?)");
                $sql->bind_param("si", $generatedToken, $userid);
                $sql->execute();
            }
            echo "sending email<br>";
            $url = GetUri()."?token=$generatedToken";
            $subject = "Recuperación de contraseña en ViGal Boutique.";
            $body = "<p>Has solicitado un restablecimiento de contraseña para el usuario <strong>$username</strong> en ViGal Boutique.  Si no lo has solicitado, ignora este mensaje.</p>";
            $body .= "<p>Si has sido tú, puedes restablecerla desde el siguiente enlace (válido durante 24 horas).</p>";
            $body .= $url;
            $body .= "<p><strong>NOTA: No respondas a este mensaje, ha sido generado automáticamente.</strong></p>";
            sendEmail($email, $subject, $body);
        }
    }

    $validToken = false;
    if (isset($_GET["token"])) {
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
        <form class="border rounded shadow-lg" method="post" style="margin-top: 20px;" action="<?=GetUri()?>">
            <div style="margin-bottom: 20px;">
                <a href="<?=GetBaseUri()?>/login">
                    <i class="fas fa-arrow-left" style="margin-right: 10px;"></i>
                    Volver a Iniciar Sesión
                </a>
            </div>
            <div class="mt-5">
                <?php
                    if (isset($_POST["email"])) {
                        $message = "Se ha enviado el correo electrónico. Comprueba tu bandeja de entrada.";
                        include $_SERVER["DOCUMENT_ROOT"].'/snippets/info_message.php';
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
                    <ul style="list-style-type: disc; margin-left: 30px; font-size: 14px;">
                        <li>Longitud mínima de 8 caracteres.</li>
                        <li>Letras minúsculas (<strong>a-z</strong>).</li>
                        <li>Letras mayúsculas (<strong>A-Z</strong>).</li>
                        <li>Dígitos del <strong>0 al 9</strong></li>
                        <li>Caracteres especiales (<strong>!, @, #, $, %, ^, &, (, ), \, -, _, +, .</strong>).</li>
                    </ul>
                    <div class="form-group"><input type="password" class="form-control form-control-sm" name="pass1" placeholder="Nueva contraseña" /></div>
                    <div class="form-group"><input class="form-control form-control-sm" type="password" name="pass2" placeholder="Confirma nueva contraseña"></div>
                    <div class="form-group"><button class="btn my-button btn-block" type="submit">Restablecer</button></div>
                    <?php else: ?>
                    <p style="text-align: center"><strong>Restablecer contraseña</strong></p>
                    <p style="text-align: center; font-size: 14px;">El token proporcionado no es válido o ha caducado.</p>
                    <p style="text-align: center; font-size: 14px;">Vuelve a solicitar un nuevo restablecimiento de contraseña.</p>
                    <?php endif; ?>        
                <?php endif; ?>
                </div>
        </form>
    </div>        
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>