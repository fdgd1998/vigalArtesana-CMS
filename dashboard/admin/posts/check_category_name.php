<?php
    session_start();
    require_once '../../../modules/connection.php';

    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    if(isset($_POST['cat_name']) && $_SESSION['account_type'] != 'publisher') {
        $cat_name = $_POST['cat_name'];

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = $conn->prepare("select name from categories where name = ?");
            $stmt->bind_param("s", $cat_name);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($cat_name_db);

            // Si hay resultado, el usuario existe
            if ($stmt->num_rows == 1) {
                http_response_code(412);
            } else {
                http_response_code(200);
            }
        }
    } else {
        header("Location: ../../../../403.php");
        exit();
    }
?>