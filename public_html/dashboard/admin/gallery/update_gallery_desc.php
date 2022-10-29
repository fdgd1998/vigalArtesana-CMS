<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    
    if (!HasPermission("manage_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            $image_name = "";
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                // checking if there are posts of the category to be deleted
                $stmt = "update company_info set value_info = '".$_POST["desc"]."' where key_info = 'gallery-desc'";
            
                if ($conn->query($stmt)) {
                    echo "La descripción se ha editado correctamente.";
                    $sitemap = readSitemapXML();
                    changeSitemapUrl($sitemap, GetBaseUri()."/"."galeria", GetBaseUri()."/"."galeria");
                    writeSitemapXML($sitemap);
                } else {
                    $conn->rollback();
                    echo "Ha ocurrido un error al editar la descripción.";
                }
            }
        } catch (Exception $e) {
            $conn->close();
            echo $e;
        }
    }
?>