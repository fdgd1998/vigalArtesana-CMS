<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_error_header.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    $site_settings = getSiteSettings();
    if ($site_settings[11]["value_info"] == "false") {
        set_404_header();
    } else {
        set_503_header();
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($site_settings[11]["value_info"] == "false"): ?>
    <title>No encontrado - <?=$site_settings[2]["value_info"]?></title>
    <?php else: ?>
    <title>Página en mantenimiento - <?=$site_settings[2]["value_info"]?></title>
    <?php endif; ?>
    <link rel="icon" href="<?=GetBaseUri()?>/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/fontawesome.all.min.css">
</head>

<body>
    <?php
        if ($site_settings[11]["value_info"] == "false") {
            include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
            include $_SERVER["DOCUMENT_ROOT"].'/snippets/404.php';
            include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
        } else if ($site_settings[11]["value_info"] == "true" && isset($_SESSION["loggedin"])){
            include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
            include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
            include $_SERVER["DOCUMENT_ROOT"].'/snippets/404.php';
            include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
        } else {
            include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_page.php";
        }
        
    ?>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>