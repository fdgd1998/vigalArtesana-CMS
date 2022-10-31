<?php

    session_start();
    
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_siteSettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $site_settings = array();

    try {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        
        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $stmt = "select value_info from company_info where key_info = 'maintenance'";
            if ($res = $conn->query($stmt)) {
                while ($rows = $res->fetch_assoc()) {
                    array_push($site_settings, $rows["value_info"]);
                }
            }
        }
        $conn->close();
    } catch (Exception $e) {
        echo $e;
    }
?>
<div class="container settings-container">
    <h1 class="title">Opciones avanzadas</h1>
    <form style="margin-bottom: 20px;">
        <div class="form-row">
            <div class="col">
                <h3 class="title"><i class="i-margin fas fa-toolbox"></i>Modo de mantenimiento</h3>
                <p class="title-description">Es recomendable activar el modo de mantenimiendo cuando se van a realizar cambios en la estructura o el código de los archivos del sistema de gestión de contenidos.</p>
                <p> Mientras este modo esté activado, los usuarios no pdrán navegar por el sitio web y verán un aviso inicando que el sitio está en mantenimiento.</p>
                <p>Mientras este modo esté activo, solo podrás navegar por la web iniciando sesión.</p>
            </div>
        </div>
        <div class="form-row text-right">
            <div class="col">
                <?php if ($site_settings[0] != "true"): ?>
                    <button id="maintenance-on" class="btn my-button-3" type="button"><i class="i-margin fas fa-arrow-up"></i>Activar</button>
                <?php else: ?>
                    <button id="maintenance-off" class="btn my-button-2" type="button"><i class="i-margin fas fa-arrow-down"></i>Desactivar</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>