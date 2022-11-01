<?php
    error_reporting(0);
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';

    if (!HasPermission("manage_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            $data = array(); // Array to save categories
        
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $sql = "select title, description from pages_metadata where id_page = ".$_POST["id"];
                if ($res = $conn->query($sql)) {
                    $row = $res->fetch_assoc();
                    array_push($data, $row["title"], $row["description"]);
                    $res->free();
                }
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $conn->close();
            echo $e;
        }
    }
?>