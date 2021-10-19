<?php
    require_once "crypt.php";
    //echo "clave de encriptado: ".base64_encode(openssl_random_pseudo_bytes(32));
    echo "usuario: frang<br>";
    echo "clave: th3_l4st_0f_us, encriptada: ".OpenSSLEncrypt("th3_l4st_0f_us")."<br>";
    echo "email: fran_gd_1998@outlook.es, encriptado: ".OpenSSLEncrypt("fran_gd_1998@outlook.es")."<br>";
    echo "nombre: Francisco, encriptado: ".OpenSSLEncrypt("Francisco")."<br>";
    echo "nombre: Gálvez, encriptado: ".OpenSSLEncrypt("Gálvez")."<br>";
?>