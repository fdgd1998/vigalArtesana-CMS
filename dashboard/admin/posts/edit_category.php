<?php
    require_once '../../../modules/connection.php';

    if ($_POST) {

        $location = "../../../uploads/categories/";
        
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES['file']['tmp_name'],$location.$newfilename);

            $stmt = "select image from categories where id = ".$_POST["cat_id"];
            if ($res = $conn->query($stmt)) {
                $rows = $res->fetch_assoc();
                unlink($_SERVER["DOCUMENT_ROOT"].$location.$rows['image']);
            } else {
                echo "Ha ocurrido un error.";
            }
            
            $stmt = "update categories set name = '".$_POST['cat_name']."', image = '".$newfilename."' where id = ".$_POST["cat_id"];
            if ($conn->query($stmt) === TRUE) {
                echo "La categoría se ha actualizado correctamente.";
            } else {
                echo "No se ha podido actualizar la categoría.";
            }
        }
    }
?>