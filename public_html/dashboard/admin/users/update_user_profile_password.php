<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/validation.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/users/change_password_function.php';
    
    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if(isset($_POST)) {
        $current = $_POST["current"];
        $new1= $_POST["new-1"];
        $new2 = $_POST["new-2"];
        $userid = $_POST["userid"];

        if (updatePassword($new1, $new2, $userid, $userid, $current)) {
            echo "La contraseña se ha modificado correctamente.";
        } else {
            echo "Ha ocurrido un error al modificar la contraseña.";
        }
    }
?>