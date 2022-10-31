<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        include_once $_SERVER["DOCUMENT_ROOT"]."/errorpages/403.php";
        exit();
    }
?>
<div class="container-fluid warning-message">
    <p> <i class="i-margin fas fa-exclamation-triangle"></i>El modo de mantenimiento está activado. Puedes ver el sitio web porque has iniciado sesión, pero no estará disponible en internet hasta que lo desactives. Puedes desactivarlo <u><a href="<?=GetBaseUri()?>/dashboard?page=advanced">aquí</a></u>.</p>
</div>