<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/check_maintenance.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_error_header.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    $site_settings = getSiteSettings();
    set_404_header();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No encontrado | <?=$site_settings[2]["value_info"]?></title>
    <link rel="icon" href="<?=GetBaseUri()?>/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Great Vibes">
</head>

<body>
    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
        include $_SERVER["DOCUMENT_ROOT"].'/snippets/404.php';
        include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
    ?>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>