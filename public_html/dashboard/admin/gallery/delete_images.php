<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_gallery")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    function dirIsEmpty($dir) {
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
            closedir($handle);
            return false;
            }
        }
        closedir($handle);
        return true;
    }

    if (isset($_POST["filenames"])) {
        $conn = new DatabaseConnection();
        $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/images/";
        $filenames = json_decode($_POST["filenames"], true);
        $dir = json_decode($_POST["directories"], true);
        $categories = json_decode($_POST["categories"], true);

        $countImagesBefore = array();
        $countImagesAfter = array();
        $categoriesUnique = array_values(array_unique($categories));

        for ($i = 0; $i < count($categoriesUnique); $i++) {
            $sql = "select count(id) from gallery where category = ".$categoriesUnique[$i];
            if ($res = $conn->query($sql)) {
                $row = $res[0]["count(id)"];
                $countImagesBefore[intval($categoriesUnique[$i])] = $row;
            } else {
                $countImagesBefore[intval($categoriesUnique[$i])] = 0;
            }
        }

        $images = "'".implode("','", $filenames)."'";

        $sql = "update gallery set deletedBy = ".$_SESSION["userid"]." where filename in(".$images.")";
        $conn->exec($sql);
        
        $sql= "delete from gallery where filename in(".$images.")";

        if ($conn->exec($sql)) {
            for ($i = 0; $i < count($filenames); $i++) {
                unlink($location.$dir[$i].$filenames[$i]); // deleting the file
                if (dirIsEmpty($location.$dir[$i])) {
                    rmdir($location.$dir[$i]);
                }

                if (dirIsEmpty($location.substr($dir[$i], 0, 8))) {
                    rmdir($location.substr($dir[$i], 0, 8));
                }

                if (dirIsEmpty($location.substr($dir[$i], 0, 5))) {
                    rmdir($location.substr($dir[$i], 0, 5));
                }

            }

            for ($i = 0; $i < count($categoriesUnique); $i++) {
                $sql = "select count(id) from gallery where category = ".$categoriesUnique[$i];
                if ($res = $conn->query($sql)) {
                    $row = $res[0]["count(id)"];
                    $countImagesAfter[intval($categoriesUnique[$i])] = $row;
                }
            }
            
            $totalPagesBefore = array();
            $totalPagesUpdate = array();
            $totalPagesDelete = array();
            $categoriesUniqueValues = array_values($categoriesUnique);
            $categoriesUniqueKeys = array_keys($categoriesUnique);
            $categoriesFriendlyUrl = array();

            if (count($countImagesAfter) == 0) {
                foreach ($countImagesBefore as $key => $value) {
                    $countImagesAfter[$key] = 0;
                }
            }

            foreach($categoriesUniqueValues as $key => $value) {
                $imagesBefore = $countImagesBefore[$value];
                $imagesAfter = $countImagesAfter[$value];
                $pagesBefore = 0;
                $pagesAfter = 0;
                $pagesModified = 0;
                $pagesDelete = 0;

                $pagesBefore = ceil($imagesBefore / 12);
                $pagesAfter = ceil($imagesAfter / 12);
                $pagesModified = ($pagesBefore == 1 && $pagesAfter == 0) ? 1 : (($pagesAfter % 12 != 0) ? 1 : 0);

                if ($pagesBefore == 0) $pagesDelete = 0;
                else $pagesDelete = ($pagesBefore == $pagesAfter) ? 0 : $pagesBefore - $pagesModified;

                $totalPagesBefore[$value] = $pagesBefore;
                $totalPagesUpdate[$value] = $pagesModified;
                $totalPagesDelete[$value] = $pagesDelete;

            }

            $sql = "select id, friendly_url from categories where id in(".implode(",", $categoriesUnique).")";
            if ($res = $conn->query($sql)) {
                foreach ($res as $item) {
                    $categoriesFriendlyUrl[$item["id"]] = $item["friendly_url"];
                }
            }

            $sitemap = readSitemapXML();

            foreach ($totalPagesUpdate as $key => $value) {
                if ($value != 0)  {
                    $url = GetBaseUri()."/"."galeria/".$categoriesFriendlyUrl[$key].($totalPagesBefore[$key] == 0 ? "" : ($totalPagesBefore[$key] != 1 ? "/".$totalPagesBefore[$key]: ""));
                    changeSitemapUrl($sitemap, $url, $url);
                }
            }
            foreach ($totalPagesDelete as $key => $value) {
                if ($value != 0)  {
                    $url = GetBaseUri()."/"."galeria/".$categoriesFriendlyUrl[$key]."/".($totalPagesBefore[$key]);
                    deleteSitemapUrl($sitemap, $url);
                }
            }

            writeSitemapXML($sitemap);

            echo "Las imágenes se han eliminado correctamente.";
        } else {
            echo "Ha ocurrido un error.";
        }
    }
?>