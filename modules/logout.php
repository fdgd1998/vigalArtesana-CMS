<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../403.php");
        exit();
    }
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
?>