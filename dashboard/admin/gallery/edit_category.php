<?php
    session_start();
    require_once '../../../scripts/check_session.php';
    require_once '../../../../connection.php';
    require_once 'scripts/get_friendly_url.php';
    
    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); //opening databas connection

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $location = "../../../uploads/categories/"; //location for category images.

                if (!isset($_FILES["cat_file"]) && isset($_POST["cat_name"])) { // changing category name
                    $stmt = "update categories set name = '".$_POST['cat_name']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."' where id = ".$_POST["cat_id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "El nombre de la categoría se ha actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar la categoría.";
                    }
                } else if (isset($_FILES["cat_file"]) && isset($_POST["cat_name"])) { //changing both category name and image.
                    $stmt = "select image from categories where id = ".$_POST["cat_id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                        $res->free(); //releasing results from RAM.
                    } else {
                        echo "Ha ocurrido un error borrando la imagen actual.";
                    }

                    $temp = explode(".", $_FILES["cat_file"]["name"]); //getting current filename
                    $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                      
                    // updating entry on database
                    $stmt = "update categories set name = '".$_POST['cat_name']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."', image = '".$newfilename."' where id = ".$_POST["cat_id"];
                    if ($conn->query($stmt) == TRUE) {
                        move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$newfilename); //moving file to the server
                        echo "La imagen y el nombre de la categoría se han actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar la categoría.";
                    }
                } else if (isset($_FILES["cat_file"]) && !isset($_POST["cat_name"])){ //changing category image
                    $temp = explode(".", $_FILES["cat_file"]["name"]); //getting current filename
                    $newfilename = round(microtime(true)) . '.' . end($temp); //setting new filename
                    
                    // undating entry on database
                    $stmt = "select image from categories where id = ".$_POST["cat_id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        unlink($location.$rows['image']);
                        $res->free(); //releasing results from RAM.
                    } else {
                        echo "Ha ocurrido un error borrando la imagen actual.";
                    }
                    
                    $stmt = "update categories set image = '".$newfilename."' where id = ".$_POST["cat_id"];
                    if ($conn->query($stmt) == TRUE) {
                        move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$newfilename); //moving file to the server.
                        echo "La imagen de la categoría se ha actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar la imagen de la categoría.";
                    }
                }
            }
            $conn->close(); //closing database connection
        } catch (Exception $e) {
            echo $e;
        }
    }
?>