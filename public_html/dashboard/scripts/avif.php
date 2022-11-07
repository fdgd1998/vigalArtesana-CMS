<?php
    function createAvifImage($filename, $location) {
        $image_info = explode(".", $filename);
        if ($image_info[1] == "jpg") {
            $image = imagecreatefromjpeg($location.$filename);
            imageavif($image, $location.$image_info[0].".avif", 80);
        } else if ($image_info[1] == "png") {
            $image = imagecreatefrompng($location.$filename);
            imageavif($image, $location.$image_info[0].".avif", 80);
        }
    }
?>