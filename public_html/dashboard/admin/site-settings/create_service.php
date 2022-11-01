<?php
    error_reporting(0);
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

            if ($conn->errno) {
                echo "No se ha podido conectar con la base de datos.";
                exit();
            } else {
                $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/services/"; // location for uploaded images.
                $sql = "insert into services (title, description, image) values ('".$_POST['title']."','".$_POST["description"]."','".$_FILES["file"]["name"]."')";
                if ($conn->query($sql) === TRUE) {
                    $sitemap = readSitemapXML();
                    changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
                    writeSitemapXML($sitemap);
                    move_uploaded_file($_FILES['file']['tmp_name'],$location.$_FILES["file"]["name"]); // Moving file to the server
                    
                    echo "La imagen se ha subido correctamente.";
                }
                echo $conn->error;
            }
            $conn->close();
        } catch (Exception $e) {
            echo $e;
        }
    }
?>