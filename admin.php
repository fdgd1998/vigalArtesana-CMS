<?php
    $GLOBALS['key'] = 'iVGGIVlMBE5XnPopdS+v350+PnJb+uZ1Ae2cH3vp2sg=';
    function OpenSSLEncrypt($data) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($GLOBALS['key']);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }
     
    function OpenSSLDecrypt($data) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($GLOBALS['key']);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
    echo "contraseña sin encriptar: th3_l4st_0f_us<br>";
    $encpass = OpenSSLEncrypt("th3_l4st_0f_us");
    echo "contraseña encriptada: ".$encpass."<br><br>";
    echo "contraseña encriptada: ".$encpass."<br>";
    echo "contraseña desencriptada: ".OpenSSLDecrypt($encpass);
    echo "nombre: ".OpenSSLEncrypt("Francisco")."<br>";
    echo "apellidos: ".OpenSSLEncrypt("Gálvez Díaz")."<br>";
?>