<?php
    if ($_POST) {
        require_once '../../../modules/connection.php';
        require_once '../../../modules/crypt.php';

        $user = $_POST['username_s'];
        $name = OpenSSLEncrypt($_POST['name_s']);
        $surname= OpenSSLEncrypt($_POST['surname_s']);
        $email = OpenSSLEncrypt($_POST['email_s']);
        $account_type = $_POST['account_s'];

        print("user: ".$user."<br>");
        print("name: ".$name."<br>");
        print("surname: ".$surname."<br>");
        print("email: ".$email."<br>");
        print("account type: ".$account_type."<br>");

        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $stmt = "insert into users (username, email, firstname, surname, account_type, account_enabled) values ('".$user."','".$email."','".$name."','".$surname."','".$account_type."','YES')";
            print($stmt);
            if ($conn->query($stmt) === TRUE) {
                http_response_code(200);
            } else {
                http_response_code(412);
            }
        }
    }
    
?>