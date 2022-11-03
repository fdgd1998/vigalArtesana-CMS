<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    if (!isset($_SESSION['loggedin'])) {
        include_once $_SERVER["DOCUMENT_ROOT"]."/errorpages/403.php";
        exit();
    }
?>
