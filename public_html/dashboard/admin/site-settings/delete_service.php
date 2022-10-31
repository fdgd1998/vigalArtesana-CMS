<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
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
                $stmt = "select image from services where id = ".$_POST['service_id']."";

                if ($res = $conn->query($stmt)) {
                    $rows = $res->fetch_assoc();
                    unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/services/".$rows['image']); // deleting the file
                    $stmt = "delete from services where id = ".$_POST['service_id']."";
                    if ($conn->query($stmt) === TRUE) {
                        $sitemap = readSitemapXML();
                        changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
                        writeSitemapXML($sitemap);
                        echo "El servicio se ha eliminado correctamente";
                    }
                    $res->free();
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>