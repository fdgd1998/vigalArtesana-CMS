<?php
    session_start();

    // Redirecting to 403 page is session does not exist.
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    require_once '../../../scripts/connection.php';

    if ($_POST) {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/posts/"; // location for post images.

            if (isset($_POST['file_count']) && $_POST["file_count"] == 1) { // only one file is selected
                $temp = explode(".", $_FILES["image"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES['image']['tmp_name'],$location.$newfilename);

                if (!isset($_POST['images_to_remove'])) {
                    $current_images = "";
                    $stmt = "select images from posts where id=".$_POST['post_id'];
                    if ($res = $conn->query($stmt)) {
                        $row = $res->fetch_assoc();
                        $current_images = explode(",", $row['images']);
                    }
                    array_push($current_images, $newfilename);
                    $stmt = "update posts set category='".$_POST['category']."', title='".$_POST["title"]."', content='".$_POST["content"]."', images='".implode(",",$current_images)."' where id = ".$_POST['post_id'];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La entrada (1) se ha editado correctamente.";
                    } else {
                        echo "No se ha podido editar la entrada (1).";
                    }
                } else {
                    $current_images = "";
                    $stmt = "select images from posts where id=".$_POST['post_id'];
                    if ($res = $conn->query($stmt)) {
                        $row = $res->fetch_assoc();
                        $current_images = explode(",", $row['images']);
                        $images = explode(",", $_POST["images_to_remove"]);
                        foreach ($images as $image_to_remove) {
                            unlink($location.$image_to_remove);
                            if (($key = array_search($image_to_remove, $current_images)) !== false) {
                                unset($current_images[$key]);
                            }
                        }
                        array_push($current_images, $newfilename);
                        $stmt = "update posts set category='".$_POST['category']."', title='".$_POST["title"]."', content='".$_POST["content"]."', images='".implode(",",$current_images)."' where id = ".$_POST['post_id'];
                        if ($conn->query($stmt) == TRUE) {
                            echo "La entrada (2) se ha editado correctamente.";
                        } else {
                            echo "No se ha podido editar la entrada (2).";
                        }
                    }
                }
            } else if (isset($_POST['file_count']) && $_POST['file_count'] > 1) { //more than one file is selected.
                // If more than one user tries to upload a file at the same time, both can be called the same due to the implemented naming system.
                // In this case, one will be overwritted by the other.
                // To prevent this, the userid is attached at the end.
                $userid = 0;
                $fileNames = array(); //Array for storing filenames on the database.
                $i = 0;
                $sql = "select id from users where username = '".$_SESSION['user']."'";
                if ($res = $conn->query($sql)) {
                    $rows = $res->fetch_assoc();
                    $userid = $rows['id'];
                }
                $res->free(); // Releasing results from RAM.
                foreach ($_FILES as $file) { // Setting new filename for each file to upload
                    $temp = explode(".", $file["name"]); // Getting current filename.
                    $newfilename = round(microtime(true)+$i).$userid.'.'.end($temp); // Setting new filename.
                    move_uploaded_file($file['tmp_name'],$location.$newfilename); // Moving file to the server.
                    array_push($fileNames, $newfilename); // Adding filename to string.
                    $i++;
                }
                
                if (!isset($_POST['images_to_remove'])) {
                    $current_images = "";
                    $stmt = "select images from posts where id=".$_POST['post_id'];
                    if ($res = $conn->query($stmt)) {
                        $row = $res->fetch_assoc();
                        $current_images = explode(",", $row['images']);
                        $res->free(); // Releasing results from RAM.
                    }
                    
                    foreach($fileNames as $file) {
                        array_push($current_images, $file);
                    }
                    $stmt = "update posts set category='".$_POST['category']."', title='".$_POST["title"]."', content='".$_POST["content"]."', images='".implode(",",$fileNames)."' where id = ".$_POST['post_id'];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La entrada (3) se ha editado correctamente.";
                    } else {
                        echo "No se ha podido editar la entrada (3).";
                    }
                } else {
                    $current_images = "";
                    $stmt = "select images from posts where id=".$_POST['post_id'];
                    if ($res = $conn->query($stmt)) {
                        $row = $res->fetch_assoc();
                        $current_images = explode(",", $row['images']);
                        $images = explode(",", $_POST["images_to_remove"]);
                        foreach ($images as $image_to_remove) {
                            unlink($location.$image_to_remove);
                            if (($key = array_search($image_to_remove, $current_images)) !== false) {
                                unset($current_images[$key]);
                            }
                        }
                        foreach($fileNames as $file) {
                            array_push($current_images, $file);
                        }

                        $res->free(); // Releasing results from RAM.
                        $stmt = "update posts set category='".$_POST['category']."', title='".$_POST["title"]."', content='".$_POST["content"]."', images='".implode(",",$current_images)."' where id = ".$_POST['post_id'];
                        if ($conn->query($stmt) == TRUE) {
                            echo "La entrada (4) se ha editado correctamente.";
                        } else {
                            echo "No se ha podido editar la entrada (4).";
                        }
                    }
                }
            } else if (isset($_POST['images_to_remove']) && !isset($_POST['file_count'])) {
                $current_images = "";
                $stmt = "select images from posts where id=".$_POST['post_id'];
                if ($res = $conn->query($stmt)) {
                    $row = $res->fetch_assoc();
                    $current_images = explode(",", $row['images']);
                    $images = explode(",", $_POST["images_to_remove"]);
                    foreach ($images as $image_to_remove) {
                        unlink($location.$image_to_remove);
                        if (($key = array_search($image_to_remove, $current_images)) !== false) {
                            unset($current_images[$key]);
                        }
                    }
                    $res->free(); // Releasing results from RAM.
                    $stmt = "update posts set category='".$_POST['category']."', title='".$_POST["title"]."', content='".$_POST["content"]."', images='".implode(",",$current_images)."' where id = ".$_POST['post_id'];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La entrada se ha editado correctamente.";
                    } else {
                        echo "No se ha podido editar la entrada.";
                    }
                } 
            } else {
                $stmt = "update posts set category='".$_POST['category']."', title='".$_POST["title"]."', content='".$_POST["content"]."' where id = ".$_POST['post_id'];
                if ($conn->query($stmt) == TRUE) {
                    echo "La entrada se ha editado correctamente.";
                } else {
                    echo "No se ha podido editar la entrada.";
                    }
            }
        }
        $conn->close();
    }
?>