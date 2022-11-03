<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/XMLSitemapFunctions.php';
    
    if (isset($_POST)) {
        $conn = new DatabaseConnection();

        $sql = "delete from services where id = ".$_POST['service_id'];
        $image = $conn->query("select image from services where id = ".$_POST['service_id'])[0]["image"];

        if ($conn->query($sql)) {
            unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/services/".$image);
            $sitemap = readSitemapXML();
            changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
            writeSitemapXML($sitemap);
            echo "El servicio se ha eliminado correctamente";
                
        } else {
            echo "Ha ocurrido un error.";
        }
    }
?>