<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        include_once $_SERVER["DOCUMENT_ROOT"]."/errorpages/403.php";
        exit();
    }

    session_start();

    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php"; //datos de conexión

    function registerIp($conn) {
        $ip = $_SERVER["REMOTE_ADDR"];
        $sql = "insert into ip_register (address ,timestamp) values ('$ip', CURRENT_TIMESTAMP)";

        if ($conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }

    function maximumAttemps($conn) {
        $ip = $_SERVER["REMOTE_ADDR"];
        $sql = "select count(address) from ip_register where address = '$ip' and timestamp > (now() - interval 10 minute) and login_success = 0";

        if ($res = $conn->query($sql)) {
            $attempts = $res->fetch_assoc()["count(address)"];
            if ($attempts > 3) {
                $_SESSION["error"] = "Has superado el número de intentos permitidos. Inténtalo de nuevo en 10 minutos.";
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    if ($_POST) {
        $user_form = trim($_POST['user']);
        $pass_form = trim($_POST['password']);

        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            //Conexión a la base de datos
            if ($conn->connect_errno) {
                echo "Ha ocurrido un error conectando con la base de datos.";
                exit();
            } else { 
                registerIp($conn);

                if (!maximumAttemps($conn)) {
                    // Verificación de las credenciales de usuario
                    $sql = $conn->prepare("select users.id, users.username, users.passwd, user_roles.role, users.account_enabled, users.passwd_reset from users inner join user_roles on user_roles.id = users.account_type where username = ?");
                    $sql->bind_param("s", $user_form);
                    $sql->execute();
                    $sql->store_result();
                    $sql->bind_result($userid, $user, $pass, $account_type, $account_enabled, $passwd_reset);

                    // Si los datos coinciden, inicializo la sesión
                    if ($sql->num_rows == 1) {
                        if($row = $sql->fetch()) {
                            if (password_verify($pass_form, $pass)) {
                                if ($account_enabled == 0) {
                                    $_SESSION["error"] = "Esta cuenta ha sido deshabilitada. Contacta con el administrador del sitio.";
                                } else if ($passwd_reset == 1) {
                                    $_SESSION["error"] = "No se puede iniciar sesión porque tienes pendiente una recuperación de contraseña. Revisa tu bandeja de entrada para encontrar las intrucciones y restablecerla o contacta con el administrador del sitio.";
                                } else {
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['user'] = $user_form;
                                    $_SESSION['userid'] = $userid;
                                    $sql = "update ip_register set login_success = 1 where address = '".$_SERVER["REMOTE_ADDR"]."'";
                                    $conn->query($sql);
                                    $conn->close();
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
                }
                
                header("Location: ../login");
                exit();
            }
                
        } catch (Exception $e) {
            echo $e;
        }
    }
?>