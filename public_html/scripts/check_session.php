<?php
    if (!isset($_SESSION['loggedin'])) {
        include_once $_SERVER["DOCUMENT_ROOT"]."/errorpages/403.php";
        exit();
    }
?>
