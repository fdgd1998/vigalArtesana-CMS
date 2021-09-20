<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if ($_POST) {
        if (!isset($_SESSION['loggedin'])) {
            header("Location: ../../../../403.php");
            exit();
        }
    
        require_once '../../../scripts/connection.php';
    
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        $categories = array(); // Array to save categories
    
        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $sql = "select id, name from categories order by name asc";
        if ($res = $conn->query($sql)) {
            while ($rows = $res->fetch_assoc()) {
                $categories[$rows["id"]] = $rows["name"];
            }
        }
        echo json_encode($categories);
        $res->free();
        }
    }
?>