<?php
    session_start();

    // 403 redirection is session is not set.
    require_once '../../../modules/connection.php';
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    if ($_POST && $_SESSION["account_type"] != 'publisher') {
        $username = $_POST["user_name"];
        if (isset($_POST['user_type']) && isset($_POST['user_email'])) { //editing type
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos";
                exit();
            } else {
                $stmt = "update users set email='".$_POST["user_email"]."', account_type='".$_POST["user_type"]."' where username='$username'";
                if ($conn->query($stmt) == TRUE) {

                    echo "El usuario se ha modificado correctamente.";
                } else {
                    http_response_code(412);
                }
            }
        }
        if (!isset($_POST['user_type']) && isset($_POST['user_email'])) { //editing email
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos";
                exit();
            } else {
                $stmt = "update users set email='".$_POST["user_email"]."' where username='$username'";
                if ($conn->query($stmt) === TRUE) {
                    echo "El email se ha modificado correctamente.";
                } else {
                    http_response_code(412);
                }
            }
        }
        if (isset($_POST['user_type']) && !isset($_POST['user_email'])) { //editing type and email
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos";
                exit();
            } else {
                $stmt = "update users set account_type='".$_POST["user_type"]."' where username='$username'";
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