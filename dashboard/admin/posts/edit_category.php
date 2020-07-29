<?php
    require_once '../../../modules/connection.php';

    if ($_POST) {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            // echo $_POST["cat_file"];
            $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/";

            if (!isset($_FILES["cat_file"]) && isset($_POST["cat_name"])) {
                $stmt = "update categories set name = '".$_POST['cat_name']."' where id = ".$_POST["cat_id"];
                if ($conn->query($stmt) == TRUE) {
                    echo "La categoría (nombre) se ha actualizado correctamente.";
                } else {
                    echo "No se ha podido actualizar la categoría.";
                }
            } else if (isset($_FILES["cat_file"]) && isset($_POST["cat_name"])) {
                $temp = explode(".", $_FILES["cat_file"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$newfilename);
                
                $stmt = "update categories set name = '".$_POST['cat_name']."', image = '".$newfilename."' where id = ".$_POST["cat_id"];
                if ($conn->query($stmt) == TRUE) {
                    echo "La categoría (imagen y nombre) se ha actualizado correctamente.";
                } else {
                    echo "No se ha podido actualizar la categoría.";
                }
            } else if (isset($_FILES["cat_file"]) && !isset($_POST["cat_name"])){
                $temp = explode(".", $_FILES["cat_file"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$newfilename);

                $stmt = "select image from categories where id = ".$_POST["cat_id"];
                if ($res = $conn->query($stmt)) {
                    $rows = $res->fetch_assoc();
                    unlink($location.$rows['image']);
                } else {
                    echo "Ha ocurrido un error.";
                }
                $res->free();

                $stmt = "update categories set image = '".$newfilename."' where id = ".$_POST["cat_id"];
                if ($conn->query($stmt) == TRUE) {
                    echo "La categoría (imagen) se ha actualizado correctamente.";
                } else {
                    echo "No se ha podido actualizar la categoría.";
                }
            }
        }
        $conn->close();
    }
?>