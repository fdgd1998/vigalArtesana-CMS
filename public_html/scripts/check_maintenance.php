<?php 
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    
    function underMaintenance() {
        try {
            include_once dirname(__DIR__, 2).'/connection.php';
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            $sql = "select value_info form company_info where key_info = 'maintenance'";
            if ($res = $conn->query($sql)) {
                if ($res->fetch_assoc()["value_info"]) return true;
                else return false;
            }
        } catch (Exception $e) {
            echo $e;
        }
        return false;
    }
?>
