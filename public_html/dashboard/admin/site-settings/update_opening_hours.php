<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $stmt = "update company_info set value_info='".$_POST["hours"]."' where key_info='opening-hours'";
                if ($conn->query($stmt) === TRUE) {
                    echo "El horario se ha modificado correctamente.";
                    $sitemap = readSitemapXML();
                    changeSitemapUrl($sitemap, GetBaseUri()."/contacto", GetBaseUri()."/contacto");
                    writeSitemapXML($sitemap);
                } else {
                    echo "Ha ocurrido un error al modificar el horario.";
                }
            }
            $conn->close();
        } catch (Exception $e) {
            echo $e;
        }
        
    }
?>