<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_company_info.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_maintenance.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_error_header.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    set_410_header();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurso eliminado - ViGal Boutique</title>
    <link rel="icon" href="./includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/fontawesome.all.min.css">
</head>

<body>
    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title"><i class="i-margin far fa-exclamation"></i>Recurso eliminado</h1>
        <p class="title-description">El recurso al que intentas ha sido borrado de este servidor. Comprueba que la URL sea correcta e inténtalo de nuevo.</p>
    </div>
        
    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
    ?>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>