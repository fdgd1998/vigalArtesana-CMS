<?php
    session_start();
    require_once '../../../scripts/check_session.php';
    require_once '../../../../connection.php';
    if (isset($_POST["filenames"])) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                // getting filename and deleting it
                $filenames = json_decode($_POST["filenames"], true);
                $images = "";
                for($i = 0; $i < count($filenames) - 1; $i++) {
                    $images .= "'".$filenames[$i]."',";
                }
                $images .= "'".$filenames[count($filenames) - 1]."'";
                $stmt = "delete from gallery where filename in(".$images.")";

                if ($conn->query($stmt) == TRUE) {
                    foreach($filenames as $id=>$image) {
                        unlink("../../../uploads/images/".$image); // deleting the file
                    }
                    echo "Las imágenes se han eliminado correctamente.";
                }
                $conn->close();
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>