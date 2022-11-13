<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/send_email.php";

    function resetPassword($email) {
        require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
        $conn = new DatabaseConnection();

        $res = $conn->preparedQuery("select id, username, email from users where email = ?", array($email));
        
        if (isset($res[0]["id"])) {  
            $generatedToken = bin2hex(random_bytes(64));

            $res1 = $conn->preparedQuery("select token from password_reset where userid = ?", array($res[0]["id"]));
            if (isset($res1[0]["token"])) {
                if (isset($_SESSION["userid"])) {
                    $params = array($generatedToken, $_SESSION["userid"], $res[0]["id"]);
                    $conn->preparedQuery("update password_reset set token = ?, timestamp = CURRENT_TIMESTAMP, createdBy = ? where userid = ?", $params);
                } else {
                    $params = array($generatedToken, $res[0]["id"]);
                    $conn->preparedQuery("update password_reset set token = ?, timestamp = CURRENT_TIMESTAMP where userid = ?", $params);
                }
            } else {
                if (isset($_SESSION["userid"])) {
                    $params = array($generatedToken, $res[0]["id"], $_SESSION["userid"]);
                    $conn->preparedQuery("insert into password_reset (token, userid, createdBy) values (?, ?, ?)", $params);
                } else {
                    $params = array($generatedToken, $res[0]["id"]);
                    $conn->preparedQuery("insert into password_reset (token, userid) values (?, ?)", $params);
                }
            }
            $url = GetBaseUri()."/password_reset.php?token=$generatedToken";
            $subject = "Recuperación de contraseña en ViGal Boutique.";
            $body = "<p>Has solicitado un restablecimiento de contraseña para el usuario <strong>".$res[0]["username"]."</strong> en ViGal Boutique.  Si no lo has solicitado, ignora este mensaje.</p>";
            $body .= "<p>Si has sido tú, puedes restablecerla desde el siguiente enlace (válido durante 24 horas).</p>";
            $body .= $url;
            $body .= "<p><strong>NOTA: No respondas a este mensaje, ha sido generado automáticamente.</strong></p>";

            $sql = "";
            if (!isset($_SESSION["userid"])) {
                $sql = "insert into logs (text, type) values (concat('Solicitud reset contraseña enviada, para user ID ', ".$res[0]["id"].", ', solicitado por SSPR'), 'user')";
            } else {
                $sql = "insert into logs (text, type) values (concat('Solicitud reset contraseña enviada, para user ID ', ".$res[0]["id"].", ', solicitado por user ID ', ".$_SESSION["userid"]."), 'user')";
            }
            $conn->exec($sql);
            return sendEmail($email, $subject, $body);
        }
        return false;
    }
?>