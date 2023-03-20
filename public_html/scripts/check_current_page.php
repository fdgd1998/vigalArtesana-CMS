<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";

    function currentPage($uri, $page) {
        if (strcmp($uri, "") == 0 && strcmp($page, "") == 0) {
            return true;
        } else if (str_contains($uri, $page) && strcmp($page, "") != 0) {
            return true;
        }
        return false;
    }
?>