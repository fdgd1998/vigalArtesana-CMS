<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/validation.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    // Publishers cannot modify categories.
    if(isset($_POST)) {
        $current = $_POST['current'];
        $new1= $_POST['new-1'];
        $new2 = $_POST['new-2'];

        $stored = "";

        $conn = new DatabaseConnection();
        $sql = "select passwd from users where id = ".$_SESSION["userid"];
        if ($res = $conn->query($sql)) {
            $stored = $res[0]["passwd"];
            if (password_verify($current, $stored)) {
                if (($new1 == $new2) && validatePasswd($new1) && validatePasswd($new2)) {
                    $hash = password_hash($new1, PASSWORD_DEFAULT);
                    $sql = "update users set passwd = '$hash' where id = ".$_SESSION["userid"];
                    if ($conn->exec($sql)) {
                        echo "La contraseña se ha actualizado correctamente";
                    } else {
                        echo "Ha ocurrido un error al actualizar la contraseña.";
                    }
                } else {
                    echo "Las contraseñas no coinciden.";
                }
            } else {
                echo "La contraseña actual es incorrecta.";
            }
        }
    }
?>