<?php
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }
    $location = "../../../uploads/categories/";

    if ($_FILES['file']['error'] > 0) {
        echo "Ha ocurrido un error al subir el fichero";
    } else{
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        move_uploaded_file($_FILES['file']['tmp_name'],$location.$newfilename);
        
        require_once "../../../modules/connection.php";
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->errno) {
            echo "No se ha podido conectar con la base de datos.";
            exit();
        } else {
            $sql = "insert into categories (name, image) values ('".$_POST['cat_name']."','".$newfilename."')";
            if ($conn->query($sql) === TRUE) {
                echo "La imagen se ha subido correctamente.";
            }
        }
    }
?>