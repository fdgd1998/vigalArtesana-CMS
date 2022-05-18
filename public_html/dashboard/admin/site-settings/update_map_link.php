<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    
    if (!HasAccessToResource("update_map_link")) {
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
                $errors = 0;
                $stmt = "update company_info set value_info='".$_POST["map_link"]."' where key_info='google-map-link'";
                if ($conn->query($stmt) === TRUE) {
                    echo "El enlace se ha modificado correctamente.";
                } else {
                    echo "Ha ocurrido un error al actualizar el enlace.";
                }
            }
            $conn->close();
        } catch (Exception $e) {
           echo $e;
        }
    }
?>