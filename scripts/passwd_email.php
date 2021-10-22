<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../403.php");
        exit();
    }
    require_once 'get_http_protocol.php';
    function SendPasswdEmail($token, $email, $message) {
        $to = $email;
        $subject = "Restablece tu contraseña en ViGal Artesana";
        $link = getHttpProtocol()."://".$_SERVER['SERVER_NAME']."/set_password.php?token=" . $token . "\"";
        $msg = $message."<a href=".$link.">".$link."</a>.";
        $headers  = "From: webmaster@example.com'\r\nMIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        return mail($to, $subject, $msg, $headers);
    }
?>