<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if(isset($_POST['cat_id'])) {
        $cat_id = $_POST['cat_id'];
        $sql= "select image from categories where id = ".$cat_id;
        if ($res = $conn->query($sql)) {
            echo $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/".$res[0]["image"];
        } else {
            http_response_code(303);
        }
    }
?>