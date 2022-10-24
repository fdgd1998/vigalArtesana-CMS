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

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

    if (isset($_POST)) {
        try {
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $conn->begin_transaction();

                $conn->query("update company_info set value_info='".$_POST["phone"]."' where key_info='phone'");
                $conn->query("update company_info set value_info='".$_POST["email"]."' where key_info='email'");

                if ($conn->commit()) {
                    $sitemap = readSitemapXML();
                    changeSitemapUrl($sitemap, "https://vigalartesana.es/contacto", "https://vigalartesana.es/contacto");
                    writeSitemapXML($sitemap);
                    echo "Los datos de contacto se han modificado correctamente.";
                } else {
                    echo "Ha ocurrido un error al modificar los datos de contacto.";
                }
            }
            $conn->close();
        } catch (Exception $e) {
            $conn->rollback();
            echo $e;
        }
    }
?>