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
            echo $_POST["social"];
            $stmt = "update company_info set value_info='".$_POST["social"]."' where key_info='social_media'";
                if ($conn->query($stmt) == TRUE) {
                    echo "La entrada se ha creado correctamente.";
                } else {
                    echo "No se ha podido crear la entrada.";
                }
        }
        $conn->close();
    }
?>