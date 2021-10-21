<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    require_once '../../../scripts/connection.php';

    if ($_POST) {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $errors = 0;
            $stmt = "update company_info set value_info='".$_POST["map_link"]."' where key_info='google-map-link'";
            if ($conn->query($stmt) === FALSE) $errors++;
            
            if ($errors == 0) {
                echo "La entrada se ha creado correctamente.";
            } else {
                echo "No se ha podido crear la entrada";
            }
        }
        $conn->close();
    }
?>