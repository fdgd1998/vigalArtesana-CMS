<?php
    session_start();
    //error_reporting(0);
    
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../403.php");
        exit();
    }
    
    if ($_POST) {
        $user_form = trim($_POST['user']);
        $pass_form = trim($_POST['password']);

        require_once "./connection.php"; //datos de conexión
        require_once "./crypt.php"; //funciones criptograficas

        $mysqli = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        //Conexión a la base de datos
        if ($mysqli->connect_errno) {
            exit();
        } else {
            $enc_pass = OpenSSLEncrypt($pass_form);

            // Verificación de las credenciales de usuario
            $stmt = $mysqli->prepare("select username, passwd, account_type, account_enabled, passwd_reset from users where username = ?");
            $stmt->bind_param("s", $user_form);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user, $pass, $account_type, $account_enabled, $passwd_reset);

            // Si los datos coinciden, inicializo la sesión
            if ($stmt->num_rows == 1) {
                if($row = $stmt->fetch()) {
                    if (OpenSSLDecrypt($pass) == $pass_form) {
                        if ($account_enabled == "NO") {
                            echo "<script>alert('Esta cuenta ha sido deshabilitada. Contacta con el administrador del sitio.')</script>";
                            echo "<script>location.replace(location.origin+'/login.php')</script>";
                        } else if ($passwd_reset == "YES") {
                            echo "<script>alert('No se puede iniciar sesión porque tienes pendiente una recuperación de contraseña. Revisa tu bandeja de entrada para encontrar las intrucciones y restablecerla o contacta con el administrador del sitio.')</script>";
                            echo "<script>location.replace(location.origin+'/login.php')</script>";
                        } else {
                            $_SESSION['loggedin'] = true;
                            $_SESSION['user'] = $user_form;
                            $_SESSION['account_type'] = $account_type;
                            header("Location: ../dashboard/?page=start");
                            exit();
                        }
                    } else {
                        header("Location: ../login.php?wrong_pass=true");
                        exit(); 
                    }
                } 
            } else {
                header('Location: ../login.php?wrong_user=true');
                exit();
            }
        }
        $mysqli->close();
    }
?>