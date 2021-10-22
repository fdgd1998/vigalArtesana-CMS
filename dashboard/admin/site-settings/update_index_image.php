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
            try {
                $location = $_SERVER["DOCUMENT_ROOT"]."/uploads//"; // location for post images.
                $i = 0;
                echo print_r($_FILES);
                foreach ($_FILES as $file) { // Setting new filename for each file to upload
                    $temp = explode(".", $file["name"]); // Getting current filename.
                    $newfilename = 'index.'.end($temp); // Setting new filename.
                    move_uploaded_file($file['tmp_name'],$location.$newfilename); // Moving file to the server.
                    $stmt = "update company_info set value_info='".$newfilename."' where key_info='index-image'";
                    $conn->query($stmt);
                    $i++;
                }
                $conn->close();
            } catch (Exception $e) {
                echo $e;
            }
        }
    }
?>