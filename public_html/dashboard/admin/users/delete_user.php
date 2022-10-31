<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if ($_POST) {
        try {
            $userid = $_POST['userid'];
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $sql = "delete from users where id = ".intval($userid);
                echo $sql;
                if ($conn->query($sql) === TRUE) {
                    echo "Se ha eliminado el usuario.";
                } else {
                   echo "Ha ocurrido un error al eliminar el usuario.";
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>