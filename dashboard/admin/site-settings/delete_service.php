<?php
    session_start();
    require_once '../../../scripts/connection.php';

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                echo $_POST["service_id"];
                $stmt = "select image from services where id = ".$_POST['service_id']."";

                if ($res = $conn->query($stmt)) {
                    $rows = $res->fetch_assoc();
                    unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/services/".$rows['image']); // deleting the file
                    $stmt = "delete from services where id = ".$_POST['service_id']."";
                    if ($res = $conn->query($stmt)) {
                        echo "El servicio se ha eliminado correctamente";
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>