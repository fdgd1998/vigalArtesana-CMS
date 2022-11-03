<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";

    $site_settings = getSiteSettings();
    $conn = new DatabaseConnection(); // Opening database connection.

    $services = array(); // Array to save categories
    $page_id = 5;

    if ($site_settings[11]["value_info"] == "false" || ($site_settings[11]["value_info"] == "true" && isset($_SESSION["loggedin"]))) {
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
    <?php if ($site_settings[11]["value_info"] == "false"): ?>
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
    <title>Página en mantenimiento</title>
    <?php endif; ?>
    <link rel="canonical" href="<?=GetUri();?>">
    <link rel="icon" href="<?=GetBaseUri()?>/includes/img/favicon.ico" type="image/x-icon">
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
    if ($site_settings[11]["value_info"] == "true" && !isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_page.php";
        exit();
    }
    ?>
    <div id="main">

        <?php
            if ($site_settings[11]["value_info"] == "true" && isset($_SESSION["loggedin"])) {
                include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
            }
            include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
        ?>
        <div class="index-image-container">
            <img class="index-image wow animate__animated animate__fadeIn" src="<?=GetBaseUri()?>/uploads/<?=$site_settings[5]["value_info"]?>"></img>
            <div class="index-text-image">
                <h1 class="wow animate__animated animate__fadeInUp"><?=$site_settings[6]["value_info"]?></h1>
            </div>
        </div>
        <div class="div-color-1">
            <div class="container">
                <div class="index-description wow animate__animated animate__fadeInUp">
                    <p><?=$site_settings[10]["value_info"]?></p>
                </div>
                <div class="button-group wow animate__animated animate__fadeInUp">
                    <a href="<?=GetBaseUri()?>/sobre-nosotros" class="btn my-button">Sobre nosotros</a>
                    <a href="<?=GetBaseUri()?>/galeria" class="btn my-button">Galería</a>
                </div>
            </div>
        </div>
        <div id="services-section" class="div-color-2">
            <div class="container">
            <h1 class="title wow animate__animated animate__fadeInUp">Nuestros servicios</h1>
                <div class="row">
                    <div class="col-12 carousel-buttons wow animate__animated animate__fadeInUp">
                        <a class="btn my-button mr-1" href="#services" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left i-no-margin"></i>
                        </a>
                        <a class="btn my-button mr-1" href="#services" role="button" data-slide="next">
                            <i class="fa fa-arrow-right i-no-margin"></i>
                        </a>
                    </div>
                    <div class="col-12">
                        <div id="services" class="carousel slide  wow animate__animated animate__fadeInUp" data-ride="carousel">
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
                <h1 class="title wow animate__animated animate__fadeInUp">¿Necesitas más información?</h1>
                <div class="title-description wow animate__animated animate__fadeInUp">
                    <p class="wow animate__animated animate__fadeInUp">Si quieres pedir más información, preguntar precios, pedir un presupuesto o preguntar cualquier otra cosa, no dudes en contactar con nosotros. ¡Estaremos encantados de atenderte!</p>
                    <a href = "<?=GetBaseUri()?>/contacto" class="btn btn-light my-button wow animate__animated animate__fadeInUp">Ver información de contacto</a>
                </div>
            </div>
        </div>
        <?php
            include 'includes/footer.php';
        ?>
    </div>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?=GetBaseUri()?>/includes/js/wow-init.js"></script>
    <script>
        $("#services").carousel({
            interval: 10000,
            pause: true,
            touch: true,
            keyboard: true
    });
    </script>
</body>
</html>