<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_siteSettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $sql = "update company_info set value_info='".$_POST["mode"]."' where key_info='maintenance'";
        if ($conn->exec($sql)) {
            echo "El modo de mantenimiento se ha activado correctamente.";
        } else {
            echo "El modo de mantenimiento se ha desactivado correctamente.";
        }
    }
?>