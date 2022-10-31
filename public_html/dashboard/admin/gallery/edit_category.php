<?php

    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/XMLSitemapFunctions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/gallery/scripts/get_friendly_url.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    
    if (!HasPermission("manage_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); //opening databas connection

            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/categories/"; //location for category images.

                if (isset($_POST["cat_name"]) && !isset($_FILES["cat_file"]) && !isset($_POST["cat_desc"])) { // changing category name
                    $conn->begin_transaction();
                    $conn->query("update categories set name = '".$_POST['cat_name']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."' where id = ".$_POST["cat_id"]);
                    $conn->query("update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"]);
                    if ($conn->commit()) {
                        echo "El nombre de la categoría se ha actualizado correctamente.";
                    } else {
                        $conn->rollback();
                        echo "No se ha podido actualizar la categoría.";
                    }
                } else if (!isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && !isset($_POST["cat_desc"])) {    
                    // updating entry on database
                    $conn->begin_transaction();
                    $image = "";
                    $stmt = "select image from categories where id = ".$_POST["cat_id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        $image = $rows['image'];
                        $res->free(); //releasing results from RAM.
                    }
                    $conn->query("update categories set image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"]);
                    if ($conn->commit()) {
                        unlink($location.$image);
                        move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server.
                        echo "La imagen se ha actualiado correctamente.";
                    } else {
                        $conn->rollback();
                        echo "Ha ocurrido un error borrando la imagen actual.";
                    } 
                } else if (!isset($_POST["cat_name"]) && !isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
                    echo "updating description";
                    $stmt = "update categories set description = '".$_POST['cat_desc']."' where id = ".$_POST["cat_id"];
                    if ($conn->query($stmt) == TRUE) {
                        echo "La descripción de la categoría se ha actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar la categoría.";
                    }
                } else if (isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && !isset($_POST["cat_desc"])) {
                    $conn->begin_transaction();
                    $image = "";
                    $stmt = "select image from categories where id = ".$_POST["cat_id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        $image = $rows['image'];
                        $res->free(); //releasing results from RAM.
                    }

                    // updating entry on database
                    $conn->query("update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"]);
                    $conn->query("update categories set name = '".$_POST['cat_name']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."', image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"]);
                    if ($conn->commit()) {
                        unlink($location.$image);
                        move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server
                        echo "La imagen y el nombre de la categoría se han actualizado correctamente.";
                    } else {
                        $conn->rollback();
                        echo "No se ha podido actualizar la categoría.";
                    }
                } else if (!isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
                    $conn->begin_transaction();
                    $image = "";
                    $stmt = "select image from categories where id = ".$_POST["cat_id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        $image = $rows['image'];
                        $res->free(); //releasing results from RAM.
                    }

                    // updating entry on database
                    $conn->query("update categories set description = '".$_POST['cat_desc']."', image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"]);
                    if ($conn->commit()) {
                        unlink($location.$image);
                        move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server
                        echo "La imagen y descripción de la categoría se han actualizado correctamente.";
                    } else {
                        $conn->rollback();
                        echo "No se ha podido actualizar la categoría.";
                    }
                } else if (isset($_POST["cat_name"]) && !isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
                    $conn->begin_transaction();
                    $stmt->query("update categories set name = '".$_POST['cat_name']."', description = '".$_POST['cat_desc']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."' where id = ".$_POST["cat_id"]);
                    $conn->query("update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"]);
                    if ($conn->commit()) {
                        echo "El nombre y la descripción de la categoría se han actualizado correctamente.";
                    } else {
                        $conn->rollback();
                        echo "No se ha podido actualizar la categoría.";
                    }
                } else if (isset($_POST["cat_name"]) && isset($_FILES["cat_file"]) && isset($_POST["cat_desc"])) {
                    $conn->begin_transaction();
                    $image = "";
                    $stmt = "select image from categories where id = ".$_POST["cat_id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        $image = $rows['image'];
                        $res->free(); //releasing results from RAM.
                    }

                    // updating entry on database
                    $conn->query("update categories set name = '".$_POST['cat_name']."', description = '".$_POST['cat_desc']."', friendly_url = '".GetFriendlyUrl($_POST["cat_name"])."', image = '".$_FILES['cat_file']["name"]."' where id = ".$_POST["cat_id"]);
                    $conn->query("update pages set page = 'gallery/".GetFriendlyUrl($_POST["cat_name"])."' where cat_id = ".$_POST["cat_id"]);
                    if ($conn->query($stmt) == TRUE) {
                        unlink($location.$image);
                        move_uploaded_file($_FILES['cat_file']['tmp_name'],$location.$_FILES['cat_file']["name"]); //moving file to the server
                        echo "El nombre, imagen y descripción de la categoría se han actualizado correctamente.";
                    } else {
                        echo "No se ha podido actualizar la categoría.";
                    }
                }

                $categoryUrl = "";
                $sql = "select friendly_url from categories where id = ".$_POST["cat_id"];
                if ($res = $conn->query($sql)) {
                    $categoryUrl = $res->fetch_assoc()["friendly_url"];
                }
                $sitemap = readSitemapXML();
                changeSitemapUrl($sitemap, GetBaseUri()."/"."galeria/".$categoryUrl, GetBaseUri()."/"."galeria/".$categoryUrl);
                writeSitemapXML($sitemap);
            }
            $conn->close(); //closing database connection
        } catch (Exception $e) {
            echo $e;
        }
    }
?>