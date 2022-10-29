<?php

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
        if ($xmlDoc->save($file_name))
            return true;
        
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