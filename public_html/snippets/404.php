<?php 
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
?>
<div class="container content">
    <h1 class="title"><i class="i-margin far fa-question-circle"></i>No encontrado</h1>
    <p class="title-description">El recurso al que intentas acceder no existe en este servidor. Comprueba que la URL sea correcta e inténtalo de nuevo.</p>
</div>