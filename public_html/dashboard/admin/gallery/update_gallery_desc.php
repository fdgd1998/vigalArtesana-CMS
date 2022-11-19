<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $sql = "update company_info set value_info = '".$_POST["desc"]."' where key_info = 'gallery-desc'";
    
        if ($conn->exec($sql)) {
            echo "La descripción se ha editado correctamente.";
            $sitemap = readSitemapXML();
            changeSitemapUrl($sitemap, GetBaseUri()."/"."galeria", GetBaseUri()."/"."galeria");
            writeSitemapXML($sitemap);
        } else {
            echo "Ha ocurrido un error al editar la descripción o no ha cambiado.";
        }
    }
?>