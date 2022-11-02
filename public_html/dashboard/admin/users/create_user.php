<?php
    error_reporting(0);
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/validation.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if($_POST) {
        try {
            $username = $_POST['username'];
            $role = $_POST['role'];
            $email = $_POST['email'];
            $pass1= $_POST['pass-1'];
            $pass2 = $_POST['pass-2'];

            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $sql = "select username from users where username = '$username'";
                if ($conn->query($sql)->num_rows > 0) {
                    echo "El usuario ya existe.";
                } else {
                    $sql = "select email from users where email = '$email'";
                    if ($conn->query($sql)->num_rows > 0) {
                        echo "El email ya está registrado.";
                    } else {
                        if (!validateEmail($email)) {
                            echo "El email no es válido.";
                        } else {
                            if ($pass1 != $pass2) {
                                echo "Las contraseñas no son iguales.";
                            } else {
                                if (validatePasswd($pass1) && validatePasswd($pass2)) {
                                    $hash = password_hash($pass1, PASSWORD_DEFAULT);
                                    $sql = "insert into users (username, email, passwd, account_type) values ('$username', '$email', '$hash', ".intval($role).")";
                                    if ($conn->query($sql) === TRUE) {
                                        echo "El usuario se ha creado correctamente.";
                                    } else {
                                        echo "Ha ocurrido un error al crear el usuario.";
                                    }
                                } else {
                                    echo "La contraseña no es válida.";
                                }
                            }  
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>