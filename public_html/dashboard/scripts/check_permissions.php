<?php
    function HasPermission($pageName) {
        require dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php";
        
        $pages = array 
            (
              "show_categories" =>  "100000000",
              "show_gallery" =>  "010000000",
              "manage_categories" =>  "001000000",
              "manage_gallery" =>  "000100000",
              "manage_companySettings" =>  "000010000",
              "manage_services" =>  "000001000",
              "manage_users" =>  "000000100",
              "manage_siteSettings" =>  "000000010",
              "standard_user" =>  "000000001"
            );
        
        $userPerm = 0;
        
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        $conn->set_charset("utf8");
    
        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $sql = "select permissions from users inner join user_roles on users.account_type = user_roles.id where users.id = ".$_SESSION["userid"];
            if ($res = $conn->query($sql)) {
                $userPerm = $res->fetch_assoc()["permissions"];
            }
        }
        
        $conn->close();

        return (($userPerm & bindec($pages[$pageName])) == bindec($pages[$pageName])) ? true : false;
        
    }
?>
