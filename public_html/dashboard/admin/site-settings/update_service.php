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
            if ($conn->exec($sql)) {
                echo "El nombre del servicio se ha actualizado correctamente.";
            } else {
                echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
            }
        } else if (!isset($_POST["title"]) && isset($_POST["description"]) && !isset($_FILES["image"])) { //changing service description.
            $sql = "update services set description = '".$_POST['description']."' where id = ".$_POST["id"];
            if ($conn->exec($sql)) {
                echo "La descripción del servicio se ha actualizado correctamente.";
            } else {
                echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
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
            if ($conn->exec($sql)) {
                echo "La imagen del servicio se ha actualizado correctamente.";
            } else {
                echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
            }
        } else if (isset($_POST["title"]) && isset($_POST["description"]) && !isset($_FILES["image"])) { //changing service title and description
            $sql= "update services set title = '".$_POST['title']."', description = '".$_POST["description"]."' where id = ".$_POST["id"];
            if ($conn->exec($sql)) {
                echo "El nombre y la descripción servicio se han actualizado correctamente.";
            } else {
                echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
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
            if ($conn->exec($sql) == TRUE) {
                echo "El título y la imagen del servicio se han actualizado correctamente.";
            } else {
                echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
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
            if ($conn->exec($sql)) {
                echo "La descripción y la imagen del servicio se han actualizado correctamente.";
            } else {
                echo "El contenido no ha cambiado o ha ocurrido un error al actualizar los datos.";
            }
        }
        $sitemap = readSitemapXML();
        changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
        writeSitemapXML($sitemap);
    }
?>