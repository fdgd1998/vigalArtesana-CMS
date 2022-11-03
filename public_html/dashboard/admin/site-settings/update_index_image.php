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
        echo var_dump($_FILES);
        $sql = "update company_info set value_info='".$_FILES["image0"]["name"]."' where key_info='index-image'";

        if ($conn->query($sql)) {
            move_uploaded_file($_FILES["image0"]['tmp_name'],$location.$_FILES["image0"]["name"]); 
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