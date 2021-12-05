<?php
    session_start();
    require_once "check_session.php";

    session_unset();
    session_destroy();
    
    header("Location: /");
    exit();
?>