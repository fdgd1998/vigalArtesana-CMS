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

    if($_POST) {
        $username = $_POST['username'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $conn = new DatabaseConnection();
        $sql = "select username from users where username = '$username'";
        if ($conn->query($sql)) {
            echo "El usuario ya existe.";
        } else {
            $sql = "select email from users where email = '$email'";
            if ($conn->query($sql)) {
                echo "El email ya está registrado.";
            } else {
                if (!validateEmail($email)) {
                    echo "El email no es válido.";
                } else {
                    $hash = password_hash($pass, PASSWORD_DEFAULT);
                    $sql = "insert into users (username, email, account_type, createdBy) values ('$username', '$email', ".intval($role).", ".$_SESSION["userid"].")";
                    if ($conn->exec($sql)) {
                        if (updatePasswordRandom($pass, $username, $_SESSION["userid"])) {
                            echo "El usuario se ha creado correctamente.";
                        } else {
                            echo "Ha ocurrido un error al crear el usuario.";
                        }
                    } else {
                        echo "Ha ocurrido un error al crear el usuario.";
                    } 
                }
            }
        }
    }
?>