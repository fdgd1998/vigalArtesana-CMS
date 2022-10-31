<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    
    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    function HasPermission($pageName) {
        require dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php";
        
        $pages = array 
            (
              "show_categories" =>  "1000000000",
              "show_gallery" =>  "0100000000",
              "manage_categories" =>  "0010000000",
              "manage_gallery" =>  "0001000000",
              "manage_companySettings" =>  "0000100000",
              "manage_services" =>  "0000010000",
              "manage_users" =>  "0000001000",
              "manage_siteSettings" =>  "0000000100",
              "standard_user" =>  "0000000010",
              "manage_seoSettings" => "0000000001"
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
