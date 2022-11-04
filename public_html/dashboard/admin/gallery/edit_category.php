<?php
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
        $nameChange = false;
        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/"; //location for category images.

        $categoryUrlBefore = "";
        $sql = "select friendly_url from categories where id = ".$_POST["cat_id"];
        if ($res = $conn->query($sql)) {
            $categoryUrlBefore = $res[0]["friendly_url"];
        }
        $urlBefore = GetBaseUri()."/"."galeria/".$categoryUrlBefore;

        if (isset($_POST["cat_name"]) && !isset($_FILES["cat_file"]) && !isset($_POST["cat_desc"])) { // changing category name
            $sql = array(
                "update categories set name = '".$_POST['cat_name']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."' where id = ".$_POST["cat_id"],
                "update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"]
            );
            if ($conn->transaction($sql)) {
                $nameChange = true;
                echo "El nombre de la categoría se ha actualizado correctamente.";
            } else {
                $conn->rollBack();
                echo "No se ha podido actualizar la categoría.6";
            }
        } else if (!isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && !isset($_POST["cat_desc"])) {    
            // updating entry on database
            $image = "";
            $sql = "select image from categories where id = ".$_POST["cat_id"];
            if ($res = $conn->query($stmt)) {
                $image = $res[0]['image'];
            }
            $sql = "update categories set image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"];
            if ($conn->exec($sql)) {
                unlink($location.$image);
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server.
                echo "La imagen se ha actualiado correctamente.";
            } else {
                echo "Ha ocurrido un error borrando la imagen actual.";
            } 
        } else if (!isset($_POST["cat_name"]) && !isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
            $sql = "update categories set description = '".$_POST['cat_desc']."' where id = ".$_POST["cat_id"];
            if ($conn->exec($sql)) {
                echo "La descripción de la categoría se ha actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar la categoría.5";
            }
        } else if (isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && !isset($_POST["cat_desc"])) {
            $image = "";
            $stmt = "select image from categories where id = ".$_POST["cat_id"];
            if ($res = $conn->query($sql)) {
                $image = $res[0]['image'];
            }
            $sql = array(
                "update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"],
                "update categories set name = '".$_POST['cat_name']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."', image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"]
            );
            if ($conn->transaction($sql)) {
                $nameChange = true;
                unlink($location.$image);
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server
                echo "La imagen y el nombre de la categoría se han actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar la categoría.4";
            }
        } else if (!isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
            $image = "";
            $sql = "select image from categories where id = ".$_POST["cat_id"];
            if ($res = $conn->query($sql)) {
                $image = $res[0]['image'];
            }

            // updating entry on database
            $sql = "update categories set description = '".$_POST['cat_desc']."', image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"];
            if ($conn->exec($sql)) {
                unlink($location.$image);
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server
                echo "La imagen y descripción de la categoría se han actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar la categoría.3";
            }
        } else if (isset($_POST["cat_name"]) && !isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
            $sql = array(
                "update categories set name = '".$_POST['cat_name']."', description = '".$_POST['cat_desc']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."' where id = ".$_POST["cat_id"],
                "update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"]
            );
            if ($conn->transaction($sql)) {
                $nameChange = true;
                echo "El nombre y la descripción de la categoría se han actualizado correctamente.";
            } else {
                $conn->rollBack();
                echo "No se ha podido actualizar la categoría.1";
            }
        } else if (isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
            $image = "";
            $sql= "select image from categories where id = ".$_POST["cat_id"];
            if ($res = $conn->query($stmt)) {
                $image = $res[0]['image'];
            }

            $sql = array(
                "update categories set name = '".$_POST['cat_name']."', description = '".$_POST['cat_desc']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."', image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"],
                "update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"]
            );
            if ($conn->exec($sql)) {
                $nameChange = true;
                unlink($location.$image);
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server
                echo "El nombre, imagen y descripción de la categoría se han actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar la categoría.2";
            }
        }

        $categoryUrlAfter = "";
        $sql = "select friendly_url from categories where id = ".$_POST["cat_id"];
        if ($res = $conn->query($sql)) {
            $categoryUrlAfter = $res[0]["friendly_url"];
        }
        
        $total_pages = 0;
        $sql = "select count(id) from gallery where category = ".$_POST["cat_id"];
        if ($res = $conn->query($sql)) {
            $total_pages += intdiv($res[0]["count(id)"], 12);
            $total_pages += ($res[0]["count(id)"] % 12 != 0)? 1 : 0;
        }

        $sitemap = readSitemapXML();
        $urlAfter = GetBaseUri()."/"."galeria/".$categoryUrlAfter;
        if ($nameChange) {
            deleteSitemapUrl($sitemap, $urlBefore);
            for ($i = 2; $i <= $total_pages; $i++) {
                deleteSitemapUrl($sitemap, $urlBefore."/$i");
            }
            addSitemapUrl($sitemap, $urlAfter);
            for ($i = 2; $i <= $total_pages; $i++) {
                addSitemapUrl($sitemap, $urlAfter."/$i");
            }
        } else {
            changeSitemapUrl($sitemap, $urlAfter, $urlAfter);
            for ($i = 2; $i <= $total_pages; $i++) {
                changeSitemapUrl($sitemap, $urlAfter."/$i", $urlAfter."/$i");
            }
        }
        changeSitemapUrl($sitemap, GetBaseUri()."/galeria", GetBaseUri()."/galeria");
        writeSitemapXML($sitemap);
    }
?>