<?php  
    session_start();
    
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/gallery/scripts/get_friendly_url.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/"; // location for uploaded images.

    if ($_FILES['file']['error'] > 0) { // An arror has ocurred getting the file from the client.
        echo "Ha ocurrido un error al subir el fichero";
    } else{
        
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->errno) {
                echo "No se ha podido conectar con la base de datos.";
                exit();
            } else {
                // If more than one user tries to upload a file at the same time, both can be called the same due to the implemented naming system.
                // In this case, one will be overwritted by the other.
                // To prevent this, the userid is attached at the end.
                $userid = 0;
                $sql = "select id from users where username = '".$_SESSION['user']."'";
                if ($res = $conn->query($sql)) {
                    $rows = $res->fetch_assoc();
                    $userid = $rows['id'];
                    $res->free();
                }
                // $temp = explode(".", $_FILES["file"]["name"]); // Getting current filename
                // $newfilename = round(microtime(true)).$userid.'.'.end($temp); // Setting new filename

                // Saving the name and the image filename into database.
                $sql = "insert into categories (friendly_url, name, description, image, uploadedBy) values ('".GetFriendlyUrl($_POST["cat_name"])."','".$_POST['cat_name']."','".$_POST["cat_desc"]."' ,'".$_FILES['file']["name"]."','".$_SESSION["user"]."')";
                if ($conn->query($sql) === TRUE) {
                    move_uploaded_file($_FILES['file']['tmp_name'],$location.$_FILES['file']["name"]); // Moving file to the server
                    echo "La categoría se ha creado correctamente.";
                }
            }
            $conn->close();
        } catch (Exception $e) {
            $conn->close();
            echo $e;
        }
    }
?>