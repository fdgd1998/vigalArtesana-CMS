<?php
    session_start();
    require_once '../../../modules/connection.php';
    require_once '../../../modules/crypt.php';

    // redirection to 403 is session is not started
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }
    // if required data is received and user is not a publisher, usernameis retrieved
    if(isset($_POST['username']) && $_SESSION['account_type'] != 'publisher') {
        $user = $_POST['username'];

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {

            // preparing statement
            $stmt = $conn->prepare("select username from users where username = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user_db);

            // if user exists, it can be used the same name
            if ($stmt->num_rows == 1) {
                http_response_code(412);
            } else {
                http_response_code(200);
            }
        }
    } else if(isset($_POST['email']) && $_SESSION['account_type'] != 'publisher') { //cheking email
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

            // if meial exists, it can be used the same name
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