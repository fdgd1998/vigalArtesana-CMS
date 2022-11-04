<?php  
    error_reporting(0);
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/gallery/scripts/get_friendly_url.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/"; // location for uploaded images.

    if ($_FILES['file']['error'] > 0) { // An arror has ocurred getting the file from the client.
        echo "Ha ocurrido un error al subir el fichero";
    } else {
        $conn = new DatabaseConnection();
        
        $sql = "insert into categories (friendly_url, name, description, image, uploadedBy) values ('".GetFriendlyUrl($_POST["cat_name"])."','".$_POST['cat_name']."','".$_POST["cat_desc"]."' ,'".$_FILES['file']["name"]."','".$_SESSION["user"]."')";

        if ($conn->exec($sql)) {
            $sql = "select id from categories where name = '".$_POST["cat_name"]."'";
            if ($res = $conn->query($sql)) {
                $cat_id = $res[0]['id'];
                $sql = "insert into pages (page, cat_id) values ('galeria/".GetFriendlyUrl($_POST["cat_name"])."', ".$cat_id.")";
                if ($conn->exec($sql)) {
                    $sql = "select id from pages where cat_id = ".$cat_id;
                    if ($res = $conn->query($sql)) {
                        $sql = "insert into pages_metadata (title, description, id_page) values ('', '', ".$res[0]['id'].")";
                        if ($conn->exec($sql)) {
                            $sitemap = readSitemapXML();
                            changeSitemapUrl($sitemap, GetBaseUri()."/galeria", GetBaseUri()."/galeria");
                            addSitemapUrl($sitemap, GetBaseUri()."/"."galeria/".GetFriendlyUrl($_POST["cat_name"]));
                            writeSitemapXML($sitemap);
                            move_uploaded_file($_FILES['file']['tmp_name'],$location.$_FILES['file']["name"]); // Moving file to the server
                            echo "La categoría se ha creado correctamente.";
                        } else {
                            echo "Ha ocurrido un error al crear la categoría.";
                        }
                    } else {
                        echo "Ha ocurrido un error al crear la categoría.";
                    }
                } else {
                    echo "Ha ocurrido un error al crear la categoría.";
                }
            } 
        } else {
            echo "Ha ocurrido un error al crear la categoría.";
        }
    }
?>