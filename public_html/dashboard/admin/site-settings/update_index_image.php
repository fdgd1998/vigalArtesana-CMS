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
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            try {
                $location = $_SERVER["DOCUMENT_ROOT"]."/uploads//"; // location for post images.
                $i = 0;
                foreach ($_FILES as $file) { // Setting new filename for each file to upload
                    // $temp = explode(".", $file["name"]); // Getting current filename.
                    // $newfilename = 'index.'.end($temp); // Setting new filename.
                    move_uploaded_file($file['tmp_name'],$location.$file["name"]); // Moving file to the server.
                    $stmt = "update company_info set value_info='".$file["name"]."' where key_info='index-image'";
                    if ($conn->query($stmt) === TRUE) {
                        $sitemap = readSitemapXML();
                        changeSitemapUrl($sitemap, "https://vigalartesana.es/", "https://vigalartesana.es/");
                        writeSitemapXML($sitemap);
                        echo "La imagen se ha modificado correctamente.";
                    }
                    else {
                        echo "Ha ocurrido un error editando la imagen.";
                    }
                    $i++;
                }
                $conn->close();
            } catch (Exception $e) {
                echo $e;
            }
        }
    }
?>