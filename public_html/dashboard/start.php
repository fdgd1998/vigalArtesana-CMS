<?php
    session_start();

    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';

    if (!HasPermission("standard_user")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }
    echo var_dump($_SESSION);
?>
<div class="container">
    <h1 class="text-center" style="margin-top: 10%;">¡Hola <?=$_SESSION['user']?>!</h1>
    <h1 class="text-center" style="margin-top: 5%;font-size: 28px;">Navega por las distintas páginas usando los menús de navegación para configurar el sitio o gestionar el contenido.</h1>
</div>