<?php
    require_once '../../../modules/connection.php';
    if ($_POST) {
        if (isset($_POST['account_type']) && isset($_POST['email'])) {
            $user = $_POST['user'];
            $email = $_POST['email'];
            $account_type = $_POST['account_type'];
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $stmt = "update users set email='$email', account_type='$account_type' where username='$user'";
                if ($conn->query($stmt) === TRUE) {
                    http_response_code(200);
                } else {
                    http_response_code(412);
                }
            }
        }
        if (!isset($_POST['account_type']) && isset($_POST['email'])) {
            $user = $_POST['user'];
            $email = $_POST['email'];
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $stmt = "update users set email='$email' where username='$user'";
                if ($conn->query($stmt) === TRUE) {
                    http_response_code(200);
                } else {
                    http_response_code(412);
                }
            }
        }
    }
?>