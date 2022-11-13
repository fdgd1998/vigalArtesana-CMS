<?php
    error_reporting(0);
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/gallery/scripts/get_friendly_url.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $image_name = "";
        $cat_name = "";
        
        // checking if there are posts of the category to be deleted
        $sql = "select count(id) from gallery where category = ".$_POST["cat_id"];
        $count_images = $conn->query($sql)[0]["count(id)"];
        if ($count_images > 0) {
            echo "Existen imágenes pertenecientes a esta categoría. La categoría no se puede eliminar. Para borrarla, comprueba que no existen imágenes de dicha categoría e inténtalo de nuevo.";
        } else {
            // getting filename and deleting it
            $sql = "select friendly_url, image from categories where id = ".$_POST["cat_id"];
            if ($res = $conn->query($sql)) {
                $image_name = $res[0]['image'];
                $cat_name = $res[0]['friendly_url'];
            }
        
            $sql = array(
                "update pages set modifiedBy = ".$_SESSION["userid"]." where cat_id = ".$_POST['cat_id'],
                "update pages_metadata inner join pages on id_page = cat_id where id_page = ".$_POST['cat_id'],
                "delete from categories where id = '".$_POST['cat_id']."'",
                "delete from pages where cat_id = ".$_POST['cat_id'],
                "delete p from pages_metadata as p inner join pages on id_page = cat_id where id_page = ".$_POST['cat_id']
            );

            if ($conn->transaction($sql)) {
                unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/categories/".$image_name); // deleting the file
                $sitemap = readSitemapXML();
                changeSitemapUrl($sitemap, GetBaseUri()."/galeria", GetBaseUri()."/galeria");
                deleteSitemapUrl($sitemap, GetBaseUri()."/"."galeria/".$cat_name);
                writeSitemapXML($sitemap);
                echo "La categoría se ha eliminado correctamente.";
            } else {
                echo "Ha ocurrido un error al eliminar la categoría.";
            }
        }   
    }
?>