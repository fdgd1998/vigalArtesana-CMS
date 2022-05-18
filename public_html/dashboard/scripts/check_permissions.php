<?php
    function HasPermission($pageName) {
        require dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php";
        
        $pages = array 
            (
              "show_categories" =>  "10000000",
              "show_gallery" =>  "01000000",
              "manage_categories" =>  "00100000",
              "manage_gallery" =>  "00010000",
              "manage_companySettings" =>  "00001000",
              "manage_services" =>  "00000100",
              "manage_users" =>  "00000010",
              "manage_siteSettings" =>  "00000001"
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
