<?php
    require_once 'get_http_protocol.php';
    function SendPasswdEmail($token, $email) {
        $to = $email;
        $subject = "Recuperación de contraseña";
        $msg = "¡Hola! Para restablecer tu contrasñea en ViGal Artesanos, haz click en este <a href=".getHttpProtocol()."://".$_SERVER['SERVER_NAME']."/set_password.php?token=" . $token . "\">enlace</a>.";
        $headers = "From: info@examplesite.com";
        return mail($to, $subject, $msg, $headers);
    }
?>