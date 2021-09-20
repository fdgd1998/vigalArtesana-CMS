<?php
    function getHttpProtocol() {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            return 'https';
        } else {
            return 'http';
        }
    }
?>