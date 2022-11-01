<?php
    error_reporting(0);
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/reset_password_function.php";
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST["useremail"])) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $isSend = resetPassword($_POST["useremail"], $conn);
                if ($isSend) {
                    echo "Se ha enviado la solicitud de restablecimiento de contraseña.";
                } else {
                echo "Ha ocurrido un error al enviar la solicitud de restablecemiento de la contraseña.";
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>