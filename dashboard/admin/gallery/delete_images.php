<?php
    session_start();
    require_once '../../../scripts/connection.php';

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    if (isset($_POST["filenames"])) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                // getting filename and deleting it
                $filenames = json_decode($_POST["filenames"], true);
                echo var_dump($filenames);
                $images = "";
                for($i = 0; $i < count($filenames) - 1; $i++) {
                    $images .= "'".$filenames[$i]."',";
                }
                $images .= "'".$filenames[count($filenames) - 1]."'";
                $stmt = "delete from gallery where filename in(".$images.")";
                echo $stmt;
                if ($conn->query($stmt) == TRUE) {
                    foreach($filenames as $id=>$image) {
                        unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/images/".$image); // deleting the file
                    }
                }
                $conn->close();
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>