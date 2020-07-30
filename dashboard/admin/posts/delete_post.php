<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }
    require_once '../../../modules/connection.php';

    if ($_POST) {

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $stmt = "select images from posts where id = ".$_POST['post_id'];
            if ($res = $conn->query($stmt)) {
                $rows = $res->fetch_assoc();
                $images = explode(",", $rows["images"]); 
                foreach ($images as $item) {
                    unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/posts/".$item);
                }
            } else {
                echo "No se han podido borrar las imágenes.";
            }

            $stmt = "delete from posts where id = ".$_POST['post_id'];
            if ($conn->query($stmt) === TRUE) {
                echo "El post se ha eliminado correctamente.";
            } else {
                echo "No se ha podido borrar el post seleccionado.";
            }
        }
    }
?>