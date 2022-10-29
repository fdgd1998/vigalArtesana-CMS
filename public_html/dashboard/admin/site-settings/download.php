<?php
    session_start(); // starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';

    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    if ($_GET) {
        $file = $_SERVER["DOCUMENT_ROOT"]."/".$_GET['file'];
        
        if(!file_exists($file)){ // file does not exist
            die('File not found');
        } else {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=".basename($file));
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($file));
        
            // read the file from disk
            readfile($file);
        }
    }
?>