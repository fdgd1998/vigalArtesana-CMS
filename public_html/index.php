<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_maintenance_status.php";

    // $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $site_settings = getSiteSettings();
    $maintenance = getMaintenanceStatus($site_settings);
    $conn = new DatabaseConnection(); // Opening database connection.

    $services = array(); // Array to save categories
    $page_id = 5;

    if (!$maintenance || ($maintenance && isset($_SESSION["loggedin"]))) {
        // Fetching categories from database and storing then in the array for further use.
        $sql = "select * from services";
        if ($res = $conn->query($sql)) {
            foreach ($res as $item) {
                array_push($services, array($item["id"], $item["title"], $item["description"], $item["image"]));
            }
        }

        // Getting page metadata
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
    <title><?=$page_title?> | <?=$site_settings[2]["value_info"]?></title>
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
    <link rel="canonical" href="<?=GetUri();?>">
    <link rel="icon" href="<?=GetBaseUri()?>/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/fontawesome.all.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/flag-icon.css">
</head>

<body>
    <?php
    if ($maintenance && !isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_page.php";
        exit();
    }
    ?>
    <div id="main">

        <?php
            if ($maintenance && isset($_SESSION["loggedin"])) {
                include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
            }
            include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
        ?>
        <div class="index-image-container">
            <img class="index-image" src="<?=GetBaseUri()?>/uploads/<?=$site_settings[5]["value_info"]?>" alt="<?=$site_settings[14]["value_info"]?>"></img>
            <div class="index-text-image">
                <h1 class="wow"><?=$site_settings[6]["value_info"]?></h1>
            </div>
        </div>
        <div class="div-color-1">
            <div class="container">
                <div class="index-description">
                    <p><?=$site_settings[10]["value_info"]?></p>
                </div>
                <div class="button-group">
                    <a href="<?=GetBaseUri()?>/sobre-nosotros" class="btn my-button">Sobre nosotros</a>
                    <a href="<?=GetBaseUri()?>/galeria" class="btn my-button">Galería</a>
                </div>
            </div>
        </div>
        <div id="services-section" class="div-color-2">
            <div class="container">
                <h1 class="title">Nuestros servicios</h1>
                <div class="row">
                    <div class="col-12 carousel-buttons">
                        <a class="btn my-button mr-1" href="#services" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left i-no-margin"></i>
                        </a>
                        <a class="btn my-button mr-1" href="#services" role="button" data-slide="next">
                            <i class="fa fa-arrow-right i-no-margin"></i>
                        </a>
                    </div>
                    <div class="col-12">
                        <div id="services" class="carousel slide" data-ride="carousel">
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <?php $i = 0; ?>
                                <?php foreach ($services as $service): ?>
                                <div class="carousel-item <?=$i == 0? "active":""?>">
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-6">
                                                <img src="<?=GetBaseUri()?>/uploads/services/<?=$service[3]?>" class="card-img" alt="<?=$service[1]?>">
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <div class="card-body align-self-center">
                                                    <h4 class="card-title font-weight-bold"><?=$service[1]?></h4>
                                                    <p class="card-text"><?=$service[2]?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="div-color-1">
            <div class="container">
                <h1 class="title">¿Necesitas más información?</h1>
                <div class="title-description">
                    <p>Si quieres pedir más información, preguntar precios, pedir un presupuesto o preguntar cualquier otra cosa, no dudes en contactar con nosotros. ¡Estaremos encantados de atenderte!</p>
                    <a href = "<?=GetBaseUri()?>/contacto" class="btn btn-light my-button">Ver información de contacto</a>
                </div>
            </div>
        </div>
        <?php
            include 'includes/footer.php';
        ?>
    </div>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/change-navbar-color.js"></script>
    <script>
    //     $("#services").carousel({
    //         interval: 10000,
    //         pause: true,
    //         touch: true,
    //         keyboard: true
    // });
    </script>
</body>
</html>