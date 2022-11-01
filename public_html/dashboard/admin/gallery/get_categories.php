<?php
    error_reporting(0);
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';

    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            $categories = array(); // Array to save categories
        
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $sql = "select id, name from categories";
                if ($res = $conn->query($sql)) {
                    while ($rows = $res->fetch_assoc()) {
                        $categories[$rows["id"]] = $rows["name"];
                    }
                    $res->free();
                }
                echo json_encode($categories);
            }
        } catch (Exception $e) {
            $conn->close();
            echo $e;
        }
    }
?>