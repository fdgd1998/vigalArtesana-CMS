<?php
    session_start();

    // 403 redirection is session is not set.
    require_once '../../../scripts/connection.php';
    require_once '../../../scripts/crypt.php';
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    if ($_POST && $_SESSION["account_type"] != 'publisher') {
        $email_enc = isset($_POST["user_email"])?OpenSSLEncrypt($_POST["user_email"]):"";
        if (isset($_POST['user_type']) && isset($_POST['user_id'])) { //editing type and email
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos";
                exit();
            } else {
                $stmt = "update users set email='".$email_enc."', account_type='".$_POST["user_type"]."' where id='".$_POST["user_id"]."'";
                if ($conn->query($stmt) == TRUE) {

                    echo "El usuario se ha modificado correctamente.";
                } else {
                    http_response_code(412);
                }
            }
        }
        if (!isset($_POST['user_type']) && isset($_POST['user_id'])) { //editing email
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos";
                exit();
            } else {
                $stmt = "update users set email='".$email_enc."' where id='".$_POST["user_id"]."'";
                if ($conn->query($stmt) === TRUE) {
                    echo "El email se ha modificado correctamente.";
                } else {
                    http_response_code(412);
                }
            }
        }
        if (isset($_POST['user_type']) && !isset($_POST['user_id'])) { //editing type
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos";
                exit();
            } else {
                $stmt = "update users set account_type='".$_POST["user_type"]."' where id='".$_POST["user_id"]."'";
                if ($conn->query($stmt) === TRUE) {
                    echo "El tipo de cuenta se ha modificado correctamente.";
                } else {
                    http_response_code(412);
                }
            }
        }
    } else {
        header("Location: ../../../../403.php");
        exit();
    }
    
?>