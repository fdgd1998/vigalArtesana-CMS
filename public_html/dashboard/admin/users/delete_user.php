<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if ($_POST) {
        $userid = $_POST['userid'];
        $conn = new DatabaseConnection();
        $sql = "update users set modifiedBy = ".$_SESSION["userid"]." where id = $userid";
        $conn->exec($sql);
        
        $sql = "delete from users where id = ".intval($userid);
        if ($conn->exec($sql)) {
            echo "Se ha eliminado el usuario.";
        } else {
            echo "Ha ocurrido un error al eliminar el usuario.";
        }
    }
?>