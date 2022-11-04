<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads//";
        $conn = new DatabaseConnection();

        $image = "";
        $sql = "select value_info from company_info where key_info = 'index-image'";
        if ($res = $conn->query($sql)) {
            $image = $res[0]["value_info"];
        }

        $sql = array(
            "update company_info set value_info='".$_POST["image-desc"]."' where key_info='index-image-desc'",
            "update company_info set value_info='".$_FILES["image"]["name"]."' where key_info='index-image'"
        );

        if ($conn->transaction($sql)) {
            unlink($location.$image);
            move_uploaded_file($_FILES["image"]['tmp_name'],$location.$_FILES["image"]["name"]); 
            $sitemap = readSitemapXML();
            changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
            writeSitemapXML($sitemap);
            echo "La imagen se ha modificado correctamente.";
        }
        else {
            echo "Ha ocurrido un error editando la imagen.";
        }
    }
?>