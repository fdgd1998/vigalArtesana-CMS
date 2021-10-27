<?php
    session_start();
    require_once '../../../scripts/connection.php';

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    // Publishers cannot modify categories.
    if ($_POST && $_SESSION['account_type'] != 'publisher') {
        try {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $stmt = "update categories set cat_enabled='".$status."' where id=".$id; //Updating category.
                $conn->query($stmt);
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>