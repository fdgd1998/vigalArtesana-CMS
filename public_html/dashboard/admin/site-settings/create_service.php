<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";

    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $title = $_POST['title'];
        $desc = $_POST["description"];
        $image = $_FILES["file"]["name"];
        $image_desc = $_POST["image-desc"];
        $sql = "insert into services (title, description, image, image_desc) values ('".$title."','".$desc."','".$image."', '".$image_desc."')";
        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/services/"; // location for uploaded images.

        if ($conn->exec($sql)) {
            $sitemap = readSitemapXML();
            changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
            writeSitemapXML($sitemap);
            move_uploaded_file($_FILES['file']['tmp_name'],$location.$image); // Moving file to the server
            
            echo "La imagen se ha subido correctamente.";
        } else {
            echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
        }
    }
?>