<?php
    function checkUrlDirectAcces($path, $path1) {
        if ( $_SERVER['REQUEST_METHOD']=='GET' && $path == $path1 ) {
            include_once $_SERVER["DOCUMENT_ROOT"]."/errorpages/403.php";
            exit();
        }
    }
?>