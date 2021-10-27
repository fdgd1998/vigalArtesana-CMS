<?php
    if ($_POST) {
        require_once 'connection.php';
        require_once 'crypt.php';

        $token = $_POST['token'];
        $pass = OpenSSLEncrypt($_POST['pass']);

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = "select id from users where email = (select email from password_reset where token = '".$token."')";
            $user_id = $conn->query($stmt);
            $stmt = "delete from password_reset where token = '".$token."'";
            if ($conn->query($stmt) === TRUE) {
                $stmt = "update users set passwd = '".$pass."', account_enabled='YES', passwd_reset='NO' where id = '".$user_id->fetch_assoc()["id"]."'";
                if ($conn->query($stmt) === TRUE) {
                    http_response_code(200);
                }
                else http_response_code(412);
            } else {
                http_response_code(412);
            }
        }
    }
?>