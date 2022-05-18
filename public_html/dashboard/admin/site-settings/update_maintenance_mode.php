<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    
    if (!HasPermission("manage_siteSettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $stmt = "update company_info set value_info='".$_POST["mode"]."' where key_info='maintenance'";
                if ($conn->query($stmt) === TRUE) {
                    if ($_POST["mode"] == "true") {
                        echo "El modo de mantenimiento se ha activado correctamente.";
                    } else {
                        echo "El modo de mantenimiento se ha desactivado correctamente.";
                    }
                }
                $conn->close();
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>