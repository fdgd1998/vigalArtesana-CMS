<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    if (!HasPermission("manage_seoSettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $data = array();
        $sql = "select title, description from pages_metadata where id_page = ".$_POST["id"];

        if ($res = $conn->query($sql)) {
            foreach ($res as $item)
            array_push($data, $item["title"], $item["description"]);
        }
        echo json_encode($data);
    }
?>