<?php
    require_once '../../../modules/connection.php';

    if ($_POST) {

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $stmt = "select image from categories where id = ".$_POST["cat_id"];
            if ($res = $conn->query($stmt)) {
                $rows = $res->fetch_assoc();
                unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/categories/".$rows['image']);
            } else {
                echo "Ha ocurrido un error.";
            }

            $stmt = "delete from categories where id = ".$_POST['cat_id']."";
            if ($conn->query($stmt) === TRUE) {
                echo "La categoría se ha eliminado correctamente.";
            } else {
                echo "No se ha podido borrar la categoría.";
            }
        }
    }
?>