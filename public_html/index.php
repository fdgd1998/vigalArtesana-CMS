<?php
    require_once "scripts/get_company_info.php";

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $services = array(); // Array to save categories

    try {
        if ($conn->connect_error) {
            echo "No se ha podido establecer una conexión con la base de datos.";
            exit();
        } else {
            // Fetching categories from database and storing then in the array for further use.
            $sql = "select * from services";
            if ($res = $conn->query($sql)) {
                while ($rows = $res->fetch_assoc()) {
                    array_push($services, array($rows["id"], $rows["title"], $rows["description"], $rows["image"]));
                }
                $res->free();
            }
        }
    } catch (Exception $e) {
        echo $e;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseñamos y restauramos tus muebles con madera antigua - <?=$GLOBALS["site_settings"][2]?></title>
    <meta name="description" content="Artesanía y restauración con madera antigua, muebles y objetos decorativos de madera.">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="includes/css/styles.css">
    <link rel="stylesheet" href="includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Great Vibes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5GCTKSYQEQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-5GCTKSYQEQ');
    </script>
</head>

<body>
    <div id="main">
        <?php
            require_once "scripts/check_maintenance.php";
            include 'includes/header.php';
        ?>
        <div class="index-image-container">
            <img class="index-image wow animate__animated animate__fadeIn" src="<?=(isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]?>/uploads/<?=$GLOBALS["site_settings"][5]?>"></img>
            <div class="index-text-image">
                <h1 class="wow animate__animated animate__fadeInUp"><?=$GLOBALS["site_settings"][6]?></h1>
            </div>
        </div>
        <div class="div-color-1">
            <div class="container">
                <div class="index-description wow animate__animated animate__fadeInUp">
                    <p><?=$GLOBALS["site_settings"][10]?></p>
                </div>
                <div class="button-group wow animate__animated animate__fadeInUp">
                    <a href="<?=(isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]?>/sobre-nosotros" class="btn my-button">Sobre nosotros</a>
                    <a href="<?=(isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]?>/galeria" class="btn my-button">Galería</a>
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
                                <?php foreach ($GLOBALS["services"] as $service): ?>
                                <div class="carousel-item <?=$i == 0? "active":""?>">
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-6">
                                                <img src="<?=(isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]?>/uploads/services/<?=$service[3]?>" class="card-img" alt="<?=$service[1]?>">
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
                    <a href = "<?=(isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["SERVER_NAME"]?>/contacto" class="btn btn-light my-button wow animate__animated animate__fadeInUp">Ver información de contacto</a>
                </div>
            </div>
        </div>
        <?php
            include 'includes/footer.php';
        ?>
    </div>
    <script src="includes/js/jquery.min.js"></script>
    <script src="includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="includes/js/wow-init.js"></script>
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