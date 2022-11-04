<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {    
        $filename = $_POST["filenames"]; 

        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/services/";
        $fileExists = array();
        
        if(is_dir($location)) {
            $searchDir = scandir($location);
            if (in_array($filename, $searchDir)) {
                http_response_code(303);
            }
        } else {
            http_response_code(200);
        }
    }

?>