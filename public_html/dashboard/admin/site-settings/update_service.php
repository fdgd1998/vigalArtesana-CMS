<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/services/"; //location for category images.

        if (isset($_POST["title"]) && !isset($_POST["description"]) && !isset($_FILES["image"])) { // changing service title
            $sql = "update services set title = '".$_POST['title']."' where id = ".$_POST["id"];
            if ($conn->query($sql)) {
                echo "El nombre del servicio se ha actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar el nombre del servicio.";
            }
        } else if (!isset($_POST["title"]) && isset($_POST["description"]) && !isset($_FILES["image"])) { //changing service description.
            $sql = "update services set description = '".$_POST['description']."' where id = ".$_POST["id"];
            if ($conn->query($sql)) {
                echo "La descripción del servicio se ha actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar la descripción del servicio.";
            }
        } else if (!isset($_POST["title"]) && !isset($_POST["description"]) && isset($_FILES["image"])){ //changing service image
            // updating entry on database
            $sql = "select image from services where id = ".$_POST["id"];
            if ($res = $conn->query($sql)) {
                move_uploaded_file($_FILES['image']['tmp_name'],$location.$_FILES["image"]["name"]); //moving file to the server.
                unlink($location.$res[0]['image']);
            } else {
                echo "Ha ocurrido un error mientras se borraba la imagen.";
            }

            $sql= "update services set image = '".$_FILES["image"]["name"]."', image_desc = '".$_POST["image-desc"]."' where id = ".$_POST["id"];
            if ($conn->query($sql)) {
                echo "La imagen del servicio se ha actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar la imagen del servicio.";
            }
        } else if (isset($_POST["title"]) && isset($_POST["description"]) && !isset($_FILES["image"])) { //changing service title and description
            $sql= "update services set title = '".$_POST['title']."', description = '".$_POST["description"]."' where id = ".$_POST["id"];
            if ($conn->query($sql)) {
                echo "El nombre y la descripción servicio se han actualizado correctamente.";
            } else {
                echo "No se han podido actualizar el nombre y la descripción del servicio.";
            }
        } else if (isset($_POST["title"]) && !isset($_POST["description"]) && isset($_FILES["image"])) { //changing service title and image
            // undating entry on database
            $sql = "select image from services where id = ".$_POST["id"];
            if ($res = $conn->query($sql)) {
                move_uploaded_file($_FILES['image']['tmp_name'],$location.$_FILES["image"]["name"]); //moving file to the server.
                unlink($location.$res[0]['image']);
            } else {
                echo "Ha ocurrido un error mientras se borraba la imagen.";
            }

            $sql = "update services set title = '".$_POST["title"]."', image = '".$_FILES["image"]["name"]."', image_desc = '".$_POST["image-desc"]."' where id = ".$_POST["id"];
            if ($conn->query($sql) == TRUE) {
                echo "El título y la imagen del servicio se han actualizado correctamente.";
            } else {
                echo "No se han podido actualizar el título y la imagen del servicio.";
            }
        } else {

            // undating entry on database
            $sql = "select image from services where id = ".$_POST["id"];
            if ($res = $conn->query($sql)) {
                move_uploaded_file($_FILES['image']['tmp_name'],$location.$_FILES["image"]["name"]); //moving file to the server.
                unlink($location.$rows['image']);
            } else {
                echo "Ha ocurrido un error mientras se borraba la imagen.";
            }

            $sql = "update services set title = '".$_POST["title"]."', description = '".$_POST["description"]."', image = '".$_FILES["image"]["name"]."', image_desc = '".$_POST["image-desc"]."' where id = ".$_POST["id"];
            if ($conn->query($sql)) {
                echo "La descripción y la imagen del servicio se han actualizado correctamente.";
            } else {
                echo "No se han podido actualizar la descripción y la imagen del servicio.";
            }
        }
        $sitemap = readSitemapXML();
        changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
        writeSitemapXML($sitemap);
    }
?>