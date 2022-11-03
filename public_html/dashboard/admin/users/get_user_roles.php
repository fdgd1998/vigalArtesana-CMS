<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    function getUserRoles() {
        $conn = new DatabaseConnection();
        $roles = array();

        $sql = "select id, role from user_roles";
        if ($res = $conn->query($sql)) {
            foreach ($res as $item) {
                array_push($roles, array("id" => $item["id"], "role" => $item["role"]));
            }
        }

        return $roles;
    }
?>