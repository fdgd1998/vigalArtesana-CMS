<?php
    if (!isset($_SESSION['loggedin'])) {
        header("Location: /403");
        exit();
    }
?>