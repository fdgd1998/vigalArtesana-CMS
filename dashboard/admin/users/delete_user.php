<?php
    session_start();
    require_once '../../../modules/connection.php';
    require_once '../../../modules/crypt.php';
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }
    if ($_POST) {
        $userid = $_POST['userid'];
        $email = "";
        $passwd_reset = "";

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = "select email, passwd_reset from users where id='".$userid."'";
            print("stmt: ".$stmt."<br>");
            if ($res = $conn->query($stmt)) {
                if ($row = $res->fetch_assoc()) {
                    $email = $row['email'];
                    $passwd_reset = $row['passwd_reset'];
                    print($email."<br>");
                    print($passwd_reset."<br>");
                }
            }
            $stmt = "delete from users where id='".$userid."'";
            $conn->query($stmt);
            if ($passwd_reset == "YES") {
                $stmt = "delete from password_reset where email='".$row['email']."'";
                if ($conn->query($stmt)) {
                    http_response_code(200);
                } else {
                    http_response_code(412);
                }
            }
        }
    }
    
?>