<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_maintenance_status.php";

    $site_settings = getSiteSettings();
    $conn = new DatabaseConnection(); // Opening database connection.
    $maintenance = getMaintenanceStatus($site_settings);
    
    $page_id = 7;

    if (!$maintenance || ($maintenance && isset($_SESSION["loggedin"]))) { 
        $sql = "select title, description from pages_metadata where id_page = (select id from pages where id = ".$page_id.")";  
        if ($res = $conn->query($sql)) {
            $page_title = $res[0]['title'];
            $page_description = $res[0]['description'];
        }
    } else {
        require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_503_header.php";
        set_503_header();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!$maintenance || ($maintenance && isset($_SESSION["loggedin"]))): ?>
    <title><?=$page_title." | ".$site_settings[2]["value_info"]?></title>
    <meta name="description" content="<?=$page_description?>">
    <meta name="robots" content="index, follow">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5GCTKSYQEQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-5GCTKSYQEQ');
    </script>
    <?php else: ?>
    <title>Página en mantenimiento | <?=$site_settings[2]["value_info"]?></title>
    <?php endif; ?>
    <link rel="canonical" href="<?=GetUri()?>">
    <link rel="icon" href="<?=GetBaseUri()?>/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/fontawesome.all.min.css">  
</head>

<body>
    <?php
    if ($maintenance && !isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_page.php";
        exit();
    }
    if ($maintenance && isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
    }
    include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title">Sobre nosotros</h1>
        <?=$site_settings[9]["value_info"]?>
    </div>

    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
    ?>
    <!-- SB Forms JS -->
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>