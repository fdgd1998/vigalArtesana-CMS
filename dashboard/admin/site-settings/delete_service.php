<?php
    session_start();
    require_once '../../../scripts/check_session.php';
    require_once '../../../../connection.php';
    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $stmt = "select image from services where id = ".$_POST['service_id']."";

                if ($res = $conn->query($stmt)) {
                    $rows = $res->fetch_assoc();
                    unlink("../../../uploads/services/".$rows['image']); // deleting the file
                    $stmt = "delete from services where id = ".$_POST['service_id']."";
                    if ($conn->query($stmt) === TRUE) {
                        echo "El servicio se ha eliminado correctamente";
                    }
                    $res->free();
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>