<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        include_once $_SERVER["DOCUMENT_ROOT"]."/errorpages/403.php";
        exit();
    }
?>
<div class="seo-warning">
<i class="i-margin fab fa-searchengin"></i>Es necesario notificar los cambios del sitio web a los motores de búsqueda. Puedes hacerlo desde <a href="<?=GetBaseUri()."/dashboard?page=seo-notify"?>"><u>este enlace</u></a>.
</div>