<?php
    session_start();
    require_once '../../../modules/connection.php';
    require_once '../../../modules/crypt.php';
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }
    if(isset($_POST['username']) && $_SESSION['account_type'] != 'publisher') {
        $user = $_POST['username'];

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = $conn->prepare("select username from users where username = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user_db);

            // Si hay resultado, el usuario existe
            if ($stmt->num_rows == 1) {
                http_response_code(412);
            } else {
                http_response_code(200);
            }
        }
    } else if(isset($_POST['email']) && $_SESSION['account_type'] != 'publisher') {
        $email = $_POST['email'];

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = $conn->prepare("select email from users where email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($email_db);

            // Si hay resultado, el usuario existe
            if ($stmt->num_rows == 1) {
                http_response_code(412);
            } else {
                http_response_code(200);
            }
        }
    } else {
        header("Location: ../../../../403.php");
        exit();
    }
?>