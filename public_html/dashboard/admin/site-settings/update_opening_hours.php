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
        $conn = new DatabaseConnection();
        $sql= "update company_info set value_info='".$_POST["hours"]."' where key_info='opening-hours'";
        if ($conn->exec($sql)) {
            echo "El horario se ha modificado correctamente.";
            $sitemap = readSitemapXML();
            changeSitemapUrl($sitemap, GetBaseUri()."/contacto", GetBaseUri()."/contacto");
            writeSitemapXML($sitemap);
        } else {
            echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
        }
        
    }
?>