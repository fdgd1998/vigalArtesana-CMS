<?php
    error_reporting(0);
    session_start(); // Starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_session.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if ($_POST) {    
        $filename = $_POST["filenames"]; 

        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/";
        $fileExists = array();
        
        // echo var_dump($searchDir);
        if(is_dir($location)) {
            $searchDir = scandir($location);
            if (in_array($filename, $searchDir)) {
                http_response_code(412);
            }
        } else {
            http_response_code(200);
        }
    }

?>