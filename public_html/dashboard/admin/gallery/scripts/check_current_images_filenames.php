<?php
    session_start(); // Starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_session.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if ($_POST) {    
        $filenames = json_decode($_POST["filenames"]); 
        //echo var_dump($filenames);
        //Year in YYYY format.
        $year = date("Y");

        //Month in mm format, with leading zeros.
        $month = date("m");

        //Day in dd format, with leading zeros.
        $day = date("d");

        //The folder path for our file should be YYYY/MM/DD
        $directory = "$year/$month/$day/";

        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/images/";
        $fileExists = array();
        // echo var_dump($searchDir);
        if(is_dir($location.$directory)) {
            $searchDir = scandir($location.$directory);
            foreach($filenames as $filename) {
                if (in_array($filename, $searchDir)) {
                    array_push($fileExists, $filename);
                }
            }
        } 
        echo json_encode($fileExists);
    }

?>