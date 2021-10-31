<?php
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
    */
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    require_once '../connection.php';
    $GLOBALS["site_settings"] = array();
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        header("Location: ./error.php");
        die();
    } else {
        $sql = "select value_info from company_info";
        if ($res = $conn->query($sql)) {
            while ($rows = $res->fetch_assoc()) {
                array_push($GLOBALS["site_settings"], $rows['value_info']);
            }
        }
    }
    $GLOBALS["site_settings"][4] = json_decode($GLOBALS["site_settings"][4], true);
    $GLOBALS["site_settings"][8] = json_decode($GLOBALS["site_settings"][8], true);
    $conn->close();
?>