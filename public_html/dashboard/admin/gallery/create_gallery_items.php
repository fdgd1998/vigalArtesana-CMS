<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_gallery")) {
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
                $altText = json_decode($_POST["alt_text"]);

                $i = 0;
                $sql = "select id from users where username = '".$_SESSION['user']."'";
                if ($res = $conn->query($sql)) {
                    $rows = $res->fetch_assoc();
                    $userid = $rows['id'];
                    foreach ($_FILES as $file) { // Setting new filename for each file to upload
                        //Year in YYYY format.
                        $year = date("Y");

                        //Month in mm format, with leading zeros.
                        $month = date("m");

                        //Day in dd format, with leading zeros.
                        $day = date("d");

                        //The folder path for our file should be YYYY/MM/DD
                        $directory = "$year/$month/$day/";

                        //If the directory doesn't already exists.
                        if(!is_dir($location.$directory)){
                            //Create our directory.
                            mkdir($location.$directory, 755, true);
                        }
                       
                        move_uploaded_file($file['tmp_name'],$location.$directory.$file["name"]); // Moving file to the server.
                        $stmt = "insert into gallery (filename,dir,category,altText,uploadedBy) values ('".$file["name"]."','".$directory."',".$categories[$i].",'".$altText[$i]."','".$_SESSION["user"]."')";
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