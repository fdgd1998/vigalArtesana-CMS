<?php 
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
?>
<div class="container content">
    <h1 class="title"><i class="i-margin fas fa-ban"></i>Acceso prohibido</h1>
    <p class="title-description">No tienes acceso al recurso solicitado. Verifica que tienes permisos para acceder a este recurso e inténtalo de nuevo.</p>
</div>