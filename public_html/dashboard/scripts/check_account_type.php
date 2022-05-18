<?php
    function CheckAccountType($type) {
        if ($_SESSION['account_type'] == $type) return true;
        else return false;
    }
?>