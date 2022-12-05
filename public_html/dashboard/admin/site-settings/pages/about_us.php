<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    $about_text = $site_settings[9]["value_info"];
?>
<div class="container content">
    <h1 class="title">Sobre nosotros</h1>
    <p class="title-description">Describe con detalle tu empresa, trayectoria profesional, trabajadores, filosofía... Incluye detalles que capten la atención de los usuarios que visiten el sitio web.</p>
    <p>Recuerda que, idealmente, esta sección deberá tener una extensión media.</p>
    <div id="summernote"></div>
    <div class="button-group-right mt-3">
        <button id="save-about-us" class="btn my-button-3"><i class=" i-margin fas fa-save"></i>Guardar</button>
    </div>
</div>