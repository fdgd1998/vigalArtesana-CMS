<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

    if (isset($_POST)) {
        try {
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $sql = "update pages_metadata set title='".$_POST["title"]."', description = '".$_POST["desc"]."' where id_page=".$_POST["id"];
                echo var_dump($_POST["id"]);
                if ($conn->query($sql) === TRUE) {
                    echo "Los datos se han modificado correctamente.";
                } else {
                    echo "Ha ocurrido un error al modificar los datos.";
                }
            }
            $conn->close();
        } catch (Exception $e) {
            $conn->rollback();
            echo $e;
        }
    }
?>