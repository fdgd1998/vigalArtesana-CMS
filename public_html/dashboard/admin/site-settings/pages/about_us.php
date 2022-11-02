<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    $about_text = $site_settings[9]["value_info"];
?>
<div class="container content">
    <h1 class="title">Sobre nosotros</h1>
    <p class="title-description">Aquí podrás redactar el contenido que aparecerá en la sección <em>"sobre nosotros"</em> del sitio web.</p>
    <div id="summernote"></div>
    <div class="button-group text-right mt-3">
        <button id="save-about-us" class="btn my-button-3"><i class=" i-margin fas fa-save"></i>Guardar</button>
    </div>
</div>