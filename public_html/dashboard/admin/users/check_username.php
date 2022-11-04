<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new DatabaseConnection();
        
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $sql = "select username from users where username = '".$_POST["username"]."'";

                if ($conn->query($sql)) {
                    http_response_code(303);
                } else {
                    http_response_code(200);
                }
                $conn->close();
            }
        } catch (Exception $e) {
            $conn->close();
            echo $e;
        }
    }
?>