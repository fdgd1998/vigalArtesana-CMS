<?php
    session_start();
    require_once '../../../scripts/check_session.php';
    require_once '../../../../connection.php';

    if(isset($_POST['cat_id']) && $_SESSION['account_type'] != 'publisher') {
        $cat_id = $_POST['cat_id'];

        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $stmt = "select image from categories where id = ".$cat_id;
                if ($res = $conn->query($stmt)) {
                    $row = $res->fetch_assoc();
                    echo "../../../uploads/categories/".$row["image"];
                    $res->free();
                    $conn->close();
                } else {
                    $conn->close();
                    http_response_code(412);
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>