<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/send_reset_password_email.php";
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST["useremail"])) {
        $isSend = resetPasswordEmail($_POST["useremail"]);
        if ($isSend) {
            echo "Se ha enviado la solicitud de restablecimiento de contraseña.";
        } else {
            echo "Ha ocurrido un error al enviar la solicitud de restablecemiento de la contraseña.";
        }
    }
?>