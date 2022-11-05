<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    function HasPermission($permName) {
        $conn = new DatabaseConnection();
        $permissions = array 
            (
              "manage_advancedSettings" =>  "10000000",
              "manage_gallery" =>  "01000000",
              "manage_companySettings" =>  "00100000",
              "manage_services" =>  "00010000",
              "manage_users" =>  "00001000",
              "manage_siteSettings" =>  "00000100",
              "manage_seoSettings" => "00000010",
              "standard_user" =>  "00000001"
            );
        
        $userPerm = 1;
        if ($permName != "no_user") {
            $sql = "select permissions from user_roles inner join users on users.account_type = user_roles.id where users.id = '".$_SESSION["userid"]."'";
            
            $res = $conn->query($sql);
            $userPerm = $res[0]["permissions"];

            return (($userPerm & bindec($permissions[$permName])) == bindec($permissions[$permName])) ? true : false;
        }
        return $userPerm;
        
    }
?>
