<?php
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
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); //opening databas connection

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/services/"; //location for category images.

                if (isset($_POST["title"]) && !isset($_POST["description"]) && !isset($_FILES["image"])) { // changing service title
                    $stmt = "update services set title = '".$_POST['title']."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "El nombre del servicio se ha actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar el nombre del servicio.";
                    }
                } else if (!isset($_POST["title"]) && isset($_POST["description"]) && !isset($_FILES["image"])) { //changing service description.
                    $stmt = "update services set description = '".$_POST['description']."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La descripción del servicio se ha actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar la descripción del servicio.";
                    }
                } else if (!isset($_POST["title"]) && !isset($_POST["description"]) && isset($_FILES["image"])){ //changing service image
                    // $temp = explode(".", $_FILES["image"]["name"]); //getting current filename
                    // $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                    move_uploaded_file($_FILES['image']['tmp_name'],$location.$_FILES["image"]["name"]); //moving file to the server.

                    // undating entry on database
                    $stmt = "select image from services where id = ".$_POST["id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                    } else {
                        echo "Ha ocurrido un error mientras se borraba la imagen.";
                    }
                    $res->free(); //releasing results from RAM.

                    $stmt = "update services set image = '".$_FILES["image"]["name"]."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La imagen del servicio se ha actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar la imagen del servicio.";
                    }
                } else if (isset($_POST["title"]) && isset($_POST["description"]) && !isset($_FILES["image"])) { //changing service title and description
                    $stmt = "update services set title = '".$_POST['title']."', description = '".$_POST["description"]."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "El nombre y la descripción servicio se han actualizado correctamente.";
                    } else {
                        echo "No se han podido actualizar el nombre y la descripción del servicio.";
                    }
                } else if (isset($_POST["title"]) && !isset($_POST["description"]) && isset($_FILES["image"])) { //changing service title and image
                    // $temp = explode(".", $_FILES["image"]["name"]); //getting current filename
                    // $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                    move_uploaded_file($_FILES['image']['tmp_name'],$location.$_FILES["image"]["name"]); //moving file to the server.

                    // undating entry on database
                    $stmt = "select image from services where id = ".$_POST["id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                    } else {
                        echo "Ha ocurrido un error mientras se borraba la imagen.";
                    }
                    $res->free(); //releasing results from RAM.

                    $stmt = "update services set title = '".$_POST["title"]."', image = '".$_FILES["image"]["name"]."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "El título y la imagen del servicio se han actualizado correctamente.";
                    } else {
                        echo "No se han podido actualizar el título y la imagen del servicio.";
                    }
                } else { //changing service description and image
                    // $temp = explode(".", $_FILES["image"]["name"]); //getting current filename
                    // $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                    move_uploaded_file($_FILES['image']['tmp_name'],$location.$_FILES["image"]["name"]); //moving file to the server.

                    // undating entry on database
                    $stmt = "select image from services where id = ".$_POST["id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                    } else {
                        echo "Ha ocurrido un error mientras se borraba la imagen.";
                    }
                    $res->free(); //releasing results from RAM.

                    $stmt = "update services set title = '".$_POST["title"]."', description = '".$_POST["description"]."', image = '".$_FILES["image"]["name"]."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La descripción y la imagen del servicio se han actualizado correctamente.";
                    } else {
                        echo "No se han podido actualizar la descripción y la imagen del servicio.";
                    }
                }
                $sitemap = readSitemapXML();
                changeSitemapUrl($sitemap, GetBaseUri(), GetBaseUri());
                writeSitemapXML($sitemap);
            } 
            $conn->close(); //closing database connection
        } catch (Exception $e) {
            echo $e;
        }
    }
?>