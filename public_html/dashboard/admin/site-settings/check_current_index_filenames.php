<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    if (isset($_POST)) {    
        $filename = $_POST["filenames"]; 

        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads//";
        $fileExists = array();
        
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