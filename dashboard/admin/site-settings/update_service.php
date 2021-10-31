<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    require_once '../../../scripts/connection.php';

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
                    $temp = explode(".", $_FILES["image"]["name"]); //getting current filename
                    $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                    move_uploaded_file($_FILES['image']['tmp_name'],$location.$newfilename); //moving file to the server.

                    // undating entry on database
                    $stmt = "select image from services where id = ".$_POST["id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                    } else {
                        echo "Ha ocurrido un error mientras se borraba la imagen.";
                    }
                    $res->free(); //releasing results from RAM.

                    $stmt = "update services set image = '".$newfilename."' where id = ".$_POST["id"];
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
                    $temp = explode(".", $_FILES["image"]["name"]); //getting current filename
                    $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                    move_uploaded_file($_FILES['image']['tmp_name'],$location.$newfilename); //moving file to the server.

                    // undating entry on database
                    $stmt = "select image from services where id = ".$_POST["id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                    } else {
                        echo "Ha ocurrido un error mientras se borraba la imagen.";
                    }
                    $res->free(); //releasing results from RAM.

                    $stmt = "update services set title = '".$_POST["title"]."', image = '".$newfilename."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "El título y la imagen del servicio se han actualizado correctamente.";
                    } else {
                        echo "No se han podido actualizar el título y la imagen del servicio.";
                    }
                } else { //changing service description and image
                    $temp = explode(".", $_FILES["image"]["name"]); //getting current filename
                    $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                    move_uploaded_file($_FILES['image']['tmp_name'],$location.$newfilename); //moving file to the server.

                    // undating entry on database
                    $stmt = "select image from services where id = ".$_POST["id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                    } else {
                        echo "Ha ocurrido un error mientras se borraba la imagen.";
                    }
                    $res->free(); //releasing results from RAM.

                    $stmt = "update services set title = '".$_POST["title"]."', description = '".$_POST["description"]."', image = '".$newfilename."' where id = ".$_POST["id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La descripción y la imagen del servicio se han actualizado correctamente.";
                    } else {
                        echo "No se han podido actualizar la descripción y la imagen del servicio.";
                    }
                }
            } 
            $conn->close(); //closing database connection
        } catch (Exception $e) {
            echo $e;
        }
    }
?>