<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_company_info.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_maintenance.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_error_header.php";
    set_403_header();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso prohibido - ViGal Artesana</title>
    <link rel="icon" href="/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Great Vibes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body>
    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title"><i class="i-margin fas fa-ban"></i>Acceso prohibido</h1>
        <p class="title-description">No tienes acceso al recurso solicitado. Verifica que tienes permisos para acceder a este recurso e inténtalo de nuevo.</p>
    </div>
        
    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
    ?>
        <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
        <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=GetBaseUri()?>/includes/js/popper.min.js"></script>
</body>
</html>