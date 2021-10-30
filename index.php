<?php
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/connection.php';
    $GLOBALS["site_settings"] = array();
    $GLOBALS["services"] = array();
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        $sql = "select value_info from company_info";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($GLOBALS["site_settings"], $rows['value_info']);
        }

        $sql = "select * from services";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($GLOBALS["services"], array($rows["id"],$rows["title"],$rows["descripion"],$rows["image"]));
        }

        $res->free();
    }
    $GLOBALS["site_settings"][4] = json_decode($GLOBALS["site_settings"][4], true);
    
    $conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseñamos y restauramos tus muebles con madera antigua - ViGal Artesana</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Great Vibes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body>
    <div id="main">
        <?php
            include './includes/header.php';
        ?>
        <div class="index-image-container">
            <img class="index-image wow animate__animated animate__fadeIn" src="./uploads/<?=$GLOBALS["site_settings"][5]?>"></img>
            <div class="index-text-image">
                <h1 class="wow animate__animated animate__fadeInUp"><?=$GLOBALS["site_settings"][6]?></h1>
            </div>
        </div>
        <div class="div-color-1">
            <div class="container">
                <div class="title-description wow animate__animated animate__fadeInUp">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>
                <div class="button-group wow animate__animated animate__fadeInUp">
                    <button onclick="window.location.href = 'sobremi.php'" type="button" class="btn my-button">Sobre nosotros</button>
                    <button onclick="window.location.href = 'galeria.php'" type="button" class="btn my-button">Galería</button>
                    <button onclick="window.location.href = 'galeria.php'" type="button" class="btn my-button">Blog</button>
                </div>
            </div>
        </div>
        <div class="div-color-2">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <h1 class="title wow animate__animated animate__fadeInRight">Nuestros servicios</h1>
                    </div>
                    <div class="col-4 text-right  wow animate__animated animate__fadeInRight">
                        <a class="btn my-button mr-1" href="#services" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left i-no-margin"></i>
                        </a>
                        <a class="btn my-button mr-1" href="#services" role="button" data-slide="next">
                            <i class="fa fa-arrow-right i-no-margin"></i>
                        </a>
                    </div>
                    <div class="col-12">
                        <div id="services" class="carousel slide  wow animate__animated animate__fadeInRight" data-ride="carousel">
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <?php foreach ($GLOBALS["services"] as $service): ?>
                                <div class="carousel-item active">
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-6">
                                                <img src="./uploads/services/<?=$service[3]?>" class="card-img" alt="...">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body align-middle">
                                                    <h5 class="card-title font-weight-bold"><?=$service[1]?></h5>
                                                    <p class="card-text"><?=$service[2]?></p>
                                                    <?php if ($_SESSION['account_type'] == 'admin' || $_SESSION['account_type'] == 'superuser') :?>
                                                        <button type="button" id="new-service" onclick="window.location.href='./dashboard?page=edit-service&id=<?=$service[0]?>'" class="btn my-button"><i class="far fa-edit"></i>Editar</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="div-color-1">
            <div class="container">
                <h1 class="title wow animate__animated animate__fadeInLeft">¿Necesitas más información?</h1>
                <div class="title-description wow animate__animated animate__fadeInLeft">
                    <p class="wow animate__animated animate__fadeInLeft">Si quieres pedir más información, preguntar precios, pedir un presupuesto o preguntar cualquier otra cosa, no dudes en contactar con nosotros. ¡Estaremos encantados de atenderte!</p>
                    <button onclick="window.location.href = 'contacto.php'" type="button" class="btn btn-light my-button wow animate__animated animate__fadeInLeft">Ver información de contacto</button>
                </div>
            </div>
        </div>
        <?php
            include './includes/footer.php';
        ?>
    </div>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="./includes/js/animate-carousel-height-change.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./includes/js/wow-init.js"></script>
    <script>
        $(".carousel").carousel({
            interval: 10000,
            pause: true,
            touch: true,
            keyboard: true
    });
    </script>
</body>
</html>