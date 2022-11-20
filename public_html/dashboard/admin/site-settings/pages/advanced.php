<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_permissions.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    if (!HasPermission("manage_advancedSettings")) {
        include $_SERVER["DOCUMENT_ROOT"]."/dashboard/includes/forbidden.php";
        exit();
    }

?>
<div class="container settings-container">
    <h1 class="title">Opciones avanzadas</h1>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="fa-solid fa-screwdriver-wrench"></i>Modo de mantenimiento</h3>
                <p class="title-description">Es recomendable activar el modo de mantenimiendo cuando se van a realizar cambios en la estructura o el código de los archivos del sistema de gestión de contenidos.</p>
                <p> Mientras este modo esté activado, los usuarios no pdrán navegar por el sitio web y verán un aviso inicando que el sitio está en mantenimiento.</p>
                <p>Mientras este modo esté activo, solo podrás navegar por la web iniciando sesión.</p>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col">
                <?php if ($site_settings[11]["value_info"] != "true"): ?>
                    <button id="maintenance-on" class="btn my-button-3" type="button"><i class="i-margin fas fa-arrow-up"></i>Activar</button>
                <?php else: ?>
                    <button id="maintenance-off" class="btn my-button-2" type="button"><i class="i-margin fas fa-arrow-down"></i>Desactivar</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>