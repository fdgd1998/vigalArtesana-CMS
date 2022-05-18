<?php
    error_reporting(0);
    session_start(); // starting the session.
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_companySettings")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    $about_text = "";
    
    try {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $stmt = "select value_info from company_info where key_info = 'about-us'";
            if ($res = $conn->query($stmt)) {
                $about_text = $res->fetch_assoc()["value_info"];
                $res->free();
            }
        }
        $conn->close();
    } catch (Exception $e) {

    }
?>
<div class="container content">
    <h1 class="title">Sobre nosotros</h1>
    <p class="title-description">Aquí podrás redactar el contenido que aparecerá en la sección <em>"sobre nosotros"</em> del sitio web.</p>
    <div id="summernote"></div>
    <div class="button-group text-right mt-3">
        <button id="save-about-us" class="btn my-button"><i class="far fa-save"></i>Guardar</button>
    </div>
</div>
<? if ($about_text != ""): ?>

<? endif; ?>