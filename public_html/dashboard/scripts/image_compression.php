<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_permissions.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";

    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"]."/dashboard/includes/forbidden.php";
        exit();
    }
    function uploadAndCompressImage($path, $fileObj) {
        $imageData = explode(".", $fileObj["name"]);

        $temp = $_SERVER["DOCUMENT_ROOT"]."/temp/";
        move_uploaded_file($fileObj['tmp_name'],$temp.$fileObj["name"]); // Moving file to the server.

        $img = null;
        if (strcmp($imageData[1], "png") == 0) {
            $img = imagecreatefrompng($temp.$fileObj["name"]);   // load the image-to-be-saved
            imagepng($img, $path.$fileObj["name"], 40);
        } else {
            $img = imagecreatefromjpeg($temp.$fileObj["name"]);   // load the image-to-be-saved
            imagejpeg($img, $path.$fileObj["name"], 40);
        }

        // 50 is quality; change from 0 (worst quality,smaller file) - 100 (best quality)

        unlink($temp.$fileObj["name"]);   // remove the old image
    }
    
?>