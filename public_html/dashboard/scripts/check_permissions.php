<?php
    function HasAccessToResource($name) {
        require dirname($_SERVER["DOCUMENT_ROOT"], 1)."/connection.php";
        $permission = 0;
        
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        $conn->set_charset("utf8");
    
        if ($conn->connect_error) {
            print("No se ha podido conectar a la base de datos");
            exit();
        } else {
            $sql = "select ".$name." from user_permissions where id = ".$_SESSION["userid"];
            
            if ($res = $conn->query($sql)) {
                $permission = $res->fetch_assoc()[$name];
            }
        }
        
        $conn->close();
        
        return $permission;
    }
?>