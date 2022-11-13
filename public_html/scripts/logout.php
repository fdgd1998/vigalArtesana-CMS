<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/database_connection.php";
    require_once "check_session.php";

    $conn = new DatabaseConnection();
    $sql = "insert into logs (text, type) values (concat('Logout, ID usuario: ', ".$_SESSION["userid"]."), 'login')";
    $conn->exec($sql);

    session_unset();
    session_destroy();
    
    header("Location: /");
    exit();
?>