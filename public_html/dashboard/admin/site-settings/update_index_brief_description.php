<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/XMLSitemapFunctions.php";
    
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
                $stmt = "update company_info set value_info='".$_POST["description"]."' where key_info='index-brief-description'";
                if ($conn->query($stmt) === TRUE) {
                    $sitemap = readSitemapXML();
                    changeSitemapUrl($sitemap, "https://vigalartesana.es/", "https://vigalartesana.es/");
                    writeSitemapXML($sitemap);
                    echo "Se ha guardado correctamente.";
                } else {
                    echo "Ha ocurrido un error";
                }
                $conn->close();
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>