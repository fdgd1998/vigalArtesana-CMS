<?php
    session_start();
    
    if ($_POST) {
        $user_form = trim($_POST['user']);
        $pass_form = trim($_POST['password']);

        require_once "../../connection.php"; //datos de conexión

        $mysqli = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        //Conexión a la base de datos
        if ($mysqli->connect_errno) {
            exit();
        } else {

            // Verificación de las credenciales de usuario
            $stmt = $mysqli->prepare("select id, username, passwd, account_type, account_enabled, passwd_reset from users where username = ?");
            $stmt->bind_param("s", $user_form);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($userid, $user, $pass, $account_type, $account_enabled, $passwd_reset);
            $mysqli->close();

            // Si los datos coinciden, inicializo la sesión
            if ($stmt->num_rows == 1) {
                if($row = $stmt->fetch()) {
                    if (password_verify($pass_form, $pass)) {
                        if ($account_enabled == "NO") {
                            $_SESSION["error"] = "Esta cuenta ha sido deshabilitada. Contacta con el administrador del sitio.";
                        } else if ($passwd_reset == "YES") {
                            $_SESSION["error"] = "No se puede iniciar sesión porque tienes pendiente una recuperación de contraseña. Revisa tu bandeja de entrada para encontrar las intrucciones y restablecerla o contacta con el administrador del sitio.";
                        } else {
                            $_SESSION['loggedin'] = true;
                            $_SESSION['user'] = $user_form;
                            $_SESSION['userid'] = $userid;
                            $_SESSION['account_type'] = $account_type;
                            header("Location: ../dashboard/?page=start");
                            exit();
                        }
                    } else {
                        $_SESSION["error"] = "Usuario y/o contraseña incorrectos.";
                    }
                } 
            } else {
                $_SESSION["error"] = "Usuario y/o contraseña incorrectos.";
            }
            header("Location: ../login");
            exit();
        }
        
    }
?>