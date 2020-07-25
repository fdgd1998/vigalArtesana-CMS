<?php
    require_once "connection.php"; //datos de conexión
    require_once "crypt.php"; //funciones criptograficas
    require_once 'generate_passwd_token.php';
    require_once 'passwd_email.php';

    if ($_POST) {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        $stmt = $conn->prepare("select email, passwd_reset from users where email = ?");
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($email, $passwd_reset);

        if ($stmt->num_rows == 1) {
            if($row = $stmt->fetch()) {
                $token = generateToken();
                $isSent = sendPasswdEmail($token, $email);
                if ($isSent) {
                    $stmt = array(
                        'insert into password_reset values ("'.$email.'","'.$token.'")',
                        'update password_reset set token="'.$token.'" where email="'.$email.'"',
                        'update users set passwd_reset = "YES" where email = "'.$email.'"'
                    );
                    $conn->query($stmt[2]);
                    if ($passwd_reset == 'YES') {
                        $conn->query($stmt[1]);
                    } else{
                        $conn->query($stmt[0]); 
                    }
                    http_response_code(200);
                }
            }
        }
        $conn->close();
    }
?>