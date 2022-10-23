<?php
function createXML($data) {
    // $title = $data['title'];
    $rowCount = count($data['url']);
    
    //create the xml document
    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $urlset = $xmlDoc->createElement("urlset");
    $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
    $urlset->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
    $urlset->setAttribute("xsi:schemaLocation", "http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd");
    $root = $xmlDoc->appendChild($urlset);
    
    foreach($data['url'] as $user){
        if(!empty($user)){
            $tabUser = $root->appendChild($xmlDoc->createElement('url'));
            foreach($user as $key=>$val){
                $tabUser->appendChild($xmlDoc->createElement($key, $val));
            }
        }
    }
    
    header("Content-Type: text/plain");
    
    //make the output pretty
    $xmlDoc->formatOutput = true;
    
    //save xml file
    $file_name = "sitemap1.xml";
    $xmlDoc->save($file_name);
    
    //return xml file name
    return $file_name;
}

function changeUrlSitemap(&$arr, $search, $value) {
    for ($i = 0; $i < count($arr); $i++) {
        if($arr[$i]["loc"] == $search) {
            $arr[$i]["loc"] = $value;
            $arr[$i]["lastmod"] = date('Y-m-d\TH:i:s', time())."+00:00";
            $arr[$i]["priority"] = 0.5;
        }
    }

}

function addUrlSitemap(&$arr, $value){
    array_push($arr, array(
        "loc" => $value, 
        "lastmod" => date('Y-m-d\TH:i:s', time())."+00:00",
        "priority" => 0.5
    ));
}

function deleteUrlSitemap(&$arr, $value) {
    for ($i = 0; $i < count($arr); $i++) {
        if($arr[$i]["loc"] == $value) {
            unset($arr[$i]);
        }
    }
}
?>