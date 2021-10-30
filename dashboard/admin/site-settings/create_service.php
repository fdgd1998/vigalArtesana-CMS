<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    if ($_FILES['file']['error'] > 0) { // An arror has ocurred getting the file from the client.
        echo "Ha ocurrido un error al subir el fichero";
    } else {
        if (isset($_POST)) {
            echo var_dump($_FILES);
            require_once "../../../scripts/connection.php";
            try {
                $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

                if ($conn->errno) {
                    echo "No se ha podido conectar con la base de datos.";
                    exit();
                } else {
                    $location = "../../../uploads/services/"; // location for uploaded images.
                    // If more than one user tries to upload a file at the same time, both can be called the same due to the implemented naming system.
                    // In this case, one will be overwritted by the other.
                    // To prevent this, the userid is attached at the end.
                    $userid = 0;
                    $sql = "select id from users where username = '".$_SESSION['user']."'";
                    if ($res = $conn->query($sql)) {
                        $rows = $res->fetch_assoc();
                        $userid = $rows['id'];
                    }
                    $res->free(); // Releasing results from RAM.
                    
                    $temp = explode(".", $_FILES["file"]["name"]); // Getting current filename
                    $newfilename = round(microtime(true)).$userid.'.'.end($temp); // Setting new filename

                    $sql = "insert into services (title, description, image) values ('".$_POST['title']."','".$_POST["description"]."','".$newfilename."')";
                    if ($conn->query($sql) === TRUE) {
                        move_uploaded_file($_FILES['file']['tmp_name'],$location.$newfilename); // Moving file to the server
                        echo "La imagen se ha subido correctamente.";
                    }
                    echo $conn->error;
                }
                $conn->close();
            } catch (Exception $e) {
                echo $e;
            }
        }
    }
?>