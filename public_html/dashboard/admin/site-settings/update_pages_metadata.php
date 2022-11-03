<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_seoSettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $sql = "update pages_metadata set title='".$_POST["title"]."', description = '".$_POST["desc"]."' where id_page=".$_POST["id"];
        if ($conn->query($sql)) {
            $pageName = "";
            if ($_POST["id"] != 5) {
                $sql = "select page from pages where id = ".$_POST["id"];
                if ($res = $conn->query($sql)) {
                    $pageName = "/".$res[0]["page"]; 
                }
            }
            $sitemap = readSitemapXML();
            changeSitemapUrl($sitemap, GetBaseUri().$pageName, GetBaseUri().$pageName);
            writeSitemapXML($sitemap);
            echo "Los datos se han modificado correctamente.";
        } else {
            echo "Ha ocurrido un error al modificar los datos.";
        }
    }
?>