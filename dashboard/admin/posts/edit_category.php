<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    require_once '../../../modules/connection.php';

    if ($_POST) {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); //opening databas connection

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/"; //location for category images.

            if (!isset($_FILES["cat_file"]) && isset($_POST["cat_name"])) { // changing category image
                $stmt = "update categories set name = '".$_POST['cat_name']."' where id = ".$_POST["cat_id"];
                if ($conn->query($stmt) == TRUE) {
                    echo "La categoría (nombre) se ha actualizado correctamente.";
                } else {
                    echo "No se ha podido actualizar la categoría.";
                }
            } else if (isset($_FILES["cat_file"]) && isset($_POST["cat_name"])) { //changing both category name and image.
                $temp = explode(".", $_FILES["cat_file"]["name"]); //getting current filename
                $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$newfilename); //moving file to the server
                
                // updating entry on database
                $stmt = "update categories set name = '".$_POST['cat_name']."', image = '".$newfilename."' where id = ".$_POST["cat_id"];
                if ($conn->query($stmt) == TRUE) {
                    echo "La categoría (imagen y nombre) se ha actualizado correctamente.";
                } else {
                    echo "No se ha podido actualizar la categoría.";
                }
            } else if (isset($_FILES["cat_file"]) && !isset($_POST["cat_name"])){ //changing category name
                $temp = explode(".", $_FILES["cat_file"]["name"]); //getting current filename
                $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$newfilename); //moving file to the server.

                // undating entry on database
                $stmt = "select image from categories where id = ".$_POST["cat_id"];
                if ($res = $conn->query($stmt)) {
                    $rows = $res->fetch_assoc();
                    unlink($location.$rows['image']);
                } else {
                    echo "Ha ocurrido un error.";
                }
                $res->free(); //releasing results from RAM.

                $stmt = "update categories set image = '".$newfilename."' where id = ".$_POST["cat_id"];
                if ($conn->query($stmt) == TRUE) {
                    echo "La categoría (imagen) se ha actualizado correctamente.";
                } else {
                    echo "No se ha podido actualizar la categoría.";
                }
            }
        }
        $conn->close(); //closing database connection
    }
?>