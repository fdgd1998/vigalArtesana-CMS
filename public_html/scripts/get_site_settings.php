<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    /*COMPANY_INFO table description
        0 => phone
        1 => location
        2 => name
        3 => email
        4 => social media
        5 => index image
        6 => index slogan
        7 => google maps link
        8 => opening hours
        9 => about us
        10 => index brief description
        11 => maintenance mode
        12 => gallery description
        13 => seo update
        14 => index image description
    */

    function getSiteSettings() {
        $conn = new DatabaseConnection();
        $res = $conn->query("select * from company_info");
        $res[8]["value_info"] = json_decode($res[8]["value_info"], true);
        $res[4]["value_info"] = json_decode($res[4]["value_info"], true);
        return $res;
    }
?>