<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_seoSettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    function showSeoMessage() {
        require dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        
        try {
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                $sql = "update company_info set value_info='true' where key_info='seo_modified'";
                $conn->query($sql);
            }
            $conn->close();
        } catch (Exception $e) {
            $conn->rollback();
            echo $e;
        }
    }

    function readSitemapXML() {
        //read entire file into string
        $xmlfile = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/sitemap.xml");

        //convert xml string into an object
        $xml = simplexml_load_string($xmlfile);

        // convert into json
        $json  = json_encode($xml);

        //convert into associative array
        return json_decode($json, true);
    }

    function writeSitemapXML($data) {
        // $title = $data['title'];
        $rowCount = count($data['url']);
        
        //create the xml document
        $xmlDoc = new DOMDocument("1.0", "UTF-8");
        $urlset = $xmlDoc->createElement("urlset");
        $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
        $urlset->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $urlset->setAttribute("xsi:schemaLocation", "http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd");
        $root = $xmlDoc->appendChild($urlset);
        
        foreach($data['url'] as $url){
            if(!empty($url)){
                $tabUrl = $root->appendChild($xmlDoc->createElement('url'));
                foreach($url as $key=>$val){
                    $tabUrl->appendChild($xmlDoc->createElement($key, $val));
                }
            }
        }
        
        header("Content-Type: text/plain");
        
        //make the output pretty
        $xmlDoc->formatOutput = true;
        
        //save xml file
        $file_name = $_SERVER["DOCUMENT_ROOT"]."/sitemap.xml";

        if ($xmlDoc->save($file_name)) {
            showSeoMessage();
            return true;
        }
            
        //return xml file name
        return false;
    }

    function changeSitemapUrl(&$arr, $search, $value) {
        for ($i = 0; $i < count($arr["url"]); $i++) {
            if($arr["url"][$i]["loc"] == $search) {
                $arr["url"][$i]["loc"] = $value;
                $arr["url"][$i]["lastmod"] = date('Y-m-d\TH:i:sP', time());
                $arr["url"][$i]["priority"] = 0.5;
            }
        }

    }

    function addSitemapUrl(&$arr, $value){
        array_push($arr["url"], array(
            "loc" => $value, 
            "lastmod" => date('Y-m-d\TH:i:sP', time()),
            "priority" => 0.5
        ));
    }

    function deleteSitemapUrl(&$arr, $value) {
        for ($i = 0; $i < count($arr["url"]); $i++) {
            if($arr["url"][$i]["loc"] == $value) {
                unset($arr["url"][$i]);
            }
        }
    }
?>