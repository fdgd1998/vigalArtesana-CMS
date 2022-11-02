<?php
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';

    /*COMPANY_INFO table description
        0 => phone
        1 => location
        2 => name
        3 => email
        4 => social media
        5 => index image
        6 => image index description
        7 => google maps link
        8 => opening hours
        9 => about us
        10 => index brief description
        11 => maintenance mode
        12 => gallery description
        12 => seo update
    */

    function getSiteSettings() {
        $conn = new DatabaseConnection();
        $res = $conn->query("select * from company_info");
        return $res;
    }
?>