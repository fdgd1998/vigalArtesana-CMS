<?php
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_users")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    function getUserRoles() {
        $roles = array();

        $sql = "select id, role from user_roles";
        if ($res = $conn->query($sql)) {
            while ($rows = $res->fetch_assoc()) {
                array_push($roles, array("id" => $rows["id"], "role" => $rows["role"]));
            }
            $res->free();
        }

        return $roles;
    }
?>