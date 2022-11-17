<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/validation.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/users/change_password_function.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if(isset($_POST)) {
        $userid = $_POST['userid'];
        $pass = $_POST['pass'];

        if (updatePasswordRandom($pass, $userid, $_SESSION["userid"])) {
            echo "La contraseña se ha modificado correctamente.";
        } else {
            echo "Ha ocurrido un error al modificar la contraseña.";
        }
    }
?>