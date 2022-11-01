<?php
    error_reporting(0);
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/validation.php';
    
    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    // Publishers cannot modify categories.
    if($_POST) {
        try {
            $current = $_POST['current'];
            $new1= $_POST['new-1'];
            $new2 = $_POST['new-2'];

            $stored = "";

            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $sql = "select passwd from users where id = ".$_SESSION["userid"];
                if ($res = $conn->query($sql)) {
                    $stored = $res->fetch_assoc()["passwd"];
                    if (password_verify($current, $stored)) {
                        if (($new1 == $new2) && validatePasswd($new1) && validatePasswd($new2)) {
                            $hash = password_hash($new1, PASSWORD_DEFAULT);
                            $sql = "update users set passwd = '$hash' where id = ".$_SESSION["userid"];
                            if ($conn->query($sql) === TRUE) {
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
        } catch (Exception $e) {
            echo $e;
        }
    }
?>