<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasAccessToResource("create_gallery_items")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/images/"; // location for post images.
                $categories = json_decode($_POST["categories"]);
                //more than one file is selected.
                // If more than one user tries to upload a file at the same time, both can be called the same due to the implemented naming system.
                // In this case, one will be overwritted by the other.
                // To prevent this, the userid is attached at the end.
                $userid = 0;
                // $fileNames = ""; // String for storing filenames on the database.
                $i = 0;
                $sql = "select id from users where username = '".$_SESSION['user']."'";
                if ($res = $conn->query($sql)) {
                    $rows = $res->fetch_assoc();
                    $userid = $rows['id'];
                    foreach ($_FILES as $file) { // Setting new filename for each file to upload
                        $temp = explode(".", $file["name"]); // Getting current filename.
                        $newfilename = round(microtime(true)+$i).$userid.'.'.end($temp); // Setting new filename.
                        move_uploaded_file($file['tmp_name'],$location.$newfilename); // Moving file to the server.
                        $stmt = "insert into gallery (filename,category,uploadedBy) values ('".$newfilename."',".$categories[$i].",'".$_SESSION["user"]."')";
                        $conn->query($stmt);
                        $i++;
                    }
                    echo "Las imágenes se han subido correctamente.";
                    $res->free();
                } else {
                    echo "Ha ocurrido un error subiendo las imágenes.";
                }
            }
            $conn->close();
        } catch (Exception $e) {
            echo $e;
        }
    }
?>