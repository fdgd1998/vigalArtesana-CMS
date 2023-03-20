<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/image_compression.php';

    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    
    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/images/"; // location for gallery images.
        $categories = json_decode($_POST["categories"], true);
        echo var_dump($categories);
        $altText = json_decode($_POST["alt_text"], true);
        echo var_dump($alt_text);
        $categories_values = array_values($categories);

        // Getting images from database before adding new ones
        $countImagesBefore = array();
        $countImagesAfter = array();

        $categoriesUnique = array_values(array_unique($categories_values));

        for ($i = 0; $i < count($categoriesUnique); $i++) {
            $sql = "select count(id) from gallery where category = ".$categoriesUnique[$i];
            if ($res = $conn->query($sql)) {
                $countImagesBefore[intval($categoriesUnique[$i])] = $res[0]["count(id)"];
            } else {
                $countImagesBefore[intval($categoriesUnique[$i])] = 0;
            }
        }


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
            exec('install -d -m 0755 '.$location.$directory);
        }

        $sql = "select id from users where username = '".$_SESSION['user']."'";
        if ($res = $conn->query($sql)) {
            $userid = $res[0]['id'];
            $i = 0;

            foreach ($_FILES as $file) {
                $sql = "insert into gallery (filename,dir,category,altText,uploadedBy) values ('".$file["name"]."','".$directory."',".$categories[$file["name"]].",'".$altText[$file["name"]]."','".$_SESSION["user"]."')";
                
                if ($conn->exec($sql)) {
                    uploadAndCompressImage($location.$directory, $file);
                    // move_uploaded_file($file['tmp_name'],$location.$directory.$file["name"]); // Moving file to the server.
                }
                $i++;
            }

            for ($i = 0; $i < count($categoriesUnique); $i++) {
                $sql = "select count(id) from gallery where category = ".$categoriesUnique[$i];
                if ($res = $conn->query($sql)) {
                    $countImagesAfter[intval($categoriesUnique[$i])] = $res[0]["count(id)"];
                }
            }
            
            $totalPagesBefore = array();
            $totalPagesUpdate = array();
            $totalPagesNew = array();
            $categoriesUniqueValues = array_values($categoriesUnique);
            $categoriesUniqueKeys = array_keys($categoriesUnique);
            $categoriesFriendlyUrl = array();

            if (count($countImagesBefore) == 0) {
                foreach ($countImagesAfter as $key => $value) {
                    $countImagesBefore[$key] = 0;
                }
            }

            $sql = "select id, friendly_url from categories where id in(".implode(",", $categoriesUnique).")";
            if ($res = $conn->query($sql)) {
                foreach ($res as $item) {
                    $categoriesFriendlyUrl[$item["id"]] = $item["friendly_url"];
                }
            }

            foreach($categoriesUniqueValues as $key => $value) {
                $imagesBefore = $countImagesBefore[$value];
                $imagesAfter = $countImagesAfter[$value];
                $pagesBefore = 0;
                $pagesAfter = 0;
                $pagesModified = 0;
                $pagesNew = 0;

                $pagesBefore = ceil($imagesBefore / 12);
                $pagesAfter = ceil($imagesAfter / 12);
                $pagesModified = ($pagesBefore == 0 && $pagesAfter == 1) ? 1 : (($pagesBefore % 12 != 0) ? 1 : 0);

                if ($pagesBefore == 0) $pagesNew = 0;
                else $pagesNew = ($pagesBefore == $pagesAfter) ? 0 : $pagesAfter - $pagesModified;

                $totalPagesBefore[$value] = $pagesBefore;
                $totalPagesUpdate[$value] = $pagesModified;
                $totalPagesNew[$value] = $pagesNew;

            }

            $sitemap = readSitemapXML();

            foreach ($totalPagesUpdate as $key => $value) {
                if ($value != 0)  {
                    $url = GetBaseUri()."/"."galeria/".$categoriesFriendlyUrl[$key].($totalPagesBefore[$key] == 0 ? "" : ($totalPagesBefore[$key] != 1 ? "/".$totalPagesBefore[$key]: ""));
                    changeSitemapUrl($sitemap, $url, $url);
                }
            }
            foreach ($totalPagesNew as $key => $value) {
                if ($value != 0)  {
                    $url = GetBaseUri()."/"."galeria/".$categoriesFriendlyUrl[$key]."/".($totalPagesBefore[$key] + 1);
                    addSitemapUrl($sitemap, $url);
                }
            }

            writeSitemapXML($sitemap);

            echo "Las imágenes se han subido correctamente.";
        } else {
            echo "Ha ocurrido un error subiendo las imágenes.";
        }
    }
?>