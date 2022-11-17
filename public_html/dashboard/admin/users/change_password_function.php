<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/validation.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    function updatePasswordRandom($pass, $userid, $modifiedBy) {
        $conn = new DatabaseConnection();
        if (validatePasswd($pass)) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "update users set passwd = '$hash', modifiedBy = $modifiedBy where id = '$userid'";
            if ($conn->exec($sql)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    function updatePassword($pass1, $pass2, $userid, $modifiedBy, $current = null) {
        $conn = new DatabaseConnection();
        if (strcmp($pass1, $pass2) == 0 && validatePasswd($pass1) && validatePasswd($pass2)) {
            if ($current) {
                $sql = "select passwd from users where id = ".$userid;
                if ($res = $conn->query($sql)) {
                    $hash = password_hash($pass1, PASSWORD_DEFAULT);
                    $res = $conn->preparedQuery("update users set passwd = ?, modifiedBy = ? where id = ?", array($hash, $modifiedBy,$userid));
                    if (count($res) == 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                $hash = password_hash($pass1, PASSWORD_DEFAULT);
                $res = $conn->preparedQuery("update users set passwd = ?, modifiedBy = ? where id = ?", array($hash, $modifiedBy,$userid));
                if (count($res) == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
?>