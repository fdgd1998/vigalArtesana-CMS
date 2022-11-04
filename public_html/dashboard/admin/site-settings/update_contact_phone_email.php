<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/get_uri.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/XMLSitemapFunctions.php";
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/database_connection.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }


    if (isset($_POST)) {
        $conn = new DatabaseConnection();
        $sql = array (
            "update company_info set value_info='".$_POST["phone"]."' where key_info='phone'",
            "update company_info set value_info='".$_POST["email"]."' where key_info='email'"
        );

        if ($conn->transaction($sql)) {
            $url = array(
                GetBaseUri(),
                GetBaseUri()."/galeria",
                GetBaseUri()."/contacto",
                GetBaseUri()."/sobre-nosotros",
                GetBaseUri()."/politica-privacidad",
                GetBaseUri()."/aviso-legal"
            );

            $id = array();
            $total_pages = array();

            $sql = "select id, friendly_url from categories";
            if ($res = $conn->query($sql)) {
                foreach ($res as $item) {
                    array_push($id, $item["id"]);
                    array_push($url, GetBaseUri()."/galeria/".$item["friendly_url"]);
                }
            }

            foreach ($id as $item) {
                $sql = "select count(gallery.id) as id, friendly_url from gallery inner join categories on gallery.category = categories.id where gallery.category = $item";
                if ($res = $conn->query($sql)[0]) {
                    $aux = intdiv($res["id"], 12);
                    $aux += ($res["id"] % 12 > 0)? 1 : 0;
                    $total_pages[$res["friendly_url"]] = $aux;
                }
            }

            foreach ($total_pages as $key => $value) {
                for ($i = 2; $i <= $value; $i++) {
                    array_push($url, GetBaseUri()."/galeria/$key/$i");
                }
            }
            $sitemap = readSitemapXML();

            foreach ($url as $item) {
                changeSitemapUrl($sitemap, $item, $item);
            }
            writeSitemapXML($sitemap);
            echo "Los datos de contacto se han modificado correctamente.";
        } else {
            echo "Ha ocurrido un error al modificar los datos de contacto.";
        }
    }
?>