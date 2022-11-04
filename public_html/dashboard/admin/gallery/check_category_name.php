<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    // Publishers cannot modify categories.
    if(isset($_POST['cat_name'])) {
        $conn = new DatabaseConnection();
        
        $sql = "select name from categories where name = ?";
        $params = array($_POST['cat_name']);
        
        // If there is results, the category name exists and cannot be used.
        if ($conn->preparedQuery($sql, $params)) {
            http_response_code(303);
        } else {
            http_response_code(200);
        }
    }
?>