<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasAccessToResource("get_friendly_url")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    function StripAccents($string)
    {
        $replace = array('/é/','/í/','/ó/','/á/','/ñ/', '/ú/', '/ü/');
        $with = array('e','i','o','a', 'n', 'u', 'u');
    
        $newstring = preg_replace($replace, $with, $string);
    
        return $newstring;
    }
    
    function GetFriendlyUrl ($string) {
        return str_replace(" ", "-", strtolower(StripAccents($string)));
    }
?>