<?php
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