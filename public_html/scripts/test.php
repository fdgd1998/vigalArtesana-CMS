<?php
    require_once "XMLSitemapFunctions.php";

    $sitemap = readSitemapXML();
    var_dump($sitemap);

    changeSitemapUrl($sitemap, "https://vigalartesana.es/contacto", "holamundo");
    echo "<br><br>";
    var_dump($sitemap);
?>