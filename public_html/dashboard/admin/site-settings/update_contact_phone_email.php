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
        $sql = array (
            "update company_info set value_info='".$_POST["phone"]."' where key_info='phone'",
            "update company_info set value_info='".$_POST["email"]."' where key_info='email'"
        );

        if ($conn->transaction($sql)) {
            $sitemap = readSitemapXML();
            changeSitemapUrl($sitemap, GetBaseUri()."contacto", GetBaseUri()."contacto");
            writeSitemapXML($sitemap);
            echo "Los datos de contacto se han modificado correctamente.";
        } else {
            echo "Ha ocurrido un error al modificar los datos de contacto.";
        }
    }
?>