<?php
    function validatePasswd($passwd) {
        $regex = "/^(?=(.*[a-z]){1,})(?=(.*[A-Z]){1,})(?=(.*[0-9]){1,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{8,}$/";
        if (preg_match($regex, $passwd)) return true;
        else return false;
    }

    function validateEmail($email) {
        $regex = "/[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}/";
        if (preg_match($regex, $email)) return true;
        else return false;
    }
?>