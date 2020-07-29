<?php
    session_start();
    require_once '../../../modules/connection.php';

    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    if ($_POST && $_SESSION['account_type'] != 'publisher') {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = "update categories set cat_enabled='".$status."' where id=".$id;
            if ($conn->query($stmt) === TRUE) {
                http_response_code(200);
            } else {
                http_response_code(412);
            }
        }
    } else {
        header("Location: ../../../../403.php");
        exit();
    }
?>