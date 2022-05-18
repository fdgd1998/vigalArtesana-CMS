<?php
    session_start();
    
    if ($_POST) {
        $user_form = trim($_POST['user']);
        $pass_form = trim($_POST['password']);

        require_once dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php"; //datos de conexión

        $mysqli = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        //Conexión a la base de datos
        if ($mysqli->connect_errno) {
            exit();
        } else {

            // Verificación de las credenciales de usuario
            $stmt = $mysqli->prepare("select users.id, users.username, users.passwd, user_roles.role, users.account_enabled, users.passwd_reset from users inner join user_roles on user_roles.id = users.account_type where username = ?");
            $stmt->bind_param("s", $user_form);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($userid, $user, $pass, $account_type, $account_enabled, $passwd_reset);
            $mysqli->close();

            // Si los datos coinciden, inicializo la sesión
            if ($stmt->num_rows == 1) {
                if($row = $stmt->fetch()) {
                    if (password_verify($pass_form, $pass)) {
                        if ($account_enabled == 0) {
                            $_SESSION["error"] = "Esta cuenta ha sido deshabilitada. Contacta con el administrador del sitio.";
                        } else if ($passwd_reset == 1) {
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