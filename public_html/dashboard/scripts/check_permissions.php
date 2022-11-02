<?php
    session_start();
    // require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    function HasPermission($permName) {
        // require dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php";
        $conn = new DatabaseConnection();
        $permissions = array 
            (
              "manage_gallery" =>  "1000000",
              "manage_companySettings" =>  "0100000",
              "manage_services" =>  "0010000",
              "manage_users" =>  "0001000",
              "manage_siteSettings" =>  "0000100",
              "manage_seoSettings" => "0000010",
              "standard_user" =>  "0000001"
            );
        
        $userPerm = 1;
        if ($permName != "no_user") {
        
            if ($conn->conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $sql = "select permissions from users inner join user_roles on users.account_type = user_roles.id where users.id = ".$_SESSION["userid"];
                if ($res = $conn->conn->query($sql)) {
                    $userPerm = $res->fetch_assoc()["permissions"];
                }
            }
            
            $conn->conn->close();

            return (($userPerm & bindec($permissions[$permName])) == bindec($permissions[$permName])) ? true : false;
        }
        return $userPerm;
        
    }
?>
