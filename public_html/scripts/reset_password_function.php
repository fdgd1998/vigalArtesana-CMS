<?php
    // if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    //     include_once $_SERVER["DOCUMENT_ROOT"]."/errorpages/403.php";
    //     exit();
    // }

    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/send_email.php";

    function resetPassword($email, $conn) {
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
            $url = GetBaseUri()."/password_reset.php?token=$generatedToken";
            $subject = "Recuperación de contraseña en ViGal Boutique.";
            $body = "<p>Has solicitado un restablecimiento de contraseña para el usuario <strong>$username</strong> en ViGal Boutique.  Si no lo has solicitado, ignora este mensaje.</p>";
            $body .= "<p>Si has sido tú, puedes restablecerla desde el siguiente enlace (válido durante 24 horas).</p>";
            $body .= $url;
            $body .= "<p><strong>NOTA: No respondas a este mensaje, ha sido generado automáticamente.</strong></p>";
            return sendEmail($email, $subject, $body);
        }
        return false;
    }
?>