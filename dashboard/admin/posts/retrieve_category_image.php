<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    require_once '../../../modules/connection.php';
    require_once '../../../modules/get_http_protocol.php';

    if(isset($_POST['cat_id']) && $_SESSION['account_type'] != 'publisher') {
        $cat_id = $_POST['cat_id'];

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = "select image from categories where id = ".$cat_id;
            if ($res = $conn->query($stmt)) {
                $row = $res->fetch_assoc();
                echo getHttpProtocol()."://".$_SERVER["SERVER_NAME"]."/uploads/categories/".$row["image"];
                $res->free();
            } else {
                http_response_code(412);
            }
        }
    } else {
        header("Location: ../../../../403.php");
        exit();
    }
?>