<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    require_once '../../../scripts/connection.php';

    if ($_POST) {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/posts/"; // location for post images.
            echo print_r($_FILES);
            if ($_POST["file_count"] == 1) { // only one file is selected
                $temp = explode(".", $_FILES["image"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES['image']['tmp_name'],$location.$newfilename);

                $stmt = "insert into posts (author, category, title, content, images) values ('".$_SESSION["user"]."', '".$_POST["category"]."', '".$_POST["title"]."', '".$_POST["content"]."', '".$newfilename."')";
                if ($conn->query($stmt) == TRUE) {
                    echo "La entrada se ha creado correctamente.";
                } else {
                    echo "No se ha podido crear la entrada.";
                }
            } else { //more than one file is selected.
                // If more than one user tries to upload a file at the same time, both can be called the same due to the implemented naming system.
                // In this case, one will be overwritted by the other.
                // To prevent this, the userid is attached at the end.
                $userid = 0;
                $fileNames = ""; // String for storing filenames on the database.
                $i = 0;
                $sql = "select id from users where username = '".$_SESSION['user']."'";
                if ($res = $conn->query($sql)) {
                    $rows = $res->fetch_assoc();
                    $userid = $rows['id'];
                }
                $res->free(); // Releasing results from RAM.
                foreach ($_FILES as $file) { // Setting new filename for each file to upload
                    $temp = explode(".", $file["name"]); // Getting current filename.
                    $newfilename = round(microtime(true)+$i).$userid.'.'.end($temp); // Setting new filename.
                    move_uploaded_file($file['tmp_name'],$location.$newfilename); // Moving file to the server.
                    $fileNames .= $newfilename.","; // Adding filename to string.
                    $i++;
                }
                $fileNames = substr($fileNames, 0, -1); // removing the last comma character
                
                // Saving post into the database.
                $stmt = "insert into posts (author, category, title, content, images) values ('".$_SESSION["user"]."', '".$_POST["category"]."', '".$_POST["title"]."', '".$_POST["content"]."', '".$fileNames."')";
                if ($conn->query($stmt) === TRUE) {
                    echo "La entrada se ha creado correctamente.";
                } else {
                    echo "No se ha podido crear la entrada";
                }
            }
        }
        $conn->close();
    }
?>