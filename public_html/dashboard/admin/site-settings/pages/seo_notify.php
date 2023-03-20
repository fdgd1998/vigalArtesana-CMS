<?php

    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
?>
<div class="container content">
    <h1 class="title">Notificar cambios a motores de búsqueda</h1>
    <p><strong>NOTA: esta página actualmente solo está presente para su visualización de una característica futura. Cualquier acción realizada no realizará modificaciones en el sitio web.</strong></p>
    <p class="title-description">Notifica los cambios que se realizan en el sitio web a los motores de búsqueda. Es necesario realizar esta acción cada vez que se:</p>
    <ul style="list-style-type: disc; padding-left: 30px;">
        <li>Crea, modifica o elimina una categoría.</li>
        <li>Modifica la descripción de la galería.</li>
        <li>Borran o eliminan imágenes de la galería.</li>
        <li>Crear, modifica o elimina un servicio.</li>
        <li>Modifican los datos de la página de contacto.</li>
        <li>Modifican los datos de la págian sobre nosotros.</li>
        <li>Modifican los datos de la página principal.</li>
    </ul>
    <div class="alert alert-info" role="alert">
        Avisa a los motores de búsqueda solo cuando subas un sitemap nuevo o modifiques uno que ya tengas. No envíes varias veces un sitemap que no hayas modificado, ni tampoco les hagas ping en este caso.
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <img height="30" style="border-radius: 0px !important; margin-bottom: 20px;" src="<?=GetBaseUri()."/dashboard/includes/img/bing-logo.png"?>">
                    <p class="card-text">Informa de los cambios a través de la API de IndexNow.</p>
                    <a href="#" class="btn my-button">Notificar a Bing</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <img height="30" style="border-radius: 0px !important; margin-bottom: 20px;" src="<?=GetBaseUri()."/dashboard/includes/img/google-logo.png"?>">
                    <p class="card-text">Informa de los cambios a través de API de Google Search Console.</p>
                    <a href="#" class="btn my-button">Notificar a Google</a>
                </div>
            </div>
        </div>
    </div>
</div>