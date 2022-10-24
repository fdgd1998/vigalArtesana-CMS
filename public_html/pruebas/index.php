<?php

require_once "XMLSitemapFunctions.php";
//xml file path
$path = "sitemap.xml";

//read entire file into string
$xmlfile = file_get_contents($path);

//convert xml string into an object
$xml = simplexml_load_string($xmlfile);

// convert into json
$json  = json_encode($xml);

//convert into associative array
$xmlArr = json_decode($json, true);
// $key = array_search("https://vigalartesana.es/contacto", array_column($xmlArr, 'loc'));
// echo "clave encontrada: ".$key;
echo "<br><br>";
print_r($xmlArr["url"]);

changeUrlSitemap($xmlArr["url"], "https://vigalartesana.es/", "holamundo");
echo "<br><br>";
print_r($xmlArr["url"]);

addUrlSitemap($xmlArr["url"], "https://vigalartesana.es/asdhfkshfd",);
echo "<br><br>";
print_r($xmlArr["url"]);

// deleteUrlSitemap($xmlArr["url"], "https://vigalartesana.es/asdhfkshfd",);
// echo "<br><br>";
// print_r($xmlArr["url"]);
// print_r($xmlArr["url"]);
// echo searchAndChangeValue($xmlArr["url"][0], "https://vigalartesana.es/contacto", "holamundo");

echo "<br><br>";
echo createXML($xmlArr);

?>