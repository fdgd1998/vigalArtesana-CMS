<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }
    if ($_POST && $_SESSION['account_type'] != 'publisher') {
        require_once '../../../scripts/connection.php';
        require_once '../../../scripts/crypt.php';
        require_once '../../../scripts/generate_passwd_token.php';
        require_once '../../../scripts/passwd_email.php';

        // getting and encrypting data
        $user = $_POST['username_s'];
        $name = OpenSSLEncrypt($_POST['name_s']);
        $surname= OpenSSLEncrypt($_POST['surname_s']);
        $email = $_POST['email_s'];
        $account_type = $_POST['account_s'];

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            // creating user
            $stmt = "insert into users (username, email, firstname, surname, account_type) values ('".$user."','".$email."','".$name."','".$surname."','".$account_type."')";
            print($stmt);
            if ($conn->query($stmt) === TRUE) {
                $token = generateToken();
                $isSent = sendPasswdEmail($token, $email);
                if ($isSent) {
                    $stmt = array(
                        'insert into password_reset values ("'.$email.'","'.$token.'")',
                        'update users set passwd_reset = "YES" where email = "'.$email.'"'
                    );
                    foreach($stmt as $sql) {
                        $conn->query($sql);
                    }
                    http_response_code(200);
                }
                else http_response_code(412);
            } else {
                http_response_code(412);
            }
        }
    } else {
        header("Location: ../../../../403.php");
        exit();
    }
    
?>